<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../../controllers/ReportController.php';
require_once '../../controllers/BicycleController.php';
require_once '../../config/config.php';
include '../layouts/header.php';
$bicycle_controller = new BicycleController($conn);
$bicycle_controller->listBicycles();
$reportController = new ReportController($conn);
$registeredBicycles = $_SESSION['bicycles'];
$reportController->reportStolenBicycle();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Stolen Bicycle</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Report Stolen Bicycle</h1>
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
        <form method="post" action="create.php">
            <div>
                <label for="bicycle_id">Select Bicycle:</label>
                <select id="bicycle_id" name="bicycle_id" required>
                    <option value="">Select a bicycle</option>
                    <?php foreach ($registeredBicycles as $bicycle) { ?>
                        <option value="<?php echo $bicycle['id']; ?>"><?php echo $bicycle['brand'] . ' ' . $bicycle['model'] . ' (' . $bicycle['serial_number'] . ')'; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="reported_address">Reported Address:</label>
                <input type="text" id="reported_address" name="reported_address" required>
            </div>
            <div>
                <button type="submit">Report Stolen Bicycle</button>
            </div>
        </form>
        <a href="list.php">View Reported Stolen Bicycles</a>
    </div>

    <!-- Include your JavaScript file -->
    <script src="../../public/js/scripts.js"></script>
    <?php
        include '../layouts/footer.php';
    ?>
</body>
</html>