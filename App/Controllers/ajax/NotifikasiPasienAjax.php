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
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';

        switch ($action) {
            case 'getLatestNotifications':
                echo json_encode([
                    'recommendations' => $this->getLatestRecommendations($userId),
                    'prescriptions' => $this->getLatestPrescriptions($userId)
                ]);
                break;
        }
    }

    private function getLatestRecommendations($userId)
    {
        $query = "SELECT pr.title, pr.created_at, dp.full_name as doctor_name
                 FROM patient_recommendations pr
                 JOIN patient_profiles pp ON pr.patient_id = pp.patient_id
                 JOIN users u ON pr.created_by = u.user_id
                 JOIN doctor_profiles dp ON u.user_id = dp.user_id
                 WHERE pp.user_id = ?
                 ORDER BY pr.created_at DESC
                 LIMIT 2";
        return $this->db->query($query, [$userId])->fetchAll();
    }

    private function getLatestPrescriptions($userId)
    {
        $query = "SELECT m.name as medication_name, pm.created_at, dp.full_name as doctor_name
                 FROM patient_medications pm
                 JOIN patient_profiles pp ON pm.patient_id = pp.patient_id
                 JOIN medications m ON pm.medication_id = m.medication_id
                 JOIN doctor_profiles dp ON pm.prescribed_by = dp.doctor_id
                 WHERE pp.user_id = ?
                 ORDER BY pm.created_at DESC
                 LIMIT 2";
        return $this->db->query($query, [$userId])->fetchAll();
    }
}

if (isset($_POST['action'])) {
    $ajax = new NotifikasiPasienAjax();
    $ajax->handleRequest();
}
