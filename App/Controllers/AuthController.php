<?php
require_once __DIR__ . '/../Models/AuthModel.php';

class AuthController
{
    private $authModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->authModel = new AuthModel();
    }

    public function handleRequest()
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        switch ($action) {
            case 'login':
                $this->handleLogin();
                break;
            case 'register':
                $this->handleRegister();
                break;
            case 'logout':
                $this->handleLogout();
                break;
            case 'update_profile':
                $this->handleUpdateProfile();
                break;
            case 'update_password':
                $this->handleUpdatePassword();
                break;
            default:
                header('Location: ../Views/index.php');
                exit();
        }
    }

    private function handleLogin()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->authModel->login($username, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header('Location: ../Views/dashboard.php');
            exit();
        } else {
            $_SESSION['error'] = 'Username atau password salah';
            header('Location: ../Views/index.php');
            exit();
        }
    }

    private function handleRegister()
    {
        $userData = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'email' => $_POST['email'],
            'role' => $_POST['role']
        ];

        if ($this->authModel->checkUsernameExists($userData['username'])) {
            $_SESSION['error'] = 'Username sudah digunakan';
            header('Location: ../Views/index.php');
            exit();
        }

        if ($this->authModel->checkEmailExists($userData['email'])) {
            $_SESSION['error'] = 'Email sudah digunakan';
            header('Location: ../Views/index.php');
            exit();
        }

        $userId = $this->authModel->register($userData);

        if ($userId) {
            $profileData = [
                'role' => $_POST['role'],
                'full_name' => $_POST['full_name'],
                'phone_number' => $_POST['phone_number']
            ];

            if ($_POST['role'] === 'patient') {
                $profileData['date_of_birth'] = $_POST['date_of_birth'];
                $profileData['gender'] = $_POST['gender'];
                $profileData['address'] = $_POST['address'];
                $profileData['emergency_contact'] = $_POST['emergency_contact'];
                $profileData['emergency_phone'] = $_POST['emergency_phone'];
                $profileData['medical_history'] = $_POST['medical_history'];
            }

            $this->authModel->createUserProfile($userId, $profileData);

            $_SESSION['success'] = 'Registrasi berhasil, silakan login';
            header('Location: ../Views/index.php');
            exit();
        }
    }


    private function handleLogout()
    {
        session_destroy();
        header('Location: ../Views/index.php');
        exit();
    }

    private function handleUpdateProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../Views/index.php');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $role = $_SESSION['role'];

        $profileData = [
            'full_name' => $_POST['full_name'],
            'phone_number' => $_POST['phone_number']
        ];

        if ($role === 'doctor') {
            $profileData['specialization'] = $_POST['specialization'];
        } else if ($role === 'patient') {
            $profileData['address'] = $_POST['address'];
            $profileData['emergency_contact'] = $_POST['emergency_contact'];
            $profileData['emergency_phone'] = $_POST['emergency_phone'];
            $profileData['medical_history'] = $_POST['medical_history'];
        }

        if ($this->authModel->updateProfile($userId, $role, $profileData)) {
            $_SESSION['success'] = 'Profil berhasil diperbarui';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui profil';
        }

        header('Location: ../Views/profile.php');
        exit();
    }

    private function handleUpdatePassword()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../Views/index.php');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        $user = $this->authModel->getUserById($userId);

        if (!password_verify($currentPassword, $user['password'])) {
            $_SESSION['error'] = 'Password saat ini salah';
            header('Location: ../Views/change_password.php');
            exit();
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Password baru tidak cocok';
            header('Location: ../Views/change_password.php');
            exit();
        }

        if ($this->authModel->updatePassword($userId, $newPassword)) {
            $_SESSION['success'] = 'Password berhasil diperbarui';
            header('Location: ../Views/profile.php');
        } else {
            $_SESSION['error'] = 'Gagal memperbarui password';
            header('Location: ../Views/change_password.php');
        }
        exit();
    }

    // Add this new method to the AuthController class
    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    // Example usage for protected pages
    public function checkAuth()
    {
        if (!$this->isLoggedIn()) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu';
            header('Location: ../Views/index.php');
            exit();
        }
    }

    public function checkLoggedIn()
    {
        if ($this->isLoggedIn()) {
            header('Location: ../Views/dashboard.php');
            exit();
        }
    }

}

if (isset($_POST['action'])) {
    $controller = new AuthController();
    $controller->handleRequest();
}
