<?php
require_once __DIR__ . '/../Models/RiwayatModel.php';

class RiwayatController
{
    private $riwayatModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->riwayatModel = new RiwayatModel();
    }

    public function handleRequest()
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        switch ($action) {
            case 'add_reading':
                $this->handleAddReading();
                break;
            case 'edit_reading':
                $this->handleEditReading();
                break;
            case 'delete_reading':
                $this->handleDeleteReading();
                break;
            default:
                header('Location: ../Views/riwayat.php');
                exit();
        }
    }

    private function handleAddReading()
    {
        $readingData = [
            'patient_id' => $_POST['patient_id'],
            'systolic' => $_POST['systolic'],
            'diastolic' => $_POST['diastolic'],
            'pulse_rate' => $_POST['pulse_rate'],
            'notes' => $_POST['notes']
        ];

        if ($this->riwayatModel->addReading($readingData)) {
            $_SESSION['success'] = 'Data tekanan darah berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan data tekanan darah';
        }

        header('Location: ../Views/riwayat.php');
        exit();
    }

    private function handleEditReading()
    {
        $readingId = $_POST['reading_id'];
        $readingData = [
            'systolic' => $_POST['systolic'],
            'diastolic' => $_POST['diastolic'],
            'pulse_rate' => $_POST['pulse_rate'],
            'notes' => $_POST['notes']
        ];

        if ($this->riwayatModel->updateReading($readingId, $readingData)) {
            $_SESSION['success'] = 'Data tekanan darah berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui data tekanan darah';
        }

        header('Location: ../Views/riwayat.php');
        exit();
    }

    private function handleDeleteReading()
    {
        $readingId = $_POST['reading_id'];

        if ($this->riwayatModel->deleteReading($readingId)) {
            $_SESSION['success'] = 'Data tekanan darah berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus data tekanan darah';
        }

        header('Location: ../Views/riwayat.php');
        exit();
    }

    // Public methods for view data
    public function getReadings()
    {
        $userRole = $_SESSION['role'];
        $userId = $_SESSION['user_id'];

        switch ($userRole) {
            case 'admin':
                return $this->riwayatModel->getAllReadings();
            case 'doctor':
                return $this->riwayatModel->getDoctorPatientReadings($userId);
            case 'patient':
                return $this->riwayatModel->getPatientReadings($userId);
            default:
                return [];
        }
    }

    public function getReadingById($readingId)
    {
        return $this->riwayatModel->getReadingById($readingId);
    }

    public function getReadingStats()
    {
        $userRole = $_SESSION['role'];
        $userId = $_SESSION['user_id'];

        if ($userRole === 'patient') {
            return $this->riwayatModel->getReadingStats($userId);
        }
        return $this->riwayatModel->getReadingStats();
    }

    public function getMonthlyAverages()
    {
        $userRole = $_SESSION['role'];
        $userId = $_SESSION['user_id'];

        if ($userRole === 'patient') {
            return $this->riwayatModel->getMonthlyAverages($userId);
        }
        return $this->riwayatModel->getMonthlyAverages();
    }
}

// Handle incoming requests
if (isset($_POST['action'])) {
    $controller = new RiwayatController();
    $controller->handleRequest();
}
