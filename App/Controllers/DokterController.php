<?php
require_once __DIR__ . '/../Models/DokterModel.php';

class DokterController
{
    private $dokterModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->dokterModel = new DokterModel();
    }

    public function handleRequest()
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        switch ($action) {
            case 'update_profile':
                $this->handleUpdateProfile();
                break;
            case 'assign_patient':
                $this->handleAssignPatient();
                break;
            case 'remove_patient':
                $this->handleRemovePatient();
                break;
            case 'prescribe_medication':
                $this->handlePrescribeMedication();
                break;
            case 'update_prescription':
                $this->handleUpdatePrescription();
                break;
            case 'add_recommendation':
                $this->handleAddRecommendation();
                break;
            case 'add_doctor':
                $this->handleAddDoctor();
                break;
            case 'delete_doctor':
                $this->handleDeleteDoctor();
                break;
            case 'edit_doctor':
                $this->handleEditDoctor();
                break;
            default:
                header('Location: ../Views/dokter/dashboard.php');
                exit();
        }
    }

    private function handleUpdateProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Sesi tidak valid';
            header('Location: ../Views/index.php');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $profileData = [
            'full_name' => $_POST['full_name'],
            'specialization' => $_POST['specialization'],
            'phone_number' => $_POST['phone_number']
        ];

        if ($this->dokterModel->updateDoctorProfile($userId, $profileData)) {
            $_SESSION['success'] = 'Profil berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui profil';
        }

        header('Location: ../Views/dokter.php');
        exit();
    }

    private function handleAddDoctor()
    {
        $userData = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'email' => $_POST['email']
        ];

        $profileData = [
            'full_name' => $_POST['full_name'],
            'specialization' => $_POST['specialization'],
            'license_number' => $_POST['license_number'],
            'phone_number' => $_POST['phone_number']
        ];

        if ($this->dokterModel->addDoctor($userData, $profileData)) {
            $_SESSION['success'] = 'Dokter berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan dokter';
        }

        header('Location: ../Views/dokter.php');
        exit();
    }

    private function handleDeleteDoctor()
    {
        $doctorId = $_POST['doctor_id'];

        if ($this->dokterModel->deleteDoctor($doctorId)) {
            $_SESSION['success'] = 'Dokter berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus dokter';
        }

        header('Location: ../Views/dokter.php');
        exit();
    }

    private function handleAssignPatient()
    {
        $doctorId = $_POST['doctor_id'];
        $patientId = $_POST['patient_id'];

        if ($this->dokterModel->assignPatient($doctorId, $patientId)) {
            $_SESSION['success'] = 'Pasien berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan pasien';
        }

        header('Location: ../Views/dokter/patients.php');
        exit();
    }

    private function handleRemovePatient()
    {
        $doctorId = $_POST['doctor_id'];
        $patientId = $_POST['patient_id'];

        if ($this->dokterModel->removePatient($doctorId, $patientId)) {
            $_SESSION['success'] = 'Pasien berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus pasien';
        }

        header('Location: ../Views/dokter/patients.php');
        exit();
    }

    private function handlePrescribeMedication()
    {
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

        if ($this->dokterModel->prescribeMedication($prescriptionData)) {
            $_SESSION['success'] = 'Resep berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan resep';
        }

        header('Location: ../Views/dokter/prescriptions.php');
        exit();
    }

    private function handleUpdatePrescription()
    {
        $prescriptionId = $_POST['prescription_id'];
        $prescriptionData = [
            'dosage' => $_POST['dosage'],
            'frequency' => $_POST['frequency'],
            'end_date' => $_POST['end_date'],
            'notes' => $_POST['notes']
        ];

        if ($this->dokterModel->updatePrescription($prescriptionId, $prescriptionData)) {
            $_SESSION['success'] = 'Resep berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui resep';
        }

        header('Location: ../Views/dokter/prescriptions.php');
        exit();
    }

    private function handleEditDoctor()
    {
        $doctorId = $_POST['doctor_id'];
        $doctorData = [
            'email' => $_POST['email'],
            'full_name' => $_POST['full_name'],
            'specialization' => $_POST['specialization'],
            'license_number' => $_POST['license_number'],
            'phone_number' => $_POST['phone_number']
        ];

        if ($this->dokterModel->editDoctor($doctorId, $doctorData)) {
            $_SESSION['success'] = 'Data dokter berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui data dokter';
        }

        header('Location: ../Views/dokter.php');
        exit();
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

        if ($this->dokterModel->addHealthRecommendation($recommendationData)) {
            $_SESSION['success'] = 'Rekomendasi berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan rekomendasi';
        }

        header('Location: ../Views/dokter/recommendations.php');
        exit();
    }

    // Public methods for view data
    public function getDoctorProfile($userId)
    {
        return $this->dokterModel->getDoctorProfile($userId);
    }

    public function getAllDoctors()
    {
        return $this->dokterModel->getAllDoctors();
    }


    public function getDoctorPatients($doctorId)
    {
        return $this->dokterModel->getDoctorPatients($doctorId);
    }

    public function getPatientMedicalHistory($patientId)
    {
        return $this->dokterModel->getPatientMedicalHistory($patientId);
    }

    public function getPrescribedMedications($patientId)
    {
        return $this->dokterModel->getPrescribedMedications($patientId);
    }
}

// Handle incoming requests
if (isset($_POST['action'])) {
    $controller = new DokterController();
    $controller->handleRequest();
}
