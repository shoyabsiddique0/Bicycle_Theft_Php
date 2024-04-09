<?php
// Include the AdminController
require_once '../../controllers/AdminController.php';
require_once '../../config/config.php';
$adminController = new AdminController($conn);

// Call the viewEnrolledOfficers method
$adminController->viewEnrolledOfficers();
$enrolledOfficers = $_SESSION['enrolled_police'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enrolled Officers</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Enrolled Officers</h1>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enrolledOfficers as $officer) { ?>
                    <tr>
                        <td><?php echo $officer['username']; ?></td>
                        <td><?php echo $officer['first_name'] . ' ' . $officer['last_name']; ?></td>
                        <td><?php echo $officer['email']; ?></td>
                        <td><?php echo $officer['contact']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Include your JavaScript file -->
    <script src="public/js/scripts.js"></script>
</body>
</html>