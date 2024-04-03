<?php

// Include configuration file
require_once '../config/config.php';

// Function to establish database connection
function connect() {
    global $db_host, $db_user, $db_password, $db_name;
    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

// Function to close database connection
function close($conn) {
    mysqli_close($conn);
}

// Function to execute a query and return result set
function execute_query($query) {
    $conn = connect();
    $result = mysqli_query($conn, $query);
    close($conn);
    return $result;
}

// Function to fetch single row from result set
function fetch_row($result) {
    return mysqli_fetch_assoc($result);
}

// Function to fetch all rows from result set
function fetch_all($result) {
    $rows = array();
    while ($row = fetch_row($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Sample usage:
/*
$query = "SELECT * FROM users WHERE role = 'public'";
$result = execute_query($query);
$rows = fetch_all($result);
foreach ($rows as $row) {
    echo $row['username'] . "<br>";
}
*/
?>
