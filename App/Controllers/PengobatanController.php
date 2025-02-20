<?php
require_once __DIR__ . '/../Models/PengobatanModel.php';

class PengobatanController
{
    private $pengobatanModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->pengobatanModel = new PengobatanModel();
    }

    public function handleRequest()
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        switch ($action) {
            case 'add_prescription':
                $this->handleAddPrescription();
                break;
            case 'edit_prescription':
                $this->handleEditPrescription();
                break;
            case 'delete_prescription':
                $this->handleDeletePrescription();
                break;
            default:
                header('Location: ../Views/pengobatan.php');
                exit();
        }
    }

    private function handleAddPrescription()
    {
        if (!in_array($_SESSION['role'], ['admin', 'doctor'])) {
            $_SESSION['error'] = 'Unauthorized access';
            header('Location: ../Views/dashboard.php');
            exit();
        }

        $prescriptionData = [
            'patient_id' => $_POST['patient_id'],
            'medication_id' => $_POST['medication_id'],
            'dosage' => $_POST['dosage'],
            'frequency' => $_POST['frequency'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'prescribed_by' => $_SESSION['user_id'],
            'notes' => $_POST['notes']
        ];

        if ($this->pengobatanModel->addPrescription($prescriptionData)) {
            $_SESSION['success'] = 'Pengobatan berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan pengobatan';
        }

        header('Location: ../Views/pengobatan.php');
        exit();
    }

    private function handleEditPrescription()
    {
        if (!in_array($_SESSION['role'], ['admin', 'doctor'])) {
            $_SESSION['error'] = 'Unauthorized access';
            header('Location: ../Views/dashboard.php');
            exit();
        }

        $prescriptionId = $_POST['prescription_id'];
        $prescriptionData = [
            'dosage' => $_POST['dosage'],
            'frequency' => $_POST['frequency'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'notes' => $_POST['notes']
        ];

        if ($this->pengobatanModel->updatePrescription($prescriptionId, $prescriptionData)) {
            $_SESSION['success'] = 'Pengobatan berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui pengobatan';
        }

        header('Location: ../Views/pengobatan.php');
        exit();
    }

    private function handleDeletePrescription()
    {
        if (!in_array($_SESSION['role'], ['admin', 'doctor'])) {
            $_SESSION['error'] = 'Unauthorized access';
            header('Location: ../Views/dashboard.php');
            exit();
        }

        $prescriptionId = $_POST['prescription_id'];

        if ($this->pengobatanModel->deletePrescription($prescriptionId)) {
            $_SESSION['success'] = 'Pengobatan berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus pengobatan';
        }

        header('Location: ../Views/pengobatan.php');
        exit();
    }

    // Public methods for view data
    public function getAllPrescriptions()
    {
        if ($_SESSION['role'] === 'patient') {
            // Get prescriptions for logged in patient
            return $this->pengobatanModel->getPatientPrescriptions($_SESSION['user_id']);
        }
        // Admin and doctor see all prescriptions
        return $this->pengobatanModel->getAllPrescriptions();
    }

    public function getPrescriptionById($prescriptionId)
    {
        if (in_array($_SESSION['role'], ['admin', 'doctor'])) {
            return $this->pengobatanModel->getPrescriptionById($prescriptionId);
        }
        return null;
    }

    public function getPatientPrescriptions($patientId)
    {
        if ($_SESSION['role'] === 'patient' && $_SESSION['user_id'] != $patientId) {
            return [];
        }
        return $this->pengobatanModel->getPatientPrescriptions($patientId);
    }

    public function getDoctorPrescriptions($doctorId)
    {
        if ($_SESSION['role'] === 'doctor' && $_SESSION['user_id'] != $doctorId) {
            return [];
        }
        return $this->pengobatanModel->getDoctorPrescriptions($doctorId);
    }

    public function getActivePrescriptions()
    {
        return $this->pengobatanModel->getActivePrescriptions();
    }

    public function getExpiredPrescriptions()
    {
        return $this->pengobatanModel->getExpiredPrescriptions();
    }
}

// Handle incoming requests
if (isset($_POST['action'])) {
    $controller = new PengobatanController();
    $controller->handleRequest();
}
