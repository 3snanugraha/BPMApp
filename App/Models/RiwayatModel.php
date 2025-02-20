<?php
require_once __DIR__ . '/../Config/Database.php';

class RiwayatModel
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
                         CONCAT(bpr.systolic, '/', bpr.diastolic) as blood_pressure,
                         hr.title as recommendation_title,
                         hr.description as recommendation_description
                  FROM blood_pressure_readings bpr
                  LEFT JOIN patient_profiles pp ON bpr.patient_id = pp.patient_id
                  LEFT JOIN patient_recommendations pr ON bpr.reading_id = pr.reading_id
                  LEFT JOIN health_recommendations hr ON pr.recommendation_id = hr.recommendation_id
                  ORDER BY bpr.reading_date DESC";
        return $this->db->query($query)->fetchAll();
    }

    public function getPatientReadings($patientId)
    {
        $query = "SELECT bpr.*, 
                         CONCAT(bpr.systolic, '/', bpr.diastolic) as blood_pressure,
                         hr.title as recommendation_title,
                         hr.description as recommendation_description
                  FROM blood_pressure_readings bpr
                  LEFT JOIN patient_recommendations pr ON bpr.reading_id = pr.reading_id
                  LEFT JOIN health_recommendations hr ON pr.recommendation_id = hr.recommendation_id
                  WHERE bpr.patient_id = ?
                  ORDER BY bpr.reading_date DESC";
        return $this->db->query($query, [$patientId])->fetchAll();
    }

    public function getDoctorPatientReadings($doctorId)
    {
        $query = "SELECT bpr.*, 
                         pp.full_name as patient_name,
                         CONCAT(bpr.systolic, '/', bpr.diastolic) as blood_pressure,
                         hr.title as recommendation_title,
                         hr.description as recommendation_description
                  FROM blood_pressure_readings bpr
                  JOIN doctor_patients dp ON bpr.patient_id = dp.patient_id
                  LEFT JOIN patient_profiles pp ON bpr.patient_id = pp.patient_id
                  LEFT JOIN patient_recommendations pr ON bpr.reading_id = pr.reading_id
                  LEFT JOIN health_recommendations hr ON pr.recommendation_id = hr.recommendation_id
                  WHERE dp.doctor_id = ?
                  ORDER BY bpr.reading_date DESC";
        return $this->db->query($query, [$doctorId])->fetchAll();
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

    public function getReadingById($readingId)
    {
        $query = "SELECT bpr.*, 
                         pp.full_name as patient_name,
                         hr.title as recommendation_title,
                         hr.description as recommendation_description
                  FROM blood_pressure_readings bpr
                  LEFT JOIN patient_profiles pp ON bpr.patient_id = pp.patient_id
                  LEFT JOIN patient_recommendations pr ON bpr.reading_id = pr.reading_id
                  LEFT JOIN health_recommendations hr ON pr.recommendation_id = hr.recommendation_id
                  WHERE bpr.reading_id = ?";
        return $this->db->query($query, [$readingId])->fetch();
    }

    public function getReadingStats($patientId = null)
    {
        $params = [];
        $whereClause = "";

        if ($patientId) {
            $whereClause = "WHERE patient_id = ?";
            $params[] = $patientId;
        }

        $query = "SELECT 
                    AVG(systolic) as avg_systolic,
                    AVG(diastolic) as avg_diastolic,
                    MAX(systolic) as max_systolic,
                    MAX(diastolic) as max_diastolic,
                    MIN(systolic) as min_systolic,
                    MIN(diastolic) as min_diastolic,
                    COUNT(*) as total_readings
                  FROM blood_pressure_readings
                  $whereClause";

        return $this->db->query($query, $params)->fetch();
    }

    public function getMonthlyAverages($patientId = null)
    {
        $params = [];
        $whereClause = "";

        if ($patientId) {
            $whereClause = "WHERE patient_id = ?";
            $params[] = $patientId;
        }

        $query = "SELECT 
                    DATE_FORMAT(reading_date, '%Y-%m') as month,
                    AVG(systolic) as avg_systolic,
                    AVG(diastolic) as avg_diastolic
                  FROM blood_pressure_readings
                  $whereClause
                  GROUP BY DATE_FORMAT(reading_date, '%Y-%m')
                  ORDER BY month DESC
                  LIMIT 12";

        return $this->db->query($query, $params)->fetchAll();
    }
}
