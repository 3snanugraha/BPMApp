<?php
require_once __DIR__ . '/../Config/Database.php';

class DokterModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getDoctorProfile($userId)
    {
        $query = "SELECT d.*, u.email, u.username 
                  FROM doctor_profiles d 
                  JOIN users u ON d.user_id = u.user_id 
                  WHERE d.user_id = ?";
        return $this->db->query($query, [$userId])->fetch();
    }

    public function addDoctor($userData, $profileData)
    {
        // Insert user first
        $query = "INSERT INTO users (username, password, email, role) 
                  VALUES (?, ?, ?, 'doctor')";

        $this->db->query($query, [
            $userData['username'],
            password_hash($userData['password'], PASSWORD_DEFAULT),
            $userData['email']
        ]);

        $userId = $this->db->lastInsertId();

        // Then insert doctor profile
        $query = "INSERT INTO doctor_profiles 
                  (user_id, full_name, specialization, license_number, phone_number) 
                  VALUES (?, ?, ?, ?, ?)";

        return $this->db->query($query, [
            $userId,
            $profileData['full_name'],
            $profileData['specialization'],
            $profileData['license_number'],
            $profileData['phone_number']
        ]);
    }

    public function deleteDoctor($doctorId)
    {
        // Delete from doctor_profiles
        $query = "DELETE FROM doctor_profiles WHERE doctor_id = ?";
        $this->db->query($query, [$doctorId]);

        // Get user_id from doctor profile
        $query = "SELECT user_id FROM doctor_profiles WHERE doctor_id = ?";
        $result = $this->db->query($query, [$doctorId])->fetch();

        if ($result) {
            // Delete from users table
            $query = "DELETE FROM users WHERE user_id = ?";
            return $this->db->query($query, [$result['user_id']]);
        }
        return false;
    }


    public function getAllDoctors()
    {
        $query = "SELECT d.*, u.email, u.username 
                  FROM doctor_profiles d 
                  JOIN users u ON d.user_id = u.user_id 
                  WHERE u.role = 'doctor'";
        return $this->db->query($query)->fetchAll();
    }

    public function getDoctorPatients($doctorId)
    {
        $query = "SELECT p.*, u.email, u.username 
                  FROM patient_profiles p 
                  JOIN doctor_patients dp ON p.patient_id = dp.patient_id 
                  JOIN users u ON p.user_id = u.user_id 
                  WHERE dp.doctor_id = ?";
        return $this->db->query($query, [$doctorId])->fetchAll();
    }

    public function assignPatient($doctorId, $patientId)
    {
        $query = "INSERT INTO doctor_patients (doctor_id, patient_id) VALUES (?, ?)";
        return $this->db->query($query, [$doctorId, $patientId]);
    }

    public function removePatient($doctorId, $patientId)
    {
        $query = "DELETE FROM doctor_patients WHERE doctor_id = ? AND patient_id = ?";
        return $this->db->query($query, [$doctorId, $patientId]);
    }

    public function updateDoctorProfile($userId, $data)
    {
        $query = "UPDATE doctor_profiles 
                  SET full_name = ?, 
                      specialization = ?, 
                      phone_number = ? 
                  WHERE user_id = ?";

        return $this->db->query($query, [
            $data['full_name'],
            $data['specialization'],
            $data['phone_number'],
            $userId
        ]);
    }

    public function editDoctor($doctorId, $data)
    {
        try {
            $this->db->query("START TRANSACTION");

            // Update doctor_profiles
            $query = "UPDATE doctor_profiles 
                 SET full_name = ?, 
                     specialization = ?, 
                     license_number = ?,
                     phone_number = ? 
                 WHERE doctor_id = ?";

            $this->db->query($query, [
                $data['full_name'],
                $data['specialization'],
                $data['license_number'],
                $data['phone_number'],
                $doctorId
            ]);

            // Get user_id from doctor_profiles
            $query = "SELECT user_id FROM doctor_profiles WHERE doctor_id = ?";
            $result = $this->db->query($query, [$doctorId])->fetch();

            // Update users table
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


    public function getPatientMedicalHistory($patientId)
    {
        $query = "SELECT bp.*, pr.recommendation_id, hr.title as recommendation_title, 
                         hr.description as recommendation_description
                  FROM blood_pressure_readings bp 
                  LEFT JOIN patient_recommendations pr ON bp.reading_id = pr.reading_id
                  LEFT JOIN health_recommendations hr ON pr.recommendation_id = hr.recommendation_id
                  WHERE bp.patient_id = ?
                  ORDER BY bp.reading_date DESC";
        return $this->db->query($query, [$patientId])->fetchAll();
    }

    public function getPrescribedMedications($patientId)
    {
        $query = "SELECT pm.*, m.name as medication_name, m.description, m.dosage_form,
                         d.full_name as prescribed_by_name
                  FROM patient_medications pm
                  JOIN medications m ON pm.medication_id = m.medication_id
                  JOIN doctor_profiles d ON pm.prescribed_by = d.doctor_id
                  WHERE pm.patient_id = ?
                  ORDER BY pm.start_date DESC";
        return $this->db->query($query, [$patientId])->fetchAll();
    }

    public function prescribeMedication($data)
    {
        $query = "INSERT INTO patient_medications 
                  (patient_id, medication_id, dosage, frequency, start_date, end_date, prescribed_by, notes) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        return $this->db->query($query, [
            $data['patient_id'],
            $data['medication_id'],
            $data['dosage'],
            $data['frequency'],
            $data['start_date'],
            $data['end_date'],
            $data['prescribed_by'],
            $data['notes']
        ]);
    }

    public function updatePrescription($prescriptionId, $data)
    {
        $query = "UPDATE patient_medications 
                  SET dosage = ?, 
                      frequency = ?, 
                      end_date = ?, 
                      notes = ? 
                  WHERE patient_medication_id = ?";

        return $this->db->query($query, [
            $data['dosage'],
            $data['frequency'],
            $data['end_date'],
            $data['notes'],
            $prescriptionId
        ]);
    }

    public function addHealthRecommendation($data)
    {
        $query = "INSERT INTO health_recommendations 
                  (title, description, bp_range_systolic_min, bp_range_systolic_max, 
                   bp_range_diastolic_min, bp_range_diastolic_max, created_by) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        return $this->db->query($query, [
            $data['title'],
            $data['description'],
            $data['bp_range_systolic_min'],
            $data['bp_range_systolic_max'],
            $data['bp_range_diastolic_min'],
            $data['bp_range_diastolic_max'],
            $data['created_by']
        ]);
    }

    public function getDoctorSchedule($doctorId)
    {
        // Additional method for future schedule implementation
        return [];
    }
}
