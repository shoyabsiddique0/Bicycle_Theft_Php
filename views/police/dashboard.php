<?php
// Start the session
session_start();

// Check if the user is logged in and has the 'police' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'police') {
    header('Location: login.php');
    exit;
}
include '../layouts/header.php';
require_once '../../controllers/PoliceController.php';
require_once '../../config/config.php';
$policeController = new PoliceController($conn);
// Get the police officer's first name
$first_name = $_SESSION['first_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Police Dashboard</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Police Dashboard</h1>
        <p>Hello, <?php echo $first_name; ?>!</p>
        <nav>
            <ul>
                <li><a href="view_reports.php">View Reported Stolen Bicycles</a></li>
                <li><a href="update_status.php">Update Investigation Status</a></li>
                <li><a href="../users/logout.php">Logout</a></li>
            </ul>
        </nav>
        <br><br>
        <div class="content">
            <!-- Police dashboard content goes here -->
            <h2>Last 5 reports</h2>
            <!-- Display a list of recently reported stolen bicycles -->
            <?php
            // Fetch and display recently reported stolen bicycles from the database
            $recentReports = $policeController->fetchRecentReports();
            if (!empty($recentReports)) {
                echo "<table>";
                echo "<tr><th>Brand</th><th>Model</th><th>Color</th><th>Serial Number</th><th>Reported Address</th><th>Report Date</th><th>Status</th></tr>";
                foreach ($recentReports as $report) {
                    echo "<tr>";
                    echo "<td>" . $report['brand'] . "</td>";
                    echo "<td>" . $report['model'] . "</td>";
                    echo "<td>" . $report['color'] . "</td>";
                    echo "<td>" . $report['serial_number'] . "</td>";
                    echo "<td>" . $report['address'] . "</td>";
                    echo "<td>" . $report['report_date'] . "</td>";
                    echo "<td>" . $report['status'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No recent reports to show.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Include your JavaScript file -->
    <script src="../../public/js/scripts.js"></script>
    <?php
        include '../layouts/footer.php';
    ?>
</body>
</html>