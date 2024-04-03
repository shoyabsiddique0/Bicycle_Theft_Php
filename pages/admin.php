<?php
// Include necessary files
require_once 'config.php';
require_once 'queries.php';

// Start session
session_start();

// Check if user is logged in as admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect unauthorized users to login page or other appropriate page
    header("Location: login.php");
    exit();
}

// Initialize variables
$new_username = $new_password = '';
$new_username_err = $new_password_err = '';

// Process form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate new username
    if(empty(trim($_POST['new_username']))) {
        $new_username_err = 'Please enter a new username.';
    } else {
        $new_username = trim($_POST['new_username']);
    }

    // Validate new password
    if(empty(trim($_POST['new_password']))) {
        $new_password_err = 'Please enter a new password.';
    } elseif(strlen(trim($_POST['new_password'])) < 6) {
        $new_password_err = 'Password must have at least 6 characters.';
    } else {
        $new_password = trim($_POST['new_password']);
    }

    // Check for input errors before updating the admin account
    if(empty($new_username_err) && empty($new_password_err)) {
        // Prepare an update statement
        $sql = "UPDATE admin SET username = ?, password = ? WHERE id = 1";

        if($stmt = mysqli_prepare($conn, $sql)) {
            // Hash password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $new_username;
            $param_password = $hashed_password;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                // Redirect to dashboard or other appropriate page
                header("Location: dashboard.php");
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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
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
            <h2>Update Admin Account</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div <?php echo (!empty($new_username_err)) ? 'has-error' : ''; ?>">
                    <label>New Username</label>
                    <input type="text" name="new_username" value="<?php echo $new_username; ?>">
                    <span><?php echo $new_username_err; ?></span>
                </div>
                <div <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                    <label>New Password</label>
                    <input type="password" name="new_password">
                    <span><?php echo $new_password_err; ?></span>
                </div>
                <div>
                    <input type="submit" value="Update">
                </div>
            </form>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2024 Bicycle Theft Reduction Website</p>
    </footer>
</body>
</html>
