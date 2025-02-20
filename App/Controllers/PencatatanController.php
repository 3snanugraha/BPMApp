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
            default:
                header('Location: ../Views/pencatatan.php');
                exit();
        }
    }

    private function handleAddReading()
    {
        $readingData = [
            'patient_id' => $_SESSION['user_id'],
            'systolic' => $_POST['systolic'],
            'diastolic' => $_POST['diastolic'],
            'pulse_rate' => $_POST['pulse_rate'],
            'notes' => $_POST['notes']
        ];

        $readingId = $this->pencatatanModel->addReading($readingData);

        if ($readingId) {
            $_SESSION['success'] = 'Data tekanan darah berhasil ditambahkan';

            // Get latest reading with recommendation
            $latestReading = $this->pencatatanModel->getLatestReading($_SESSION['user_id']);

            // Return JSON response for AJAX request
            if (
                isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            ) {

                echo json_encode([
                    'success' => true,
                    'reading' => $latestReading
                ]);
                exit();
            }
        } else {
            $_SESSION['error'] = 'Gagal menambahkan data tekanan darah';

            if (
                isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            ) {

                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal menambahkan data'
                ]);
                exit();
            }
        }

        header('Location: ../Views/pencatatan.php');
        exit();
    }

    // Public methods for view data
    public function getTodayReadings()
    {
        return $this->pencatatanModel->getTodayReadings($_SESSION['user_id']);
    }

    public function getLatestReading($patientId = null)
    {
        // If no patientId provided, use the logged in user's ID
        $id = $patientId ?? $_SESSION['user_id'];
        return $this->pencatatanModel->getLatestReading($id);
    }


    public function getTotalReadings()
    {
        return $this->pencatatanModel->getTotalReadings();
    }

    public function getReadingTrend($days = 7)
    {
        return $this->pencatatanModel->getReadingTrend($_SESSION['user_id'], $days);
    }

    public function getAbnormalReadings($days = 30)
    {
        return $this->pencatatanModel->getAbnormalReadings($_SESSION['user_id'], $days);
    }

    public function getDoctorPatients()
    {
        if ($_SESSION['role'] === 'doctor') {
            return $this->pencatatanModel->getDoctorPatients($_SESSION['user_id']);
        }
        return [];
    }

    public function getPatientProfile($patientId = null)
    {
        $id = $patientId ?? $_SESSION['user_id'];
        return $this->pencatatanModel->getPatientProfile($id);
    }

    public function validateReading($systolic, $diastolic, $pulseRate)
    {
        $errors = [];

        if ($systolic < 70 || $systolic > 200) {
            $errors[] = 'Nilai systolic tidak valid (70-200 mmHg)';
        }

        if ($diastolic < 40 || $diastolic > 130) {
            $errors[] = 'Nilai diastolic tidak valid (40-130 mmHg)';
        }

        if ($pulseRate < 40 || $pulseRate > 200) {
            $errors[] = 'Nilai detak jantung tidak valid (40-200 bpm)';
        }

        return $errors;
    }
}

// Handle incoming requests
if (isset($_POST['action'])) {
    $controller = new PencatatanController();
    $controller->handleRequest();
}
