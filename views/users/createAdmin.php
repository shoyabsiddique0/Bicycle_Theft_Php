<?php
// Start the session
// session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Include the User controller
require_once '../../models/User.php';
require_once '../../controllers/UserController.php';
require_once '../../config/config.php';
// Check if the admin user already exists
$userModel = new User($conn);
$adminUser = $userModel->findByUsername('admin');

if (!$adminUser) {
    // Hash the admin password
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);

    // Create the admin user
    $success = $this->userModel->register(
        'admin',
        'admin@example.com',
        'Admin',
        'User',
        'Admin Address',
        '1234567890',
        $adminPassword,
        'admin'
    );

    if ($success) {
        echo "<script>alert('Admin Created')</script>";
        header('Location: login.php');
    } else {
        echo "<script>alert('$error')</script>";
        header('Location: login.php');
    }
}else{
    echo "<script>alert('Admin Exists')</script>";
    header('Location: login.php');
}