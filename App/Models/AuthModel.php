<?php
require_once __DIR__ . '/../Config/Database.php';
class AuthModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login($username, $password)
    {
        $query = "SELECT * FROM users WHERE username = ?";
        $result = $this->db->query($query, [$username])->fetch();

        if ($result && password_verify($password, $result['password'])) {
            return $result;
        }
        return false;
    }

    public function register($data)
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password, email, role) 
                  VALUES (?, ?, ?, ?)";

        $this->db->query($query, [
            $data['username'],
            $hashedPassword,
            $data['email'],
            $data['role']
        ]);

        return $this->db->lastInsertId(); // Return the user_id directly
    }


    public function createUserProfile($userId, $data)
    {
        if ($data['role'] === 'doctor') {
            $query = "INSERT INTO doctor_profiles 
                      (user_id, full_name, specialization, license_number, phone_number) 
                      VALUES (?, ?, ?, ?, ?)";

            return $this->db->query($query, [
                $userId,
                $data['full_name'],
                $data['specialization'],
                $data['license_number'],
                $data['phone_number']
            ]);
        } else if ($data['role'] === 'patient') {
            $query = "INSERT INTO patient_profiles 
                      (user_id, full_name, date_of_birth, gender, address, 
                       phone_number, emergency_contact, emergency_phone, medical_history) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            return $this->db->query($query, [
                $userId,
                $data['full_name'],
                $data['date_of_birth'],
                $data['gender'],
                $data['address'],
                $data['phone_number'],
                $data['emergency_contact'],
                $data['emergency_phone'],
                $data['medical_history']
            ]);
        }
    }

    public function getUserById($userId)
    {
        $query = "SELECT * FROM users WHERE user_id = ?";
        return $this->db->query($query, [$userId])->fetch();
    }

    public function getUserProfile($userId, $role)
    {
        if ($role === 'doctor') {
            $query = "SELECT * FROM doctor_profiles WHERE user_id = ?";
        } else if ($role === 'patient') {
            $query = "SELECT * FROM patient_profiles WHERE user_id = ?";
        }
        return $this->db->query($query, [$userId])->fetch();
    }

    public function updateUser($userId, $data)
    {
        $query = "UPDATE users SET 
                  username = ?, 
                  email = ?, 
                  updated_at = CURRENT_TIMESTAMP 
                  WHERE user_id = ?";

        return $this->db->query($query, [
            $data['username'],
            $data['email'],
            $userId
        ]);
    }

    public function updatePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE users SET 
                  password = ?, 
                  updated_at = CURRENT_TIMESTAMP 
                  WHERE user_id = ?";

        return $this->db->query($query, [$hashedPassword, $userId]);
    }

    public function updateProfile($userId, $role, $data)
    {
        if ($role === 'doctor') {
            $query = "UPDATE doctor_profiles SET 
                      full_name = ?, 
                      specialization = ?, 
                      phone_number = ? 
                      WHERE user_id = ?";

            return $this->db->query($query, [
                $data['full_name'],
                $data['specialization'],
                $data['phone_number'],
                $userId
            ]);
        } else if ($role === 'patient') {
            $query = "UPDATE patient_profiles SET 
                      full_name = ?, 
                      address = ?, 
                      phone_number = ?,
                      emergency_contact = ?,
                      emergency_phone = ?,
                      medical_history = ? 
                      WHERE user_id = ?";

            return $this->db->query($query, [
                $data['full_name'],
                $data['address'],
                $data['phone_number'],
                $data['emergency_contact'],
                $data['emergency_phone'],
                $data['medical_history'],
                $userId
            ]);
        }
    }

    public function deleteUser($userId)
    {
        $query = "DELETE FROM users WHERE user_id = ?";
        return $this->db->query($query, [$userId]);
    }

    public function checkUsernameExists($username)
    {
        $query = "SELECT COUNT(*) as count FROM users WHERE username = ?";
        $result = $this->db->query($query, [$username])->fetch();
        return $result['count'] > 0;
    }

    public function checkEmailExists($email)
    {
        $query = "SELECT COUNT(*) as count FROM users WHERE email = ?";
        $result = $this->db->query($query, [$email])->fetch();
        return $result['count'] > 0;
    }
}
