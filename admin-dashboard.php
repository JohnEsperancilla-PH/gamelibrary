<?php
include 'db.php';
include 'checker.php';

// Check if the user is an admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: view-games.php"); // Redirect to a different page if not an admin
    exit();
}

// Handle adding a new game
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_game'])) {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $release_year = $_POST['release_year'];

    // Check if the game title already exists
    $stmt = $conn->prepare("SELECT * FROM tbl_games WHERE title = ?");
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "A game with this title already exists.";
    } else {
        // Proceed to add the game if it doesn't exist
        $stmt = $conn->prepare("INSERT INTO tbl_games (title, genre, price, release_year) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $title, $genre, $price, $release_year);
        $stmt->execute();
        $stmt->close();
        $message = "Game added successfully!";
    }
}

// Handle editing a game
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_game'])) {
    $game_id = $_POST['game_id'];
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $release_year = $_POST['release_year'];

    $stmt = $conn->prepare("UPDATE tbl_games SET title = ?, genre = ?, price = ?, release_year = ? WHERE game_id = ?");
    $stmt->bind_param("ssdii", $title, $genre, $price, $release_year, $game_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to the admin dashboard to close the overlay
    header("Location: admin-dashboard.php");
    exit();
}

// Handle deleting a game
if (isset($_GET['delete'])) {
    $game_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM tbl_games WHERE game_id = ?");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch all games
$sql = "SELECT * FROM tbl_games";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Dashboard</h1>
            <a href="logout.php" class="logout-button">Logout</a>
        </header>

        <?php if (!empty($message)): ?>
            <div class="overlay" id="messageOverlay" style="display: flex;">
                <div class="overlay-content">
                    <p><?php echo $message; ?></p>
                    <span class="close-btn" onclick="document.getElementById('messageOverlay').style.display='none'">Close</span>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
                    <div class="overlay" id="errorOverlay" style="display: flex;">
                        <div class="overlay-content">
                            <p><?php echo $error; ?></p>
                            <span class="close-btn" onclick="document.getElementById('errorOverlay').style.display='none'">Close</span>
                        </div>
                    </div>
                <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="overlay" id="errorOverlay" style="display: flex;">
                <div class="overlay-content">
                    <p><?php echo $error; ?></p>
                    <span class="close-btn" onclick="document.getElementById('errorOverlay').style.display='none'">Close</span>
                </div>
            </div>
        <?php endif; ?>

        <div class="content">
            <div class="panel">
                <h2>Add New Game</h2>
                <form method="POST">
                    <input type="text" name="title" placeholder="Game Title" required>
                    <input type="text" name="genre" placeholder="Genre" required>
                    <input type="number" step="0.01" name="price" placeholder="Price" required>
                    <input type="number" name="release_year" placeholder="Release Year" required>
                    <button type="submit" name="add_game" onclick="window.location.href='admin-dashboard.php';">Add Game</button>
                </form>

                <script>
                    if ( window.history.replaceState ) {
                            window.history.replaceState( null, null, window.location.href );
                    }
                </script>

            </div>

            <div class="panel">
                <h2>Game List</h2>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Price</th>
                        <th>Release Year</th>
                        <th>Actions</th>
                    </tr>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row["title"]); ?></td>
                                <td><?php echo htmlspecialchars($row["genre"]); ?></td>
                                <td>$<?php echo htmlspecialchars($row["price"]); ?></td>
                                <td><?php echo htmlspecialchars($row["release_year"]); ?></td>
                                <td>
                                    <a href="admin-dashboard.php?edit=<?php echo $row['game_id']; ?>">Edit</a>
                                    <a href="admin-dashboard.php?delete=<?php echo $row['game_id']; ?>" onclick="return confirm('Are you sure you want to delete this game?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No games found</td>
                        </tr>
                    <?php endif; ?>
                </table>

                <!-- Edit Game Modal (If Edit is Requested) -->
                <?php if (isset($_GET['edit'])): 
                    $game_id = $_GET['edit'];
                    $stmt = $conn->prepare("SELECT * FROM tbl_games WHERE game_id = ?");
                    $stmt->bind_param("i", $game_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $game = $result->fetch_assoc();
                ?>
                    <div class="overlay" id="editOverlay" style="display: flex;">
                        <div class="overlay-content">
                            <h2>Edit Game</h2>
                            <form method="POST">
                                <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
                                <input type="text" name="title" value="<?php echo htmlspecialchars($game['title']); ?>" required>
                                <input type="text" name="genre" value="<?php echo htmlspecialchars($game['genre']); ?>" required>
                                <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($game['price']); ?>" required>
                                <input type="number" name="release_year" value="<?php echo htmlspecialchars($game['release_year']); ?>" required>
                                <button type="submit" name="edit_game">Update Game</button>
                                <span class="close-btn" onclick="window.location.href='admin-dashboard.php';">Cancel</span>
                            </form>

                            <script>
                                if ( window.history.replaceState ) {
                                        window.history.replaceState( null, null, window.location.href );
                                }
                            </script>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>