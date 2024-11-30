<?php
session_start();
include 'db.php'; // Include your database connection file
include 'session-check.php'; // Ensure the user is logged in as admin

// Handle adding a new game
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_game'])) {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $release_year = $_POST['release_year'];

    $stmt = $conn->prepare("INSERT INTO tbl_games (title, genre, price, release_year) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $title, $genre, $price, $release_year);
    $stmt->execute();
    $stmt->close();
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

        <div class="content">
            <div class="panel">
                <h2>Add New Game</h2>
                <form method="POST">
                    <input type="text" name="title" placeholder="Game Title" required>
                    <input type="text" name="genre" placeholder="Genre" required>
                    <input type="number" step="0.01" name="price" placeholder="Price" required>
                    <input type="number" name="release_year" placeholder="Release Year" required>
                    <button type="submit" name="add_game">Add Game</button>
                </form>
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
                                <td><?php echo htmlspecialchars($row["price"]); ?></td>
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

                <?php
                // Edit game form
                if (isset($_GET['edit'])) $game_id = $_GET['edit'];
                    $stmt = $conn->prepare("SELECT * FROM tbl_games WHERE game_id = ?");
                    $stmt->bind_param("i", $game_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $game = $result->fetch_assoc();
                ?>
                <h2>Edit Game</h2>
                <form method="POST">
                    <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
                    <input type="text" name="title" value="<?php echo htmlspecialchars($game['title']); ?>" required>
                    <input type="text" name="genre" value="<?php echo htmlspecialchars($game['genre']); ?>" required>
                    <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($game['price']); ?>" required>
                    <input type="number" name="release_year" value="<?php echo htmlspecialchars($game['release_year']); ?>" required>
                    <button type="submit" name="edit_game">Update Game</button>
                </form>
                <?php
                $stmt->close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>