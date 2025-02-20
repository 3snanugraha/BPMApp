<?php
require_once __DIR__ . '/../Config/Database.php';

class PencatatanModel
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

    public function getTotalReadings()
    {
        $query = "SELECT COUNT(*) as total FROM blood_pressure_readings";
        $result = $this->db->query($query)->fetch();
        return $result['total'];
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

    public function getReadingTrend($patientId, $days = 7)
    {
        $query = "SELECT 
                    DATE(reading_date) as date,
                    AVG(systolic) as avg_systolic,
                    AVG(diastolic) as avg_diastolic,
                    AVG(pulse_rate) as avg_pulse_rate
                  FROM blood_pressure_readings
                  WHERE patient_id = ?
                  AND reading_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                  GROUP BY DATE(reading_date)
                  ORDER BY date ASC";

        return $this->db->query($query, [$patientId, $days])->fetchAll();
    }

    public function getAbnormalReadings($patientId, $days = 30)
    {
        $query = "SELECT bpr.*, hr.title as recommendation_title
                  FROM blood_pressure_readings bpr
                  LEFT JOIN patient_recommendations pr ON bpr.reading_id = pr.reading_id
                  LEFT JOIN health_recommendations hr ON pr.recommendation_id = hr.recommendation_id
                  WHERE bpr.patient_id = ?
                  AND bpr.reading_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                  AND (bpr.systolic >= 140 OR bpr.systolic <= 90 OR 
                       bpr.diastolic >= 90 OR bpr.diastolic <= 60)
                  ORDER BY bpr.reading_date DESC";

        return $this->db->query($query, [$patientId, $days])->fetchAll();
    }

    public function getDoctorPatients($doctorId)
    {
        $query = "SELECT pp.*, u.email
                  FROM patient_profiles pp
                  JOIN doctor_patients dp ON pp.patient_id = dp.patient_id
                  JOIN users u ON pp.user_id = u.user_id
                  WHERE dp.doctor_id = ?";

        return $this->db->query($query, [$doctorId])->fetchAll();
    }

    public function getPatientProfile($patientId)
    {
        $query = "SELECT pp.*, u.email, u.username
                  FROM patient_profiles pp
                  JOIN users u ON pp.user_id = u.user_id
                  WHERE pp.patient_id = ?";

        return $this->db->query($query, [$patientId])->fetch();
    }
}
