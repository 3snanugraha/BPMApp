<?php
require_once __DIR__ . '/../Config/Database.php';

class PencatatanModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllReadings()
    {
        $query = "SELECT bpr.*, 
                         pp.full_name as patient_name,
                         CONCAT(bpr.systolic, '/', bpr.diastolic) as blood_pressure
                  FROM blood_pressure_readings bpr
                  JOIN patient_profiles pp ON bpr.patient_id = pp.patient_id
                  ORDER BY bpr.reading_date DESC";
        return $this->db->query($query)->fetchAll();
    }

    public function getPatientReadings($patientId)
    {
        $query = "SELECT bpr.*, 
                         CONCAT(bpr.systolic, '/', bpr.diastolic) as blood_pressure
                  FROM blood_pressure_readings bpr
                  WHERE bpr.patient_id = ?
                  ORDER BY bpr.reading_date DESC";
        return $this->db->query($query, [$patientId])->fetchAll();
    }

    public function getReadingById($readingId)
    {
        $query = "SELECT bpr.*, pp.full_name as patient_name
                  FROM blood_pressure_readings bpr
                  JOIN patient_profiles pp ON bpr.patient_id = pp.patient_id
                  WHERE bpr.reading_id = ?";
        return $this->db->query($query, [$readingId])->fetch();
    }

    public function addReading($data)
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

    public function updateReading($readingId, $data)
    {
        $query = "UPDATE blood_pressure_readings 
                  SET systolic = ?,
                      diastolic = ?,
                      pulse_rate = ?,
                      notes = ?
                  WHERE reading_id = ?";

        return $this->db->query($query, [
            $data['systolic'],
            $data['diastolic'],
            $data['pulse_rate'],
            $data['notes'],
            $readingId
        ]);
    }

    public function deleteReading($readingId)
    {
        $query = "DELETE FROM blood_pressure_readings WHERE reading_id = ?";
        return $this->db->query($query, [$readingId]);
    }

    public function getPatientsList()
    {
        $query = "SELECT patient_id, full_name FROM patient_profiles ORDER BY full_name ASC";
        return $this->db->query($query)->fetchAll();
    }

    public function getReadingStats($patientId = null)
    {
        $whereClause = $patientId ? "WHERE patient_id = ?" : "";
        $params = $patientId ? [$patientId] : [];

        $query = "SELECT 
                    COUNT(*) as total_readings,
                    AVG(systolic) as avg_systolic,
                    AVG(diastolic) as avg_diastolic,
                    MAX(systolic) as max_systolic,
                    MIN(systolic) as min_systolic,
                    MAX(diastolic) as max_diastolic,
                    MIN(diastolic) as min_diastolic
                  FROM blood_pressure_readings
                  $whereClause";

        return $this->db->query($query, $params)->fetch();
    }

    public function getPatientIdByUserId($userId)
    {
        $query = "SELECT patient_id FROM patient_profiles WHERE user_id = ?";
        $result = $this->db->query($query, [$userId])->fetch();
        return $result ? $result['patient_id'] : null;
    }
}
