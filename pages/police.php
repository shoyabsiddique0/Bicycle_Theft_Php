<?php
// Include necessary files
require_once 'config.php';
require_once 'queries.php';

// Start session
session_start();

// Check if user is logged in as police
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'police') {
    // Redirect unauthorized users to login page or other appropriate page
    header("Location: login.php");
    exit();
}

// Function to fetch stolen bicycles reported in a specific week/month/year
function getStolenBicycles($time_period) {
    // Prepare a select statement
    $sql = "SELECT * FROM stolen_bicycles WHERE YEAR(report_date) = ?";

    if ($time_period == 'month') {
        $sql .= " AND MONTH(report_date) = ?";
    } elseif ($time_period == 'week') {
        $sql .= " AND WEEK(report_date) = ?";
    }

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "ss", $year, $month_or_week);

        // Set the parameters
        $year = date('Y');
        $month_or_week = ($time_period == 'month') ? date('m') : date('W');

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Fetch all rows
        $stolen_bicycles = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Close the statement
        mysqli_stmt_close($stmt);

        return $stolen_bicycles;
    } else {
        echo "Oops! Something went wrong.";
    }
}

// Fetch stolen bicycles reported in the current week
$stolen_bicycles_week = getStolenBicycles('week');

// Fetch stolen bicycles reported in the current month
$stolen_bicycles_month = getStolenBicycles('month');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Police Panel</h1>
    </header>
    
    <nav>
        <!-- Add navigation links here -->
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    
    <main>
        <section>
            <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
            <h3>Stolen Bicycles</h3>
            <h4>Reported This Week</h4>
            <?php if (!empty($stolen_bicycles_week)): ?>
                <ul>
                    <?php foreach ($stolen_bicycles_week as $bike): ?>
                        <li><?php echo $bike['brand'] . " " . $bike['model']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No bicycles reported stolen this week.</p>
            <?php endif; ?>

            <h4>Reported This Month</h4>
            <?php if (!empty($stolen_bicycles_month)): ?>
                <ul>
                    <?php foreach ($stolen_bicycles_month as $bike): ?>
                        <li><?php echo $bike['brand'] . " " . $bike['model']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No bicycles reported stolen this month.</p>
            <?php endif; ?>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2024 Bicycle Theft Reduction Website</p>
    </footer>
</body>
</html>
