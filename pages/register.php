<?php
// Include necessary files
require_once 'config.php';
require_once 'queries.php';

// Start session
session_start();

// Check if user is already logged in
if(isset($_SESSION['user_id'])) {
    // Redirect logged-in users to their dashboard or other appropriate page
    header("Location: dashboard.php");
    exit();
}

// Initialize variables
$username = $email = $password = $confirm_password = '';
$username_err = $email_err = $password_err = $confirm_password_err = '';

// Process form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate username
    if(empty(trim($_POST['username']))) {
        $username_err = 'Please enter a username.';
    } else {
        $username = trim($_POST['username']);
    }

    // Validate email
    if(empty(trim($_POST['email']))) {
        $email_err = 'Please enter your email.';
    } else {
        // Check if email is valid
        if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
            $email_err = 'Please enter a valid email address.';
        } else {
            $email = trim($_POST['email']);
        }
    }

    // Validate password
    if(empty(trim($_POST['password']))) {
        $password_err = 'Please enter a password.';
    } elseif(strlen(trim($_POST['password'])) < 6) {
        $password_err = 'Password must have at least 6 characters.';
    } else {
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if(empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = 'Please confirm password.';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password) {
            $confirm_password_err = 'Password did not match.';
        }
    }

    // Check for input errors before registering the user
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Prepare a select statement to check if username already exists
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username already exists
                if(mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = 'This username is already taken.';
                } else {
                    // Prepare an insert statement
                    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'public')";

                    if($stmt = mysqli_prepare($conn, $sql)) {
                        // Hash password
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);

                        // Set parameters
                        $param_username = $username;
                        $param_email = $email;
                        $param_password = $hashed_password;

                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)) {
                            // Redirect to login page
                            header("Location: login.php");
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
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
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Register</h1>
    </header>
    
    <nav>
        <!-- Add navigation links here -->
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
    
    <main>
        <section>
            <h2>Registration Form</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                    <span><?php echo $username_err; ?></span>
                </div>
                <div <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label>
                    <input type="text" name="email" value="<?php echo $email; ?>">
                    <span><?php echo $email_err; ?></span>
                </div>
                <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password">
                    <span><?php echo $password_err; ?></span>
                </div>
                <div <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password">
                    <span><?php echo $confirm_password_err; ?></span>
                </div>
                <div>
                    <input type="submit" value="Register">
                </div>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2024 Bicycle Theft Reduction Website</p>
    </footer>
</body>
</html>
