<?php
// Include necessary files
require_once 'config.php';
require_once 'queries.php';

// Start session
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    // Redirect unauthorized users to login page or other appropriate page
    header("Location: login.php");
    exit();
}

// Initialize variables
$status = '';
$report_err = '';

// Process form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate report ID
    if(empty(trim($_POST['report_id']))) {
        $report_err = 'Please enter your report ID.';
    } else {
        $report_id = trim($_POST['report_id']);
    }

    // Check for input errors before checking status
    if(empty($report_err)) {
        // Prepare a select statement
        $sql = "SELECT status FROM stolen_bicycles WHERE id = ?";

        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_report_id);

            // Set parameters
            $param_report_id = $report_id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if report ID exists, if yes then fetch the status
                if(mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $status);
                    if(mysqli_stmt_fetch($stmt)) {
                        // Report ID exists, display status
                        // You can customize this part to display the status as needed
                        echo "Status of Report ID $report_id: $status";
                    }
                } else {
                    // Report ID doesn't exist
                    $report_err = 'No report found with that ID.';
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Status</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Check Status</h1>
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
            <h2>Check Status of Reported Bicycle</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div <?php echo (!empty($report_err)) ? 'has-error' : ''; ?>">
                    <label>Report ID</label>
                    <input type="text" name="report_id" value="<?php echo $report_id; ?>">
                    <span><?php echo $report_err; ?></span>
                </div>
                <div>
                    <input type="submit" value="Check Status">
                </div>
            </form>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2024 Bicycle Theft Reduction Website</p>
    </footer>
</body>
</html>
