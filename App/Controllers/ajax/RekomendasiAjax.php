<?php
require_once __DIR__ . '/../../Config/Database.php';

class RekomendasiAjax
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function handleRequest()
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        switch ($action) {
            case 'getPatients':
                echo json_encode($this->getPatients());
                break;
            case 'getPatientReadings':
                $patientId = $_POST['patient_id'];
                echo json_encode($this->getPatientReadings($patientId));
                break;
        }
    }

    private function getPatients()
    {
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        $query = "SELECT p.patient_id, p.full_name 
                 FROM patient_profiles p 
                 WHERE p.full_name LIKE ?
                 ORDER BY p.full_name ASC";
        return $this->db->query($query, ["%$search%"])->fetchAll();
    }


    private function getPatientReadings($patientId)
    {
        $query = "SELECT bpr.reading_id, bpr.systolic, bpr.diastolic, 
                         bpr.pulse_rate, bpr.reading_date, bpr.notes
                 FROM blood_pressure_readings bpr 
                 WHERE bpr.patient_id = ? 
                 ORDER BY bpr.reading_date DESC
                 LIMIT 3";
        return $this->db->query($query, [$patientId])->fetchAll();
    }
}

// Handle AJAX request
if (isset($_POST['action'])) {
    $ajax = new RekomendasiAjax();
    $ajax->handleRequest();
}
