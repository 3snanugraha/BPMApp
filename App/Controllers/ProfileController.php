<?php
require_once __DIR__ . '/../Models/ProfileModel.php';

class ProfileController
{
    private $profileModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->profileModel = new ProfileModel();
    }

    public function handleRequest()
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        switch ($action) {
            case 'update_profile':
                $this->handleUpdateProfile();
                break;
            case 'update_password':
                $this->handleUpdatePassword();
                break;
            default:
                header('Location: ../Views/profil.php');
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
        $role = $_SESSION['role'];

        switch ($role) {
            case 'admin':
                $profileData = [
                    'email' => $_POST['email'],
                    'username' => $_POST['username']
                ];
                $success = $this->profileModel->updateAdminProfile($userId, $profileData);
                break;

            case 'doctor':
                $profileData = [
                    'email' => $_POST['email'],
                    'full_name' => $_POST['full_name'],
                    'specialization' => $_POST['specialization'],
                    'phone_number' => $_POST['phone_number']
                ];
                $success = $this->profileModel->updateDoctorProfile($userId, $profileData);
                break;

            case 'patient':
                $profileData = [
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
                $success = $this->profileModel->updatePatientProfile($userId, $profileData);
                break;

            default:
                $_SESSION['error'] = 'Role tidak valid';
                header('Location: ../Views/profil.php');
                exit();
        }

        if ($success) {
            $_SESSION['success'] = 'Profil berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui profil';
        }

        header('Location: ../Views/profil.php');
        exit();
    }

    private function handleUpdatePassword()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Sesi tidak valid';
            header('Location: ../Views/index.php');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if (!$this->profileModel->checkCurrentPassword($userId, $currentPassword)) {
            $_SESSION['error'] = 'Password saat ini salah';
            header('Location: ../Views/profil.php');
            exit();
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Password baru tidak cocok';
            header('Location: ../Views/profil.php');
            exit();
        }

        if ($this->profileModel->updatePassword($userId, $newPassword)) {
            $_SESSION['success'] = 'Password berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui password';
        }

        header('Location: ../Views/profil.php');
        exit();
    }

    // Public methods for view data
    public function getProfileData()
    {
        $userId = $_SESSION['user_id'];
        $role = $_SESSION['role'];

        switch ($role) {
            case 'admin':
                return $this->profileModel->getAdminProfile($userId);
            case 'doctor':
                return $this->profileModel->getDoctorProfile($userId);
            case 'patient':
                return $this->profileModel->getPatientProfile($userId);
            default:
                return null;
        }
    }

    public function getProfileStats()
    {
        $userId = $_SESSION['user_id'];
        $role = $_SESSION['role'];
        return $this->profileModel->getProfileStats($userId, $role);
    }
}

// Handle incoming requests
if (isset($_POST['action'])) {
    $controller = new ProfileController();
    $controller->handleRequest();
}
