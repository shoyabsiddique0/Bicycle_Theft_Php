<?php
// Start the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
include '../layouts/header.php';
// Include the User controller
require_once '../../controllers/UserController.php';
require_once '../../config/config.php';
$userController = new UserController($conn);

// Handle the login logic
$userController->login();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
        <form method="post" action="login.php">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>

    <!-- Include your JavaScript file -->
    <script src="../../public/js/scripts.js"></script>
    <?php
    include '../layouts/footer.php';
    ?>
</body>
</html>