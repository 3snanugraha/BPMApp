<?php
require_once __DIR__ . '/../../Config/Database.php';

class NotifikasiPasienAjax
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function handleRequest()
    {
        header('Content-Type: application/json');

        $userId = $_POST['user_id'] ?? null;

        // Get patient_id from user_id
        $patientQuery = "SELECT patient_id FROM patient_profiles WHERE user_id = ?";
        $patientId = $this->db->query($patientQuery, [$userId])->fetch(PDO::FETCH_COLUMN);

        $response = [
            'recommendations' => $this->getLatestRecommendations($patientId),
            'prescriptions' => $this->getLatestPrescriptions($patientId)
        ];

        echo json_encode($response);
        exit;
    }

    private function getLatestRecommendations($patientId)
    {
        $query = "SELECT 
                    pr.title,
                    pr.created_at,
                    dp.full_name as doctor_name
                FROM patient_recommendations pr
                JOIN doctor_profiles dp ON pr.created_by = dp.user_id
                WHERE pr.patient_id = ?
                ORDER BY pr.created_at DESC
                LIMIT 2";
        return $this->db->query($query, [$patientId])->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getLatestPrescriptions($patientId)
    {
        $query = "SELECT 
                    m.name as medication_name,
                    pm.start_date as created_at,
                    dp.full_name as doctor_name
                FROM patient_medications pm
                JOIN medications m ON pm.medication_id = m.medication_id
                JOIN doctor_profiles dp ON pm.prescribed_by = dp.doctor_id
                WHERE pm.patient_id = ?
                ORDER BY pm.start_date DESC
                LIMIT 2";
        return $this->db->query($query, [$patientId])->fetchAll(PDO::FETCH_ASSOC);
    }

}

if (isset($_POST['action']) && $_POST['action'] === 'getLatestNotifications') {
    $ajax = new NotifikasiPasienAjax();
    $ajax->handleRequest();
}
