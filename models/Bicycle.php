<?php

class Bicycle
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registerBicycle($userId, $brand, $model, $color, $serialNumber)
    {
        $query = "INSERT INTO bicycles (user_id, brand, model, color, serial_number) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issss", $userId, $brand, $model, $color, $serialNumber);
        return $stmt->execute();
    }

    public function getBicyclesByUser($userId)
    {
        $query = "SELECT * FROM bicycles WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Add other methods for updating, deleting, etc.
}