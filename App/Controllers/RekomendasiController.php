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
            default:
                header('Location: ../Views/rekomendasi.php');
                exit();
        }
    }

    private function handleAddRecommendation()
    {
        $recommendationData = [
            'patient_id' => $_POST['patient_id'],
            'reading_id' => $_POST['reading_id'],
            'title' => $_POST['title'],
            'description' => $_POST['description'],
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
        if (!in_array($_SESSION['role'], ['admin', 'doctor'])) {
            $_SESSION['error'] = 'Unauthorized access';
            header('Location: ../Views/dashboard.php');
            exit();
        }

        $recommendationId = $_POST['recommendation_id'];
        $recommendationData = [
            'title' => $_POST['title'],
            'description' => $_POST['description']
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
        if (!in_array($_SESSION['role'], ['admin', 'doctor'])) {
            $_SESSION['error'] = 'Unauthorized access';
            header('Location: ../Views/dashboard.php');
            exit();
        }

        $recommendationId = $_POST['recommendation_id'];

        if ($this->rekomendasiModel->deleteRecommendation($recommendationId)) {
            $_SESSION['success'] = 'Rekomendasi berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus rekomendasi';
        }

        header('Location: ../Views/rekomendasi.php');
        exit();
    }

    // Public methods for view data
    public function getAllRecommendations()
    {
        if ($_SESSION['role'] === 'patient') {
            return $this->rekomendasiModel->getPatientRecommendations($_SESSION['user_id']);
        }
        return $this->rekomendasiModel->getAllRecommendations();
    }

    public function getRecommendationById($recommendationId)
    {
        if (in_array($_SESSION['role'], ['admin', 'doctor'])) {
            return $this->rekomendasiModel->getRecommendationById($recommendationId);
        }
        return null;
    }

    public function getPatientRecommendations($patientId)
    {
        if ($_SESSION['role'] === 'patient' && $_SESSION['user_id'] != $patientId) {
            return [];
        }
        return $this->rekomendasiModel->getPatientRecommendations($patientId);
    }

    public function getRecommendationStats()
    {
        if (in_array($_SESSION['role'], ['admin', 'doctor'])) {
            return $this->rekomendasiModel->getRecommendationStats();
        }
        return [];
    }
}

if (isset($_POST['action'])) {
    $controller = new RekomendasiController();
    $controller->handleRequest();
}
