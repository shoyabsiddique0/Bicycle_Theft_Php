<?php
require_once '../../models/Bicycle.php';
require_once '../../models/User.php';

class BicycleController
{
    private $bicycleModel;
    private $userModel;
    public $bicycles;

    public function __construct($db)
    {
        $this->bicycleModel = new Bicycle($db);
        $this->userModel = new User($db);
    }

    public function registerBicycle()
    {
        // Check if the user is logged in
        session_start();
        if (!isset($_SESSION['user_id'])) {
            // Redirect to the login page if the user is not logged in
            header('Location: login.php');
            exit;
        }

        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve bicycle information from the request
            $brand = $_POST['brand'];
            $model = $_POST['model'];
            $color = $_POST['color'];
            $serialNumber = $_POST['serial_number'];

            // Validate and sanitize the input data
            // ...

            // Get the user ID from the session
            $userId = $_SESSION['user_id'];

            // Call the appropriate method from the Bicycle model to register the bicycle
            $success = $this->bicycleModel->registerBicycle($userId, $brand, $model, $color, $serialNumber);

            if ($success) {
                // Bicycle registration successful
                // Redirect to the bicycle list page or show a success message
                header('Location: list.php');
                exit;
            } else {
                // Bicycle registration failed
                $error = 'Bicycle registration failed. Please try again.';
                // Pass the error message to the registration view
            }
        }

        // Render the bicycle registration view
        require_once '../../views/bicycle/register.php';
    }

    public function listBicycles()
    {
        // Check if the user is logged in
        // session_start();
        if (!isset($_SESSION['user_id'])) {
            // Redirect to the login page if the user is not logged in
            header('Location: login.php');
            exit;
        }

        // Get the user ID from the session
        $userId = $_SESSION['user_id'];

        // Call the appropriate method from the Bicycle model to retrieve the user's bicycles
        $this->bicycles = $this->bicycleModel->getBicyclesByUser($userId);
        $result1 = $this->bicycles[0]['brand'];
        $_SESSION['bicycles'] = $this->bicycles;
        // foreach ($bicycles as $bicycle) {
        //     $name->$bicycle['brand'];
            // echo "<script>alert('$bicycles[0][brand]')</script>";
        // }

        // Pass the bicycle data to the view for rendering
        // require_once '../../views/bicycle/list.php';
    }
}