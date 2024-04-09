<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get the user's role from the session
$role = $_SESSION['role'];
$first_name = $_SESSION['first_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Dashboard</h1>
        <p>Hello, <?php echo $first_name; ?>!</p>
        <nav>
            <ul>
                <?php if ($role === 'public') { ?>
                    <li><a href="../bicycle/register.php">Register Bicycle</a></li>
                    <li><a href="../bicycle/list.php">View Registered Bicycles</a></li>
                    <li><a href="../reports/create.php">Report Stolen Bicycle</a></li>
                <?php } ?>
                <?php if ($role === 'police' || $role === 'admin') { ?>
                    <li><a href="list-reports">View Reported Stolen Bicycles</a></li>
                <?php } ?>
                <?php if ($role === 'admin') { ?>
                    <li><a href="enroll-police">Enroll Police Officers</a></li>
                <?php } ?>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>

    <!-- Include your JavaScript file -->
    <script src="public/js/scripts.js"></script>
</body>
</html>