<?php
require_once __DIR__ . '/../Config/Database.php';

class ProfileModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAdminProfile($userId)
    {
        $query = "SELECT u.* 
                  FROM users u 
                  WHERE u.user_id = ? AND u.role = 'admin'";
        return $this->db->query($query, [$userId])->fetch();
    }

    public function getDoctorProfile($userId)
    {
        $query = "SELECT d.*, u.email, u.username 
                  FROM doctor_profiles d 
                  JOIN users u ON d.user_id = u.user_id 
                  WHERE d.user_id = ? AND u.role = 'doctor'";
        return $this->db->query($query, [$userId])->fetch();
    }

    public function getPatientProfile($userId)
    {
        $query = "SELECT p.*, u.email, u.username 
                  FROM patient_profiles p 
                  JOIN users u ON p.user_id = u.user_id 
                  WHERE p.user_id = ? AND u.role = 'patient'";
        return $this->db->query($query, [$userId])->fetch();
    }

    public function updateAdminProfile($userId, $data)
    {
        $query = "UPDATE users 
                  SET email = ?, 
                      username = ?,
                      updated_at = CURRENT_TIMESTAMP 
                  WHERE user_id = ? AND role = 'admin'";
        return $this->db->query($query, [
            $data['email'],
            $data['username'],
            $userId
        ]);
    }

    public function updateDoctorProfile($userId, $data)
    {
        try {
            $this->db->query("START TRANSACTION");

            // Update users table
            $query = "UPDATE users 
                     SET email = ?, 
                         updated_at = CURRENT_TIMESTAMP 
                     WHERE user_id = ? AND role = 'doctor'";
            $this->db->query($query, [$data['email'], $userId]);

            // Update doctor_profiles table
            $query = "UPDATE doctor_profiles 
                     SET full_name = ?,
                         specialization = ?,
                         phone_number = ? 
                     WHERE user_id = ?";
            $this->db->query($query, [
                $data['full_name'],
                $data['specialization'],
                $data['phone_number'],
                $userId
            ]);

            $this->db->query("COMMIT");
            return true;
        } catch (Exception $e) {
            $this->db->query("ROLLBACK");
            return false;
        }
    }

    public function updatePatientProfile($userId, $data)
    {
        try {
            $this->db->query("START TRANSACTION");

            // Update users table
            $query = "UPDATE users 
                     SET email = ?, 
                         updated_at = CURRENT_TIMESTAMP 
                     WHERE user_id = ? AND role = 'patient'";
            $this->db->query($query, [$data['email'], $userId]);

            // Update patient_profiles table
            $query = "UPDATE patient_profiles 
                     SET full_name = ?,
                         date_of_birth = ?,
                         gender = ?,
                         address = ?,
                         phone_number = ?,
                         emergency_contact = ?,
                         emergency_phone = ?,
                         medical_history = ? 
                     WHERE user_id = ?";
            $this->db->query($query, [
                $data['full_name'],
                $data['date_of_birth'],
                $data['gender'],
                $data['address'],
                $data['phone_number'],
                $data['emergency_contact'],
                $data['emergency_phone'],
                $data['medical_history'],
                $userId
            ]);

            $this->db->query("COMMIT");
            return true;
        } catch (Exception $e) {
            $this->db->query("ROLLBACK");
            return false;
        }
    }

    public function updatePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE users 
                  SET password = ?, 
                      updated_at = CURRENT_TIMESTAMP 
                  WHERE user_id = ?";
        return $this->db->query($query, [$hashedPassword, $userId]);
    }

    public function getProfileStats($userId, $role)
    {
        $stats = [];

        if ($role === 'doctor') {
            // Get total patients for doctor
            $query = "SELECT COUNT(*) as total_patients 
                     FROM doctor_patients 
                     WHERE doctor_id = (SELECT doctor_id FROM doctor_profiles WHERE user_id = ?)";
            $result = $this->db->query($query, [$userId])->fetch();
            $stats['total_patients'] = $result['total_patients'];

            // Get total recommendations given
            $query = "SELECT COUNT(*) as total_recommendations 
                     FROM patient_recommendations 
                     WHERE created_by = ?";
            $result = $this->db->query($query, [$userId])->fetch();
            $stats['total_recommendations'] = $result['total_recommendations'];
        } elseif ($role === 'patient') {
            // Get total blood pressure readings
            $query = "SELECT COUNT(*) as total_readings 
                     FROM blood_pressure_readings bpr 
                     JOIN patient_profiles pp ON bpr.patient_id = pp.patient_id 
                     WHERE pp.user_id = ?";
            $result = $this->db->query($query, [$userId])->fetch();
            $stats['total_readings'] = $result['total_readings'];

            // Get latest blood pressure reading
            $query = "SELECT systolic, diastolic, reading_date 
                     FROM blood_pressure_readings bpr 
                     JOIN patient_profiles pp ON bpr.patient_id = pp.patient_id 
                     WHERE pp.user_id = ? 
                     ORDER BY reading_date DESC LIMIT 1";
            $stats['latest_reading'] = $this->db->query($query, [$userId])->fetch();
        }

        return $stats;
    }

    public function checkCurrentPassword($userId, $currentPassword)
    {
        $query = "SELECT password FROM users WHERE user_id = ?";
        $result = $this->db->query($query, [$userId])->fetch();
        return password_verify($currentPassword, $result['password']);
    }
}
