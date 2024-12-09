<?php
include 'db.php';
include 'checker.php';

// Enhanced Security and Error Handling
if ($_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Unauthorized access. Admin rights required.";
    header("Location: view-games.php");
    exit();
}

// Validation Function
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$message = '';
$error = '';

// Add Game with Enhanced Validation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_game'])) {
    $title = validateInput($_POST['title']);
    $genre = validateInput($_POST['genre']);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $release_year = filter_var($_POST['release_year'], FILTER_VALIDATE_INT);

    if (empty($title) || empty($genre) || $price === false || $release_year === false) {
        $error = "Invalid input. Please check all fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO tbl_games (title, genre, price, release_year) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $title, $genre, $price, $release_year);
        
        if ($stmt->execute()) {
            $message = "Game added successfully!";
        } else {
            $error = "Error adding game: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Edit Game with Validation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_game'])) {
    $game_id = filter_var($_POST['game_id'], FILTER_VALIDATE_INT);
    $title = validateInput($_POST['title']);
    $genre = validateInput($_POST['genre']);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $release_year = filter_var($_POST['release_year'], FILTER_VALIDATE_INT);

    if ($game_id === false || empty($title) || empty($genre) || $price === false || $release_year === false) {
        $error = "Invalid input. Please check all fields.";
    } else {
        $stmt = $conn->prepare("UPDATE tbl_games SET title = ?, genre = ?, price = ?, release_year = ? WHERE game_id = ?");
        $stmt->bind_param("ssdii", $title, $genre, $price, $release_year, $game_id);
        
        if ($stmt->execute()) {
            $message = "Game updated successfully!";
        } else {
            $error = "Error updating game: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Delete Game with Confirmation
if (isset($_GET['delete'])) {
    $game_id = filter_var($_GET['delete'], FILTER_VALIDATE_INT);
    if ($game_id !== false) {
        $stmt = $conn->prepare("DELETE FROM tbl_games WHERE game_id = ?");
        $stmt->bind_param("i", $game_id);
        
        if ($stmt->execute()) {
            $message = "Game deleted successfully!";
        } else {
            $error = "Error deleting game: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch games with search functionality
$search = isset($_GET['search']) ? validateInput($_GET['search']) : '';
$sql = "SELECT * FROM tbl_games WHERE title LIKE ? OR genre LIKE ?";
$stmt = $conn->prepare($sql);
$searchParam = "%" . $search . "%";
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();
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
                                <button type="submit" name="edit_game" onclick="window.location.href='admin-dashboard.php';">Update Game</button>
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