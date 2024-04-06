<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'bicycle_theft_db';

// Create a new MySQL connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}