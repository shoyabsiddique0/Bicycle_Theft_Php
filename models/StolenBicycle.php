<?php

class StolenBicycle
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function reportStolenBicycle($bicycleId, $reportedAddress)
    {
        $query = "INSERT INTO stolen_bicycles (bicycle_id, reported_address) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("is", $bicycleId, $reportedAddress);
        return $stmt->execute();
    }

    public function getStolenBicycleReports()
    {
        $query = "SELECT sb.id, sb.report_date, sb.status, b.brand, b.model, b.color, b.serial_number, u.username
                  FROM stolen_bicycles sb
                  JOIN bicycles b ON sb.bicycle_id = b.id
                  JOIN users u ON b.user_id = u.id";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Add other methods for updating status, etc.
}