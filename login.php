<?php
include 'login-checker.php'; // Include the login checker
include 'db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password (assuming you are using password_hash for storing passwords)
        if (password_verify($password, $user['password'])) {
            // Store user information in session
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Assuming 'role' is the column name

            // Redirect based on user role
            if ($user['role'] === 'admin') {
                header("Location: admin-dashboard.php");
            } else {
                header("Location: view-games.php");
            }
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="signup.php">Signup</a>
    </div>
    <script src="assets/js/scripts.js"></script>
</body>
</html>