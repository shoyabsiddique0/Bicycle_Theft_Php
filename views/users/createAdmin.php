<?php
// Start the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Include the necessary files
require_once '../../models/User.php';
require_once '../../controllers/UserController.php';
require_once '../../config/config.php';

// Create a database connection
// $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check if the admin user already exists
$userModel = new User($conn);
$adminUser = $userModel->findByUsername('admin');

if (!$adminUser) {
    // Hash the admin password
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);

    // Create the admin user
    $success = $userModel->register(
        'admin',
        'admin@example.com',
        'Admin',
        'User',
        'Admin Address',
        '1234567890',
        '$2y$10$QDU77bq0FxyoCPHg/PV0COnU0PNMgbVQLuemTUxLo4rfZ/HDoC6AG',
        'admin'
    );

    if ($success) {
        echo "<script>alert('Admin user created successfully')</script>";
        header('Location: login.php');
        exit;
    } else {
        echo "<script>alert('Failed to create admin user')</script>";
        header('Location: login.php');
        exit;
    }
} else {
    echo "<script>alert('Admin user already exists')</script>";
    header('Location: login.php');
    exit;
}

// Handle the login process
$userController = new UserController($conn);
$userController->login();