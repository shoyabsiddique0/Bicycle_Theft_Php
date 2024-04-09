<?php
require_once '../../models/User.php';
require_once '../../models/EnrolledPolice.php';

class AdminController {
    private $userModel;
    private $enrolledPoliceModel;

    public function __construct($db) {
        $this->userModel = new User($db);
        $this->enrolledPoliceModel = new EnrolledPolice($db);
    }

    public function enrollOfficer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $officerUsername = $_POST['officer_username'];
            $officer = $this->userModel->findByUsername($officerUsername);

            if ($officer && $officer['role'] === 'police') {
                $adminId = $_SESSION['user_id']; // Assuming the admin's ID is stored in the session
                $success = $this->enrolledPoliceModel->enroll($officer['id'], $adminId);

                if ($success) {
                    $message = "Officer enrolled successfully.";
                } else {
                    $message = "Failed to enroll officer.";
                }
            } else {
                $message = "Invalid officer username or user is not a police officer.";
            }
            echo "<script>alert('$message');</script>";
        }

        require_once '../../views/admin/enroll_officer.php';
    }

    public function createCredentials() {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve user information from the request
            $username = $_POST['username'];
            $email = $_POST['email'];
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $address = $_POST['address'];
            $contact = $_POST['contact'];
            $password = $_POST['password'];
            $role = 'police'; // Set the default role to 'public'

            // Validate and sanitize the input data
            // ...

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Call the appropriate method from the User model to register the user
            $success = $this->userModel->register($username, $email, $firstName, $lastName, $address, $contact, $hashedPassword, $role);

            if ($success) {
                // User registration successful
                // Redirect to the login page or show a success message
                echo "User Created Successfully";
                exit;
            } else {
                // User registration failed
                $error = 'Registration failed. Please try again.';
                // Pass the error message to the registration view
            }
        }
        require_once '../../views/admin/create_credentials.php';
    }
    

    public function viewEnrolledOfficers() {
        $enrolledOfficers = $this->enrolledPoliceModel->getAllEnrolledOfficers();
        require_once '../../views/admin/enrolled_officers.php';
    }
}