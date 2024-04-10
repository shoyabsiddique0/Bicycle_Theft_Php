<?php
// Start the session
session_start();

// Check if the user is logged in and has the 'police' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'police') {
  header('Location: login.php');
  exit;
}

// Get the police officer's first name
$first_name = $_SESSION['first_name'];
include '../layouts/header.php';
// Include the necessary files
require_once '../../controllers/PoliceController.php';
require_once '../../config/config.php';

// Create a database connection
// $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Create an instance of the PoliceController
$policeController = new PoliceController($conn);

// Initialize the filter value
$filter = 'all';

// Check if a filter value is provided in the query string
if (isset($_GET['filter'])) {
  $filter = $_GET['filter'];
}

// Fetch reported stolen bicycles based on the filter
$reports = $policeController->fetchReportedBicycles($filter);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Reported Stolen Bicycles</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
  <div class="container">
    <h1>Reported Stolen Bicycles</h1>
    <p>Hello, <?php echo $first_name; ?>!</p>
    <div class="filter-container">
      <label for="filter">Filter by:</label>
      <select id="filter" name="filter" onchange="updateFilter(this.value)">
        <option value="all" <?php if ($filter === 'all') echo 'selected'; ?>>All</option>
        <option value="week" <?php if ($filter === 'week') echo 'selected'; ?>>This Week</option>
        <option value="month" <?php if ($filter === 'month') echo 'selected'; ?>>This Month</option>
        <option value="year" <?php if ($filter === 'year') echo 'selected'; ?>>This Year</option>
      </select>
    </div>
    <table>
      <thead>
        <tr>
          <th>Brand</th>
          <th>Model</th>
          <th>Color</th>
          <th>Serial Number</th>
          <th>Reported Address</th>
          <th>Report Date</th>
          <th>Status</th>
          <th>Update Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reports as $report) { ?>
          <tr>
            <td><?php echo $report['brand']; ?></td>
            <td><?php echo $report['model']; ?></td>
            <td><?php echo $report['color']; ?></td>
            <td><?php echo $report['serial_number']; ?></td>
            <td><?php echo $report['address']; ?></td>
            <td><?php echo $report['report_date']; ?></td>
            <td><?php echo $report['status']; ?></td>
            <td>
                <form action="update_status.php" method="post">
  <input type="hidden" name="report_id" value="<?php echo $report['id']; ?>">
  <div style="display: flex; flex-direction: row; gap: 20px">
    <select name="new_status">
    <option value="reported" <?php if ($report['status'] === 'reported') echo 'selected'; ?>>Reported</option>
    <option value="under investigation" <?php if ($report['status'] === 'under investigation') echo 'selected'; ?>>Under Investigation</option>
    <option value="recovered" <?php if ($report['status'] === 'recovered') echo 'selected'; ?>>Recovered</option>
  </select>
  <button type="submit">Update Status</button>
  </div>
    </form>
      </td>
        </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <script src="../../public/js/scripts.js"></script>
  
  <?php
        include '../layouts/footer.php';
    ?>
</body>
</html>

