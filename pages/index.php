<?php
// Include necessary files
require_once 'config.php';
require_once 'queries.php';

// Sample usage of database queries
/*
$conn = connect();
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
close($conn);
*/

// Start session
session_start();

// Check if user is logged in
if(isset($_SESSION['user_id'])) {
    // Redirect logged-in users to their dashboard or other appropriate page
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to the Bicycle Theft Reduction Website</h1>
    </header>
    
    <nav>
        <!-- Add navigation links here -->
        <ul>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>
    
    <main>
        <section>
            <h2>About Us</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rhoncus ullamcorper eros, ut ultrices elit posuere quis. Integer auctor nibh eu magna maximus, ut rutrum lacus dictum.</p>
        </section>
        
        <section>
            <h2>How It Works</h2>
            <p>Curabitur vehicula est sed lacus dapibus consequat. Sed suscipit, lorem et commodo scelerisque, nisi tellus efficitur eros, id congue libero felis nec nisi.</p>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2024 Bicycle Theft Reduction Website</p>
    </footer>
</body>
</html>
