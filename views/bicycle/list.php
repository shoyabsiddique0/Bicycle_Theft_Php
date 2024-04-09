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
$bicycle_controller = new BicycleController($conn);
$bicycle_controller->listBicycles();
$bicycles = $_SESSION['bicycles'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registered Bicycles</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Registered Bicycles</h1>
        <?php 
        if (empty($bicycles)) { ?>
           
            <p>You have not registered any bicycles yet.</p>
        <?php } else { ?>
            <table>
                <thead>
                    <tr>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>Serial Number</th>
                        <th>Registration Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bicycles as $bicycle) { ?>
                        <tr>
                            <td><?php echo $bicycle['brand']; ?></td>
                            <td><?php echo $bicycle['model']; ?></td>
                            <td><?php echo $bicycle['color']; ?></td>
                            <td><?php echo $bicycle['serial_number']; ?></td>
                            <td><?php echo $bicycle['registration_date']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
        <a href="register.php">Register New Bicycle</a>
    </div>

    <!-- Include your JavaScript file -->
    <script src="public/js/scripts.js"></script>
</body>
</html>