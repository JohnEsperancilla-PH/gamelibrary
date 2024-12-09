<?php
include 'db.php'; // Include your database connection file
include 'checker.php'; // Include the checker file to access validateInput function

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Library</title>
    <link rel="stylesheet" href="assets/css/view-games.css"> <!-- Link to CSS file -->
</head>
<body>
    <h1>Game Library</h1> 

    <!-- Navbar -->
    <nav class="navbar">
        <!-- Logout Button -->
        <form action="logout.php" method="POST" style="display:inline;">
            <button type="submit" class="logout-button">Logout</button>
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
                // Sample image URLs with 4:5 aspect ratio
                $image_url = "https://via.placeholder.com/200x250?text=" . urlencode($row["title"]);
                echo
                    "<div class='game-card' onclick='openOverlay(\"" . htmlspecialchars($row["title"]) . "\", \"" . htmlspecialchars($row["price"]) . "\", \"" . htmlspecialchars($row["genre"]) . "\", \"" . htmlspecialchars($row["release_year"]) . "\", \"$image_url\")'>
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
                <div class="close-btn" onclick="closeOverlay()">Close</div>
            </div>
        </div>
    </div>
    <script src="assets/js/view-games.js"></script> <!-- Link to JavaScript file -->
</body>
</html>