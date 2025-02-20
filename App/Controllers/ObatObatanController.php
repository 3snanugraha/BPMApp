<?php
require_once __DIR__ . '/../Models/ObatObatanModel.php';

class ObatObatanController
{
    private $obatModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->obatModel = new ObatObatanModel();
    }

    public function handleRequest()
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        switch ($action) {
            case 'add_medication':
                $this->handleAddMedication();
                break;
            case 'edit_medication':
                $this->handleEditMedication();
                break;
            case 'delete_medication':
                $this->handleDeleteMedication();
                break;
            case 'prescribe_medication':
                $this->handlePrescribeMedication();
                break;
            case 'update_prescription':
                $this->handleUpdatePrescription();
                break;
            case 'delete_prescription':
                $this->handleDeletePrescription();
                break;
            default:
                header('Location: ../Views/obat.php');
                exit();
        }
    }

    private function handleAddMedication()
    {
        $medicationData = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'dosage_form' => $_POST['dosage_form'], // Will contain format like "Tablet 5mg"
            'created_by' => $_SESSION['user_id']
        ];

        if ($this->obatModel->addMedication($medicationData)) {
            $_SESSION['success'] = 'Obat berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan obat';
        }

        header('Location: ../Views/obat.php');
        exit();
    }

    private function handleEditMedication()
    {
        $medicationId = $_POST['medication_id'];
        $medicationData = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'dosage_form' => $_POST['dosage_form']
        ];

        if ($this->obatModel->updateMedication($medicationId, $medicationData)) {
            $_SESSION['success'] = 'Data obat berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui data obat';
        }

        header('Location: ../Views/obat.php');
        exit();
    }

    private function handleDeleteMedication()
    {
        $medicationId = $_POST['medication_id'];

        if ($this->obatModel->deleteMedication($medicationId)) {
            $_SESSION['success'] = 'Obat berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus obat';
        }

        header('Location: ../Views/obat.php');
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

        if ($this->obatModel->prescribeMedication($prescriptionData)) {
            $_SESSION['success'] = 'Resep berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan resep';
        }

        header('Location: ../Views/prescriptions.php');
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

        if ($this->obatModel->updatePrescription($prescriptionId, $prescriptionData)) {
            $_SESSION['success'] = 'Resep berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui resep';
        }

        header('Location: ../Views/prescriptions.php');
        exit();
    }

    private function handleDeletePrescription()
    {
        $prescriptionId = $_POST['prescription_id'];

        if ($this->obatModel->deletePrescription($prescriptionId)) {
            $_SESSION['success'] = 'Resep berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus resep';
        }

        header('Location: ../Views/prescriptions.php');
        exit();
    }

    // Public methods for view data
    public function getAllMedications()
    {
        return $this->obatModel->getAllMedications();
    }

    public function getMedicationById($medicationId)
    {
        return $this->obatModel->getMedicationById($medicationId);
    }

    public function getPatientMedications($patientId)
    {
        return $this->obatModel->getPatientMedications($patientId);
    }

    public function getActivePrescriptions()
    {
        return $this->obatModel->getActivePrescriptions();
    }
}

// Handle incoming requests
if (isset($_POST['action'])) {
    $controller = new ObatObatanController();
    $controller->handleRequest();
}
