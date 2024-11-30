<?php
include 'db.php'; // Include your database connection file
include 'checker.php';

// Fetch games
$sql = "SELECT * FROM tbl_games";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lebrong Games 2.0</title>
    <link rel="stylesheet" href="assets/css/view-games.css"> <!-- Link to CSS file -->
</head>
<body>
    <h1>Game Library</h1> 

    <!-- Logout Button -->
    <form action="logout.php" method="POST" style="display:inline;">
        <button type="submit" class="logout-button">Logout</button>
    </form>

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
                <p><strong>Price:</strong> <span id="overlay-price"></ span></p>
                <p><strong>Genre:</strong> <span id="overlay-genre"></span></p>
                <p><strong>Release Year:</strong> <span id="overlay-release-year"></span></p>
                <div class="close-btn" onclick="closeOverlay()">Close</div>
            </div>
        </div>
    </div>
    <script src="assets/js/view-games.js"></script> <!-- Link to JavaScript file -->
</body>
</html>