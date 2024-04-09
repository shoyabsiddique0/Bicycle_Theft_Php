<?php
require_once '../../models/StolenBicycle.php';
require_once '../../models/Bicycle.php';
require_once '../../models/User.php';

class ReportController
{
    private $stolenBicycleModel;
    private $bicycleModel;
    private $userModel;

    public function __construct($db)
    {
        $this->stolenBicycleModel = new StolenBicycle($db);
        $this->bicycleModel = new Bicycle($db);
        $this->userModel = new User($db);
    }

    public function reportStolenBicycle()
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
            // Retrieve the bicycle ID from the request
            $bicycleId = $_POST['bicycle_id'];

            // Validate and sanitize the input data
            // ...

            // Get the reported address from the request
            $reportedAddress = $_POST['reported_address'];

            // Get the user ID from the session
            $userId = $_SESSION['user_id'];

            // Check if the bicycle belongs to the logged-in user
            $bicycle = $this->bicycleModel->getBicycleById($bicycleId);
            echo $_SESSION['bicycle'][0]['user_id'];
            if ($bicycle && $_SESSION['bicycle'][0]['user_id'] == $_SESSION['user_id']) {
                // Call the appropriate method from the StolenBicycle model to report the theft
                $success = $this->stolenBicycleModel->reportStolenBicycle($bicycleId, $reportedAddress);

                if ($success) {
                    // Stolen bicycle report successful
                    // Redirect to the report list page or show a success message
                    header('Location: list.php');
                    exit;
                } else {
                    // Stolen bicycle report failed
                    $error = 'Failed to report stolen bicycle. Please try again.';
                    echo $error;
                    // Pass the error message to the report view
                }
            } else {
                // The bicycle does not belong to the logged-in user
                $error = 'You can only report bicycles registered under your account.';
                // Pass the error message to the report view
            }
        }

        // Render the report stolen bicycle view
        require_once '../../views/reports/create.php';
    }

    public function listStolenBicycleReports()
    {
        // Check if the user is logged in
        session_start();
        if (!isset($_SESSION['user_id'])) {
            // Redirect to the login page if the user is not logged in
            header('Location: login.php');
            exit;
        }

        // Retrieve the role from the session
        $role = $_SESSION['role'];

        // Check if the user is a police officer or admin
        if ($role === 'police' || $role === 'admin') {
            // Call the appropriate method from the StolenBicycle model to retrieve the reports
            $reports = $this->stolenBicycleModel->getStolenBicycleReports();

            // Pass the report data to the view for rendering
            require_once 'views/reports/list.php';
        } else {
            // User is not authorized to view the stolen bicycle reports
            $error = 'You are not authorized to view stolen bicycle reports.';
            // Pass the error message to an appropriate view or handle it as needed
        }
    }
}