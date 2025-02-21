<?php
require_once __DIR__ . '/../Models/PencatatanModel.php';

class PencatatanController
{
    private $pencatatanModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->pencatatanModel = new PencatatanModel();
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
                header('Location: ../Views/pencatatan.php');
                exit();
        }
    }


    private function handleAddReading()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Sesi tidak valid';
            header('Location: ../Views/index.php');
            exit();
        }

        $readingData = [
            'patient_id' => $_SESSION['role'] === 'patient'
                ? $this->pencatatanModel->getPatientIdByUserId($_SESSION['user_id'])
                : $_POST['patient_id'],
            'systolic' => $_POST['systolic'],
            'diastolic' => $_POST['diastolic'],
            'pulse_rate' => $_POST['pulse_rate'],
            'notes' => $_POST['notes']
        ];

        if ($this->pencatatanModel->addReading($readingData)) {
            $_SESSION['success'] = 'Data tekanan darah berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan data tekanan darah';
        }

        header('Location: ../Views/pencatatan.php');
        exit();
    }

    private function handleEditReading()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Sesi tidak valid';
            header('Location: ../Views/index.php');
            exit();
        }

        $readingId = $_POST['reading_id'];
        $reading = $this->pencatatanModel->getReadingById($readingId);

        // Check authorization
        if ($_SESSION['role'] === 'patient') {
            $patientId = $this->pencatatanModel->getPatientIdByUserId($_SESSION['user_id']);
            if ($reading['patient_id'] != $patientId) {
                $_SESSION['error'] = 'Tidak memiliki akses';
                header('Location: ../Views/pencatatan.php');
                exit();
            }
        }

        $readingData = [
            'systolic' => $_POST['systolic'],
            'diastolic' => $_POST['diastolic'],
            'pulse_rate' => $_POST['pulse_rate'],
            'notes' => $_POST['notes']
        ];

        if ($this->pencatatanModel->updateReading($readingId, $readingData)) {
            $_SESSION['success'] = 'Data tekanan darah berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui data tekanan darah';
        }

        header('Location: ../Views/pencatatan.php');
        exit();
    }

    private function handleDeleteReading()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Sesi tidak valid';
            header('Location: ../Views/index.php');
            exit();
        }

        $readingId = $_POST['reading_id'];
        $reading = $this->pencatatanModel->getReadingById($readingId);

        // For patient role, check if the reading belongs to them
        if ($_SESSION['role'] === 'patient') {
            $patientId = $this->pencatatanModel->getPatientIdByUserId($_SESSION['user_id']);
            if ($reading['patient_id'] != $patientId) {
                $_SESSION['error'] = 'Tidak memiliki akses';
                header('Location: ../Views/pencatatan.php');
                exit();
            }
        }

        // Delete related recommendations first due to foreign key constraint
        $this->pencatatanModel->deleteReadingRecommendations($readingId);

        // Then delete the reading
        if ($this->pencatatanModel->deleteReading($readingId)) {
            $_SESSION['success'] = 'Data tekanan darah berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus data tekanan darah';
        }

        header('Location: ../Views/pencatatan.php');
        exit();
    }

    // Public methods for view data
    public function getReadings()
    {
        if ($_SESSION['role'] === 'patient') {
            $patientId = $this->pencatatanModel->getPatientIdByUserId($_SESSION['user_id']);
            return $this->pencatatanModel->getPatientReadings($patientId);
        }
        return $this->pencatatanModel->getAllReadings();
    }

    public function getPatientsList()
    {
        if (in_array($_SESSION['role'], ['admin', 'doctor'])) {
            return $this->pencatatanModel->getPatientsList();
        }
        return [];
    }

    public function getReadingStats()
    {
        if ($_SESSION['role'] === 'patient') {
            $patientId = $this->pencatatanModel->getPatientIdByUserId($_SESSION['user_id']);
            return $this->pencatatanModel->getReadingStats($patientId);
        }
        return $this->pencatatanModel->getReadingStats();
    }
}

// Handle incoming requests
if (isset($_POST['action'])) {
    $controller = new PencatatanController();
    $controller->handleRequest();
}
