<?php
// Include necessary files
require_once '../config/config.php';
require_once '../db/queries.php';

// Start session
session_start();

// Check if user is already logged in
if(isset($_SESSION['user_id'])) {
    // Redirect logged-in users to their dashboard or other appropriate page
    header("Location: dashboard.php");
    exit();
}

// Initialize variables
$username = $password = '';
$username_err = $password_err = '';

// Process form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate username
    if(empty(trim($_POST['username']))) {
        $username_err = 'Please enter your username.';
    } else {
        $username = trim($_POST['username']);
    }

    // Validate password
    if(empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }

    // Check for input errors before attempting to login
    if(empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password, $role);
                    if(mysqli_stmt_fetch($stmt)) {
                        if(password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION['user_id'] = $user_id;
                            $_SESSION['username'] = $username;
                            $_SESSION['role'] = $role;

                            // Redirect user to their dashboard or other appropriate page
                            header("Location: dashboard.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = 'Invalid password.';
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
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
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    
    <nav>
        <!-- Add navigation links here -->
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>
    
    <main>
        <section>
            <h2>Login Form</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                    <span><?php echo $username_err; ?></span>
                </div>
                <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password">
                    <span><?php echo $password_err; ?></span>
                </div>
                <div>
                    <input type="submit" value="Login">
                </div>
                <p>Don't have an account? <a href="register.php">Register here</a>.</p>
            </form>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2024 Bicycle Theft Reduction Website</p>
    </footer>
</body>
</html>
