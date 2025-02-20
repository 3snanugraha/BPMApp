<?php
require_once __DIR__ . '/../Models/PasienModel.php';

class PasienController
{
    private $pasienModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->pasienModel = new PasienModel();
    }

    public function handleRequest()
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        switch ($action) {
            case 'add_patient':
                $this->handleAddPatient();
                break;
            case 'edit_patient':
                $this->handleEditPatient();
                break;
            case 'delete_patient':
                $this->handleDeletePatient();
                break;
            case 'add_blood_pressure':
                $this->handleAddBloodPressure();
                break;
            case 'update_profile':
                $this->handleUpdateProfile();
                break;
            default:
                header('Location: ../Views/pasien.php');
                exit();
        }
    }

    private function handleAddPatient()
    {
        $userData = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'email' => $_POST['email']
        ];

        $profileData = [
            'full_name' => $_POST['full_name'],
            'date_of_birth' => $_POST['date_of_birth'],
            'gender' => $_POST['gender'],
            'address' => $_POST['address'],
            'phone_number' => $_POST['phone_number'],
            'emergency_contact' => $_POST['emergency_contact'],
            'emergency_phone' => $_POST['emergency_phone'],
            'medical_history' => $_POST['medical_history']
        ];

        if ($this->pasienModel->addPatient($userData, $profileData)) {
            $_SESSION['success'] = 'Pasien berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan pasien';
        }

        header('Location: ../Views/pasien.php');
        exit();
    }

    private function handleEditPatient()
    {
        $patientId = $_POST['patient_id'];
        $patientData = [
            'email' => $_POST['email'],
            'full_name' => $_POST['full_name'],
            'date_of_birth' => $_POST['date_of_birth'],
            'gender' => $_POST['gender'],
            'address' => $_POST['address'],
            'phone_number' => $_POST['phone_number'],
            'emergency_contact' => $_POST['emergency_contact'],
            'emergency_phone' => $_POST['emergency_phone'],
            'medical_history' => $_POST['medical_history']
        ];

        if ($this->pasienModel->editPatient($patientId, $patientData)) {
            $_SESSION['success'] = 'Data pasien berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui data pasien';
        }

        header('Location: ../Views/pasien.php');
        exit();
    }

    private function handleDeletePatient()
    {
        $patientId = $_POST['patient_id'];

        if ($this->pasienModel->deletePatient($patientId)) {
            $_SESSION['success'] = 'Pasien berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus pasien';
        }

        header('Location: ../Views/pasien.php');
        exit();
    }

    private function handleAddBloodPressure()
    {
        $readingData = [
            'patient_id' => $_POST['patient_id'],
            'systolic' => $_POST['systolic'],
            'diastolic' => $_POST['diastolic'],
            'pulse_rate' => $_POST['pulse_rate'],
            'notes' => $_POST['notes']
        ];

        if ($this->pasienModel->addBloodPressureReading($readingData)) {
            $_SESSION['success'] = 'Data tekanan darah berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan data tekanan darah';
        }

        header('Location: ../Views/pasien/readings.php');
        exit();
    }

    private function handleUpdateProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Sesi tidak valid';
            header('Location: ../Views/index.php');
            exit();
        }

        $patientId = $_SESSION['user_id'];
        $profileData = [
            'full_name' => $_POST['full_name'],
            'date_of_birth' => $_POST['date_of_birth'],
            'gender' => $_POST['gender'],
            'address' => $_POST['address'],
            'phone_number' => $_POST['phone_number'],
            'emergency_contact' => $_POST['emergency_contact'],
            'emergency_phone' => $_POST['emergency_phone'],
            'medical_history' => $_POST['medical_history']
        ];

        if ($this->pasienModel->updateProfile($patientId, $profileData)) {
            $_SESSION['success'] = 'Profil berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui profil';
        }

        header('Location: ../Views/profile.php');
        exit();
    }

    // Public methods for view data
    public function getAllPatients()
    {
        return $this->pasienModel->getAllPatients();
    }

    public function getPatientById($patientId)
    {
        return $this->pasienModel->getPatientById($patientId);
    }

    public function getPatientBloodPressureReadings($patientId)
    {
        return $this->pasienModel->getPatientBloodPressureReadings($patientId);
    }

    public function getPatientMedications($patientId)
    {
        return $this->pasienModel->getPatientMedications($patientId);
    }

    public function getPatientRecommendations($patientId)
    {
        return $this->pasienModel->getPatientRecommendations($patientId);
    }

    public function getAssignedDoctors($patientId)
    {
        return $this->pasienModel->getAssignedDoctors($patientId);
    }
}

// Handle incoming requests
if (isset($_POST['action'])) {
    $controller = new PasienController();
    $controller->handleRequest();
}
