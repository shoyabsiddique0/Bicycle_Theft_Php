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
$brand = $model = $color = $description = '';
$brand_err = $model_err = $color_err = $description_err = '';

// Process form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate brand
    if(empty(trim($_POST['brand']))) {
        $brand_err = 'Please enter the brand of the bicycle.';
    } else {
        $brand = trim($_POST['brand']);
    }

    // Validate model
    if(empty(trim($_POST['model']))) {
        $model_err = 'Please enter the model of the bicycle.';
    } else {
        $model = trim($_POST['model']);
    }

    // Validate color
    if(empty(trim($_POST['color']))) {
        $color_err = 'Please enter the color of the bicycle.';
    } else {
        $color = trim($_POST['color']);
    }

    // Validate description
    if(empty(trim($_POST['description']))) {
        $description_err = 'Please enter a description of the bicycle.';
    } else {
        $description = trim($_POST['description']);
    }

    // Check for input errors before reporting the stolen bicycle
    if(empty($brand_err) && empty($model_err) && empty($color_err) && empty($description_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO stolen_bicycles (user_id, brand, model, color, description, report_date) VALUES (?, ?, ?, ?, ?, NOW())";

        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "issss", $param_user_id, $param_brand, $param_model, $param_color, $param_description);

            // Set parameters
            $param_user_id = $_SESSION['user_id'];
            $param_brand = $brand;
            $param_model = $model;
            $param_color = $color;
            $param_description = $description;

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
    <title>Report Stolen Bicycle</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Report Stolen Bicycle</h1>
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
            <h2>Report Form</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div <?php echo (!empty($brand_err)) ? 'has-error' : ''; ?>">
                    <label>Brand</label>
                    <input type="text" name="brand" value="<?php echo $brand; ?>">
                    <span><?php echo $brand_err; ?></span>
                </div>
                <div <?php echo (!empty($model_err)) ? 'has-error' : ''; ?>">
                    <label>Model</label>
                    <input type="text" name="model" value="<?php echo $model; ?>">
                    <span><?php echo $model_err; ?></span>
                </div>
                <div <?php echo (!empty($color_err)) ? 'has-error' : ''; ?>">
                    <label>Color</label>
                    <input type="text" name="color" value="<?php echo $color; ?>">
                    <span><?php echo $color_err; ?></span>
                </div>
                <div <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                    <label>Description</label>
                    <textarea name="description"><?php echo $description; ?></textarea>
                    <span><?php echo $description_err; ?></span>
                </div>
                <div>
                    <input type="submit" value="Report">
                </div>
            </form>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2024 Bicycle Theft Reduction Website</p>
    </footer>
</body>
</html>
