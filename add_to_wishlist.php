<?php
session_start();
include 'db.php'; // Include your database connection file

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_wishlist'])) {
    $user_id = $_SESSION['id']; // Assuming you store user ID in session
    $game_id = trim($_POST['game_id']); // Trim any whitespace

    // Debugging: Log the game_id
    error_log("Game ID received: " . $game_id); // Log the game ID

    // Check if the game exists in tbl_games
    $stmt = $conn->prepare("SELECT * FROM tbl_games WHERE game_id = ?");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Check if the game is already in the wishlist
        $stmt = $conn->prepare("SELECT * FROM tbl_wishlist WHERE user_id = ? AND game_id = ?");
        $stmt->bind_param("ii", $user_id, $game_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Add the game to the wishlist
            $stmt = $conn->prepare("INSERT INTO tbl_wishlist (user_id, game_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $user_id, $game_id);
            $stmt->execute();
            $stmt->close();
            $message = "Game added to wishlist!";
        } else {
            $message = "Game is already in your wishlist.";
        }
    } else {
        $message = "Game does not exist.";
    }

    // Redirect back to the view games page with a message
    header("Location: view-games.php?message=" . urlencode($message));
    exit();
}
?>