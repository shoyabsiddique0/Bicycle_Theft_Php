<?php
// Start the session
session_start();

// Include the necessary files
require_once 'config/config.php';
require_once 'models/User.php';
require_once 'models/Bicycle.php';
require_once 'models/StolenBicycle.php';
require_once 'controllers/UserController.php';
require_once 'controllers/BicycleController.php';
require_once 'controllers/ReportController.php';

// Create instances of the controllers
$userController = new UserController($conn);
$bicycleController = new BicycleController($conn);
$reportController = new ReportController($conn);

// Define the routes
$routes = [
    'login' => ['controller' => $userController, 'action' => 'login'],
    'register' => ['controller' => $userController, 'action' => 'register'],
    'logout' => ['controller' => $userController, 'action' => 'logout'],
    'register-bicycle' => ['controller' => $bicycleController, 'action' => 'registerBicycle'],
    'list-bicycles' => ['controller' => $bicycleController, 'action' => 'listBicycles'],
    'report-stolen-bicycle' => ['controller' => $reportController, 'action' => 'reportStolenBicycle'],
    'list-reports' => ['controller' => $reportController, 'action' => 'listStolenBicycleReports'],
];

// Get the requested route
$requestedRoute = $_SERVER['REQUEST_URI'];
$route = str_replace('/index.php', '', strtok($requestedRoute, '?'));
$route = trim($route, '/');

// Check if the requested route exists
if (array_key_exists($route, $routes)) {
    $controller = $routes[$route]['controller'];
    $action = $routes[$route]['action'];
    $controller->$action();
} else {
    // Handle 404 Not Found error
    http_response_code(404);
    echo 'Page not found';
}