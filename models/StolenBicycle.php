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
                  JOIN users u ON b.user_id = u.id
                  WHERE u.id = ".$_SESSION['user_id'];
        $result = $this->conn->query($query);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $_SESSION['stolen_bicycle'] = $data;
        return $data;
    }
    
    public function getRecentReports($daysInterval = 7) {
        $interval = "-$daysInterval days";
        $query = "SELECT sb.id, sb.report_date, sb.status, b.brand, b.model, b.color, b.serial_number, sb.reported_address
                  FROM stolen_bicycles sb
                  JOIN bicycles b ON sb.bicycle_id = b.id
                  WHERE sb.report_date >= DATE_SUB(NOW(), INTERVAL $daysInterval DAY)
                  ORDER BY sb.report_date DESC";

        $stmt = $this->conn->prepare($query);
        // $stmt->bind_param('s', $interval);
        $stmt->execute();
        $result = $stmt->get_result();

        $recentReports = array();
        while ($row = $result->fetch_assoc()) {
            $recentReports[] = $row;
        }

        return $recentReports;
    }
    
    public function getReportedBicycles($filter = 'all') {
        $query = "SELECT sb.id, sb.report_date, sb.status, b.brand, b.model, b.color, b.serial_number, sb.reported_address
                  FROM stolen_bicycles sb
                  JOIN bicycles b ON sb.bicycle_id = b.id";

        switch ($filter) {
            case 'week':
                $query .= " WHERE sb.report_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                break;
            case 'month':
                $query .= " WHERE sb.report_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
                break;
            case 'year':
                $query .= " WHERE sb.report_date >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
                break;
            case 'all':
            default:
                // No additional filter, fetch all reports
                break;
        }

        $query .= " ORDER BY sb.report_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $reports = array();
        while ($row = $result->fetch_assoc()) {
            $reports[] = $row;
        }

        return $reports;
    }
    
    public function updateStatus($reportId, $newStatus)
    {
        $query = "UPDATE stolen_bicycles SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $newStatus, $reportId);
        $result = $stmt->execute();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}