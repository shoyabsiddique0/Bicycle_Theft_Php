<?php
// Start the session
session_start();

// Check if the user is logged in and has the 'police' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'police') {
  header('Location: login.php');
  exit;
}

// Include the necessary files
require_once '../../models/StolenBicycle.php';
require_once '../../config/config.php';
include '../layouts/header.php';

// Create a database connection
// $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Instantiate the StolenBicycle model
$stolenBicycle = new StolenBicycle($conn);

// Check if the form has been submitted
if (isset($_POST['report_id']) && isset($_POST['new_status'])) {
  $reportId = $_POST['report_id'];
  $newStatus = $_POST['new_status'];

  // Validate the status value
  $validStatuses = ['reported', 'under investigation', 'recovered'];
  if (!in_array($newStatus, $validStatuses)) {
    header('Location: view_reports.php?error=invalid_status');
    exit;
  }

  // Attempt to update the status
  $updateSuccess = $stolenBicycle->updateStatus($reportId, $newStatus);

  if ($updateSuccess) {
    header('Location: view_reports.php?success=status_updated');
  } else {
    header('Location: view_reports.php?error=update_failed');
  }
} else {
  // Handle invalid access to the script
  header('Location: view_reports.php?error=invalid_access');
  exit;
}
