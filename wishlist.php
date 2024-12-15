<?php
session_start();
include 'db.php'; // Include your database connection file

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch games with search functionality and sorting
$search = isset($_GET['search']) ? validateInput($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'title_asc';

$order_by = '';
switch ($sort) {
    case 'title_asc':
        $order_by = 'title ASC';
        break;
    case 'price_asc':
        $order_by = 'price ASC';
        break;
    case 'release_year_asc':
        $order_by = 'release_year ASC';
        break;
}

$sql = "SELECT * FROM tbl_games WHERE title LIKE ? OR genre LIKE ? ORDER BY $order_by";
$stmt = $conn->prepare($sql);
$searchParam = "%" . $search . "%";
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

$user_id = $_SESSION['id']; // Assuming you store user ID in session

$sql = "SELECT g.* FROM tbl_games g JOIN tbl_wishlist w ON g.game_id = w.game_id WHERE w.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Wishlist</title>
    <link rel="stylesheet" href="assets/css/view-games.css">
</head>
<body>
    <h1>Your Wishlist</h1>

    <!-- Navbar -->
    <nav class="navbar">
        <!-- Logout Button -->
        <form action="logout.php" method="POST" style="display:inline;">
            <button type="submit" class="logout-button">Logout</button>
        </form>

        <!-- Wishlist Button -->
        <form action="view-games.php" method="POST" style="display:inline;">
            <button type="submit" class="logout-button">Return</button>
        </form>

        <!-- Sorting Button -->
        <div class="sort-button">
            <div id="dropdown" class="dropdown-content">
                <form method="GET" action="view-games.php">
                    <label><input type="radio" name="sort" value="title_asc" checked> Alphabetical A-Z</label><br>
                    <label><input type="radio" name="sort" value="price_asc"> Price Low to High</label><br>
                    <label><input type="radio" name="sort" value="release_year_asc"> Year of Release ASC</label><br>
                    <button type="submit">Apply</button>
                </form>
            </div>
        </div>

        <!-- Search UI -->
        <div class="search-form">
            <form method="GET" action="view-games.php">
                <input type="text" name="search" placeholder="Search games through name or genre" value="<?php echo htmlspecialchars($search); ?>" required>
                <button type="submit">Search</button>
                <button type="button" class="reset-search-button" onclick="window.location.href='view-games.php'">Reset</button> <!-- Reset Button -->
            </form>
        </div>
    </nav>

    <div class="game-container">

        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                $image_url = "https://via.placeholder.com/200x250?text=" . urlencode($row["title"]);
                echo
                    "<div class='game-card' onclick=\"openOverlay('" . htmlspecialchars($row["title"]) . "', '$" . number_format($row["price"], 2) . "', '" . htmlspecialchars($row["genre"]) . "', '" . htmlspecialchars($row["release_year"]) . "', '$image_url', " . $row["game_id"] . ")\">
                        <img src='$image_url' alt='" . htmlspecialchars($row["title"]) . "'>
                        <div class='game-title'>" . htmlspecialchars($row["title"]) . "</div>
                    </div>";
            }
        } else {
            echo "<div class='no-games'>No games found</div>";
        }
        $conn->close();
        ?>
    </div>

    <!-- Overlay Panel -->
    <div class="overlay" id="overlay">
        <div class="overlay-content">
            <img id="overlay-image" src="" alt="Game Image">
            <div>
                <h2 id="overlay-title"></h2>
                <p><strong>Price:</strong> <span id="overlay-price"></span></p>
                <p><strong>Genre:</strong> <span id="overlay-genre"></span></p>
                <p><strong>Release Year:</strong> <span id="overlay-release-year"></span></p>
                <form method="POST" action="add_to_wishlist.php" id="wishlist-form">
                    <input type="hidden" name="game_id" id="wishlist-game-id" value="">
                </form>
                <div class="close-btn" onclick="closeOverlay()">Close</div>
            </div>
        </div>
    </div>
    <script src="assets/js/view-games.js"></script> <!-- Link to JavaScript file -->
</body>
</html>