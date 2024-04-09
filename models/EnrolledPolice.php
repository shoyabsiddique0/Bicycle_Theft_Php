<?php
class EnrolledPolice {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function enroll($officerId, $adminId) {
        $query = "INSERT INTO enrolled_police (officer_id, admin_id, enrollment_status) VALUES (?, ?, 'active')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $officerId, $adminId);
        return $stmt->execute();
    }

    public function getAllEnrolledOfficers() {
        $query = "SELECT * FROM users WHERE role = 'police'";
        $result = $this->conn->query($query);
        $data =$result->fetch_all(MYSQLI_ASSOC);
        $_SESSION['enrolled_police'] = $data;
        return $data; 
    }
}