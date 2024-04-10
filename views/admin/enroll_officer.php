<?php
// Include the AdminController
require_once '../../controllers/AdminController.php';
require_once '../../config/Config.php';
$adminController = new AdminController($conn);

// Call the enrollOfficer method
$adminController->enrollOfficer();
include '../layouts/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enroll Officer</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Enroll Officer</h1>
        <?php if (isset($message)) { ?>
            <p><?php echo $message; ?></p>
        <?php } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="officer_username">Officer Username:</label>
            <input type="text" id="officer_username" name="officer_username" required>
            <button type="submit">Enroll Officer</button>
        </form>
    </div>

    <!-- Include your JavaScript file -->
    <script src="../../public/js/scripts.js"></script>
    <?php
        include '../layouts/footer.php';
    ?>
</body>
</html>