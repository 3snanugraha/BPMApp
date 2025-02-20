<?php
require_once __DIR__ . '/../Config/Database.php';

class PasienModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function addReading($data)
    {
        $query = "INSERT INTO blood_pressure_readings 
                  (patient_id, systolic, diastolic, pulse_rate, notes) 
                  VALUES (?, ?, ?, ?, ?)";

        $this->db->query($query, [
            $data['patient_id'],
            $data['systolic'],
            $data['diastolic'],
            $data['pulse_rate'],
            $data['notes']
        ]);

        $readingId = $this->db->lastInsertId();

        // Check if recommendation needed
        $recommendation = $this->getRecommendationForReading($data['systolic'], $data['diastolic']);
        if ($recommendation) {
            $this->addRecommendationForReading($readingId, $data['patient_id'], $recommendation['recommendation_id']);
        }

        return $readingId;
    }

    // Add these methods to the PasienModel class

    public function getRecommendationForReading($systolic, $diastolic)
    {
        $query = "SELECT * FROM health_recommendations 
              WHERE bp_range_systolic_min <= ? 
              AND bp_range_systolic_max >= ?
              AND bp_range_diastolic_min <= ?
              AND bp_range_diastolic_max >= ?
              LIMIT 1";

        return $this->db->query($query, [
            $systolic,
            $systolic,
            $diastolic,
            $diastolic
        ])->fetch();
    }

    public function addRecommendationForReading($readingId, $patientId, $recommendationId)
    {
        $query = "INSERT INTO patient_recommendations 
              (patient_id, recommendation_id, reading_id) 
              VALUES (?, ?, ?)";

        return $this->db->query($query, [
            $patientId,
            $recommendationId,
            $readingId
        ]);
    }


    public function getAllTodayReadings()
    {
        $query = "SELECT bpr.*, pp.full_name as patient_name 
                  FROM blood_pressure_readings bpr
                  JOIN patient_profiles pp ON bpr.patient_id = pp.patient_id 
                  WHERE DATE(bpr.reading_date) = CURDATE()
                  ORDER BY bpr.reading_date DESC";

        return $this->db->query($query)->fetchAll();
    }

    public function getTodayReadings($patientId)
    {
        $query = "SELECT * FROM blood_pressure_readings 
                  WHERE patient_id = ? 
                  AND DATE(reading_date) = CURDATE()
                  ORDER BY reading_date DESC";

        return $this->db->query($query, [$patientId])->fetchAll();
    }

    public function getLatestReading($patientId)
    {
        $query = "SELECT bpr.*, 
                         hr.title as recommendation_title,
                         hr.description as recommendation_description
                  FROM blood_pressure_readings bpr
                  LEFT JOIN patient_recommendations pr ON bpr.reading_id = pr.reading_id
                  LEFT JOIN health_recommendations hr ON pr.recommendation_id = hr.recommendation_id
                  WHERE bpr.patient_id = ?
                  ORDER BY bpr.reading_date DESC
                  LIMIT 1";

        return $this->db->query($query, [$patientId])->fetch();
    }

    public function getAllPatients()
    {
        $query = "SELECT p.*, u.email, u.username 
                  FROM patient_profiles p 
                  JOIN users u ON p.user_id = u.user_id 
                  WHERE u.role = 'patient'";
        return $this->db->query($query)->fetchAll();
    }

    public function getPatientById($patientId)
    {
        $query = "SELECT p.*, u.email, u.username 
                  FROM patient_profiles p 
                  JOIN users u ON p.user_id = u.user_id 
                  WHERE p.patient_id = ?";
        return $this->db->query($query, [$patientId])->fetch();
    }

    public function getRecentPatients($limit)
    {
        $query = "SELECT p.*, u.email, u.username 
                  FROM patient_profiles p 
                  JOIN users u ON p.user_id = u.user_id 
                  WHERE u.role = 'patient'
                  ORDER BY p.patient_id DESC 
                  LIMIT ?";

        return $this->db->query($query, [$limit])->fetchAll();
    }

    public function addPatient($userData, $profileData)
    {
        try {
            $this->db->query("START TRANSACTION");

            $query = "INSERT INTO users (username, password, email, role) 
                      VALUES (?, ?, ?, 'patient')";

            $this->db->query($query, [
                $userData['username'],
                password_hash($userData['password'], PASSWORD_DEFAULT),
                $userData['email']
            ]);

            $userId = $this->db->lastInsertId();

            $query = "INSERT INTO patient_profiles 
                      (user_id, full_name, date_of_birth, gender, address, 
                       phone_number, emergency_contact, emergency_phone, medical_history) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $this->db->query($query, [
                $userId,
                $profileData['full_name'],
                $profileData['date_of_birth'],
                $profileData['gender'],
                $profileData['address'],
                $profileData['phone_number'],
                $profileData['emergency_contact'],
                $profileData['emergency_phone'],
                $profileData['medical_history']
            ]);

            $this->db->query("COMMIT");
            return true;
        } catch (Exception $e) {
            $this->db->query("ROLLBACK");
            return false;
        }
    }

    public function addBloodPressureReading($data)
    {
        $query = "INSERT INTO blood_pressure_readings 
                  (patient_id, systolic, diastolic, pulse_rate, notes) 
                  VALUES (?, ?, ?, ?, ?)";

        return $this->db->query($query, [
            $data['patient_id'],
            $data['systolic'],
            $data['diastolic'],
            $data['pulse_rate'],
            $data['notes']
        ]);
    }

    public function updateProfile($userId, $data)
    {
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

        return $this->db->query($query, [
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
    }


    public function editPatient($patientId, $data)
    {
        try {
            $this->db->query("START TRANSACTION");

            $query = "UPDATE patient_profiles 
                      SET full_name = ?, 
                          date_of_birth = ?,
                          gender = ?,
                          address = ?,
                          phone_number = ?,
                          emergency_contact = ?,
                          emergency_phone = ?,
                          medical_history = ?
                      WHERE patient_id = ?";

            $this->db->query($query, [
                $data['full_name'],
                $data['date_of_birth'],
                $data['gender'],
                $data['address'],
                $data['phone_number'],
                $data['emergency_contact'],
                $data['emergency_phone'],
                $data['medical_history'],
                $patientId
            ]);

            $query = "SELECT user_id FROM patient_profiles WHERE patient_id = ?";
            $result = $this->db->query($query, [$patientId])->fetch();

            if ($result) {
                $query = "UPDATE users SET email = ? WHERE user_id = ?";
                $this->db->query($query, [$data['email'], $result['user_id']]);
            }

            $this->db->query("COMMIT");
            return true;
        } catch (Exception $e) {
            $this->db->query("ROLLBACK");
            return false;
        }
    }

    public function deletePatient($patientId)
    {
        try {
            $this->db->query("START TRANSACTION");

            $query = "SELECT user_id FROM patient_profiles WHERE patient_id = ?";
            $result = $this->db->query($query, [$patientId])->fetch();

            if ($result) {
                $this->db->query("DELETE FROM patient_profiles WHERE patient_id = ?", [$patientId]);
                $this->db->query("DELETE FROM users WHERE user_id = ?", [$result['user_id']]);
            }

            $this->db->query("COMMIT");
            return true;
        } catch (Exception $e) {
            $this->db->query("ROLLBACK");
            return false;
        }
    }

    public function getPatientBloodPressureReadings($patientId)
    {
        $query = "SELECT * FROM blood_pressure_readings 
                  WHERE patient_id = ? 
                  ORDER BY reading_date DESC";
        return $this->db->query($query, [$patientId])->fetchAll();
    }

    public function getPatientMedications($patientId)
    {
        $query = "SELECT pm.*, m.name as medication_name, m.description, 
                         d.full_name as doctor_name
                  FROM patient_medications pm
                  JOIN medications m ON pm.medication_id = m.medication_id
                  JOIN doctor_profiles d ON pm.prescribed_by = d.doctor_id
                  WHERE pm.patient_id = ?
                  ORDER BY pm.start_date DESC";
        return $this->db->query($query, [$patientId])->fetchAll();
    }

    public function getPatientRecommendations($patientId)
    {
        $query = "SELECT pr.*, hr.title, hr.description
                  FROM patient_recommendations pr
                  JOIN health_recommendations hr ON pr.recommendation_id = hr.recommendation_id
                  WHERE pr.patient_id = ?
                  ORDER BY pr.created_at DESC";
        return $this->db->query($query, [$patientId])->fetchAll();
    }

    public function getAssignedDoctors($patientId)
    {
        $query = "SELECT d.*, u.email
                  FROM doctor_profiles d
                  JOIN doctor_patients dp ON d.doctor_id = dp.doctor_id
                  JOIN users u ON d.user_id = u.user_id
                  WHERE dp.patient_id = ?";
        return $this->db->query($query, [$patientId])->fetchAll();
    }
}
