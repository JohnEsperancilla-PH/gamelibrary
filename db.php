<?php
$host = 'localhost';
$db = 'gamelibrary_db'; // Updated database name
$user = 'root'; // Default XAMPP username
$pass = ''; // Default XAMPP password is empty

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>