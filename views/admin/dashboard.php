<?php
// Start the session
session_start();

// Check if the user is logged in and has the 'admin' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../users/login.php');
    exit;
}


// Get the admin's first name
$first_name = $_SESSION['first_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Include your CSS file -->
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Hello, <?php echo $first_name; ?>!</p>
        <nav>
            <ul>
                <li><a href="enroll_officer.php">Enroll Police Officers</a></li>
                <li><a href="create_credentials.php">Create Credentials</a></li>
                <li><a href="enrolled_officers.php">View Enrolled Officers</a></li>
                <li><a href="../users/logout.php">Logout</a></li>
            </ul>
        </nav>
   
    </div>

    <!-- Include your JavaScript file -->
    <script src="../../public/js/scripts.js"></script>
</body>
</html>