<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Check if the user is a police officer or admin
$role = $_SESSION['role'];
// if ($role !== 'police' && $role !== 'admin') {
//     http_response_code(403); // Forbidden
//     echo 'You are not authorized to view this page.';
//     exit;
// }
require_once '../../models/StolenBicycle.php';
require_once '../../config/config.php';
include '../layouts/header.php';
$stolenBicycles = new StolenBicycle($conn);
$stolenBicycles->getStolenBicycleReports();
$data = $_SESSION['stolen_bicycle'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reported Stolen Bicycles</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Reported Stolen Bicycles</h1>
        <?php if (empty($data)) { ?>
            <p>No stolen bicycles have been reported yet.</p>
        <?php } else { ?>
            <table>
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Report Date</th>
                        <th>Status</th>
                        <th>Bicycle</th>
                        <th>Reported By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $report) { ?>
                        <tr>
                            <td><?php echo $report['id']; ?></td>
                            <td><?php echo $report['report_date']; ?></td>
                            <td><?php echo $report['status']; ?></td>
                            <td><?php echo $report['brand'] . ' ' . $report['model'] . ' (' . $report['serial_number'] . ')'; ?></td>
                            <td><?php echo $report['username']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <!-- Include your JavaScript file -->
    <script src="../../public/js/scripts.js"></script>
    <?php
        include '../layouts/footer.php';
    ?>
</body>
</html>