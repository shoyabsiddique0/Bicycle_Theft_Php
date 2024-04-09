<?php
require_once '../../models/User.php';

class UserController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function login()
    {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve username and password from the request
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Call the appropriate method from the User model to authenticate the user
            $user = $this->userModel->findByUsername($username);
            $pass = $user['password'];
            $passn = password_hash($password, PASSWORD_DEFAULT);
            $usern = $user['username'];
            echo "<script>alert('$pass, $passn');</script>";
            echo "<script>alert('$usern, $username');</script>";
            if ($user && password_verify($password, $user['password'])) {
                // User authentication successful
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['first_name'] = $user['first_name'];

                // Redirect to the dashboard or desired page
                if($user['role'] == 'public'){

                    header('Location: dashboard.php');
                }
                else if($user['role'] == 'admin'){
                    header('Location: ../admin/dashboard.php');
                }else{
                    header('Location:../police/dashboard.php');
                }
                exit;
            } else {
                // User authentication failed
                $error = 'Invalid username or password';
                echo "<script>alert('$error')</script>";
                // Pass the error message to the login view
            }
        }

        // Render the login view
        require_once '../../views/users/login.php';
    }

    public function register()
    {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve user information from the request
            $username = $_POST['username'];
            $email = $_POST['email'];
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $address = $_POST['address'];
            $contact = $_POST['contact'];
            $password = $_POST['password'];
            $role = 'public'; // Set the default role to 'public'

            // Validate and sanitize the input data
            // ...

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Call the appropriate method from the User model to register the user
            $success = $this->userModel->register($username, $email, $firstName, $lastName, $address, $contact, $hashedPassword, $role);

            if ($success) {
                // User registration successful
                // Redirect to the login page or show a success message
                header('Location: login.php');
                exit;
            } else {
                // User registration failed
                $error = 'Registration failed. Please try again.';
                // Pass the error message to the registration view
            }
        }

        // Render the registration view
        require_once '../../views/users/register.php';
    }

    public function logout()
    {
        // Destroy the session or invalidate the authentication token
        session_start();
        session_destroy();

        // Redirect to the login page
        header('Location: login.php');
        exit;
    }
}