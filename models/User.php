<?php

class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function register($username, $email, $firstName, $lastName, $address, $contact, $password, $role)
    {
        $query = "INSERT INTO users (username, email, first_name, last_name, address_1, contact, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssss", $username, $email, $firstName, $lastName, $address, $contact, $password, $role);
        return $stmt->execute();
    }

    // Add other methods for updating, deleting, etc.
}