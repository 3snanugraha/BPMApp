<?php
require_once __DIR__ . '/../Models/RekomendasiModel.php';

class RekomendasiController
{
    private $rekomendasiModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->rekomendasiModel = new RekomendasiModel();
    }

    public function handleRequest()
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        switch ($action) {
            case 'add_recommendation':
                $this->handleAddRecommendation();
                break;
            case 'edit_recommendation':
                $this->handleEditRecommendation();
                break;
            case 'delete_recommendation':
                $this->handleDeleteRecommendation();
                break;
            case 'assign_recommendation':
                $this->handleAssignRecommendation();
                break;
            default:
                header('Location: ../Views/rekomendasi.php');
                exit();
        }
    }

    private function handleAddRecommendation()
    {
        $recommendationData = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'bp_range_systolic_min' => $_POST['systolic_min'],
            'bp_range_systolic_max' => $_POST['systolic_max'],
            'bp_range_diastolic_min' => $_POST['diastolic_min'],
            'bp_range_diastolic_max' => $_POST['diastolic_max'],
            'created_by' => $_SESSION['user_id']
        ];

        if ($this->rekomendasiModel->addRecommendation($recommendationData)) {
            $_SESSION['success'] = 'Rekomendasi berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan rekomendasi';
        }

        header('Location: ../Views/rekomendasi.php');
        exit();
    }

    private function handleEditRecommendation()
    {
        $recommendationId = $_POST['recommendation_id'];
        $recommendationData = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'bp_range_systolic_min' => $_POST['systolic_min'],
            'bp_range_systolic_max' => $_POST['systolic_max'],
            'bp_range_diastolic_min' => $_POST['diastolic_min'],
            'bp_range_diastolic_max' => $_POST['diastolic_max']
        ];

        if ($this->rekomendasiModel->updateRecommendation($recommendationId, $recommendationData)) {
            $_SESSION['success'] = 'Rekomendasi berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui rekomendasi';
        }

        header('Location: ../Views/rekomendasi.php');
        exit();
    }

    private function handleDeleteRecommendation()
    {
        $recommendationId = $_POST['recommendation_id'];

        if ($this->rekomendasiModel->deleteRecommendation($recommendationId)) {
            $_SESSION['success'] = 'Rekomendasi berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus rekomendasi';
        }

        header('Location: ../Views/rekomendasi.php');
        exit();
    }

    private function handleAssignRecommendation()
    {
        $patientRecommendationData = [
            'patient_id' => $_POST['patient_id'],
            'recommendation_id' => $_POST['recommendation_id'],
            'reading_id' => $_POST['reading_id']
        ];

        if ($this->rekomendasiModel->addPatientRecommendation($patientRecommendationData)) {
            $_SESSION['success'] = 'Rekomendasi berhasil diberikan ke pasien';
        } else {
            $_SESSION['error'] = 'Gagal memberikan rekomendasi ke pasien';
        }

        header('Location: ../Views/pasien/detail.php?id=' . $_POST['patient_id']);
        exit();
    }

    // Public methods for view data
    public function getAllRecommendations()
    {
        return $this->rekomendasiModel->getAllRecommendations();
    }

    public function getRecommendationById($recommendationId)
    {
        return $this->rekomendasiModel->getRecommendationById($recommendationId);
    }

    public function getPatientRecommendations($patientId)
    {
        return $this->rekomendasiModel->getPatientRecommendations($patientId);
    }

    public function getRecommendationByBPReadings($systolic, $diastolic)
    {
        return $this->rekomendasiModel->getRecommendationByBPReadings($systolic, $diastolic);
    }

    public function getRecommendationStats()
    {
        return $this->rekomendasiModel->getRecommendationStats();
    }
}

// Handle incoming requests
if (isset($_POST['action'])) {
    $controller = new RekomendasiController();
    $controller->handleRequest();
}
