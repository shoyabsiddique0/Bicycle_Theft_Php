<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../../controllers/BicycleController.php';
require_once '../../config/config.php';
$bicycleController = new BicycleController($conn);
$bicycleController->registerBicycle();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Bicycle</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Register Bicycle</h1>
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
        <form method="post" action="register.php">
            <div>
                <label for="brand">Brand:</label>
                <input type="text" id="brand" name="brand" required>
            </div>
            <div>
                <label for="model">Model:</label>
                <input type="text" id="model" name="model" required>
            </div>
            <div>
                <label for="color">Color:</label>
                <input type="text" id="color" name="color" required>
            </div>
            <div>
                <label for="serial_number">Serial Number:</label>
                <input type="text" id="serial_number" name="serial_number" required>
            </div>
            <div>
                <button type="submit">Register Bicycle</button>
            </div>
        </form>
        <a href="list.php">View Registered Bicycles</a>
    </div>

    <!-- Include your JavaScript file -->
    <script src="public/js/scripts.js"></script>
</body>
</html>