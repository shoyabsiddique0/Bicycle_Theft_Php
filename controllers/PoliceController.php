<?php
require_once '../../models/User.php';
require_once '../../models/StolenBicycle.php';

class PoliceController {
    private $userModel;
    private $stolenBicycleModel;

    public function __construct($db) {
        $this->userModel = new User($db);
        $this->stolenBicycleModel = new StolenBicycle($db);
    }

    public function viewReportedBicycles() {
        $filters = array();

        if (isset($_GET['filter'])) {
            $filters = explode(',', $_GET['filter']);
        }

        $reports = $this->stolenBicycleModel->getReportedBicycles($filters);
        require_once '../../views/police/reported_bicycles.php';
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reportId = $_POST['report_id'];
            $newStatus = $_POST['new_status'];

            $success = $this->stolenBicycleModel->updateStatus($reportId, $newStatus);

            if ($success) {
                $message = "Investigation status updated successfully.";
            } else {
                $message = "Failed to update investigation status.";
            }
        }

        require_once '../../views/police/update_status.php';
    }

    public function searchReports() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchTerm = $_POST['search_term'];
            $reports = $this->stolenBicycleModel->searchReports($searchTerm);
        } else {
            $reports = array();
        }

        require_once '../../views/police/search_reports.php';
    }
    public function fetchRecentReports($days = 7) {
        // Fetch recent reports from the model
        $recentReports = $this->stolenBicycleModel->getRecentReports($days);

        // Prepare the report data for display
        $formattedReports = array();
        foreach ($recentReports as $report) {
            $formattedReport = array(
                'id' => $report['id'],
                'brand' => $report['brand'],
                'model' => $report['model'],
                'color' => $report['color'],
                'serial_number' => $report['serial_number'],
                'address' => $report['reported_address'],
                'report_date' => date('Y-m-d', strtotime($report['report_date'])),
                'status' => $report['status']
            );
            $formattedReports[] = $formattedReport;
        }

        return $formattedReports;
    }

    public function fetchReportedBicycles($filter = 'all') {
        $reports = $this->stolenBicycleModel->getReportedBicycles($filter);

        // Prepare the report data for display
        $formattedReports = array();
        foreach ($reports as $report) {
            $formattedReport = array(
                'id' => $report['id'],  
                'brand' => $report['brand'],
                'model' => $report['model'],
                'color' => $report['color'],
                'serial_number' => $report['serial_number'],
                'address' => $report['reported_address'],
                'report_date' => date('Y-m-d', strtotime($report['report_date'])),
                'status' => $report['status']
            );
            $formattedReports[] = $formattedReport;
        }

        return $formattedReports;
    }
}