<?php
require_once __DIR__ . '/../Config/Database.php';

class RekomendasiModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // RekomendasiModel.php - getAllRecommendations method
    public function getAllRecommendations()
    {
        $query = "SELECT hr.recommendation_id, hr.title, hr.description, 
              hr.bp_range_systolic_min, hr.bp_range_systolic_max,
              hr.bp_range_diastolic_min, hr.bp_range_diastolic_max,
              hr.created_at, u.username as created_by_name 
              FROM health_recommendations hr
              LEFT JOIN users u ON hr.created_by = u.user_id
              ORDER BY hr.created_at DESC";
        return $this->db->query($query)->fetchAll();
    }

    public function getRecommendationById($recommendationId)
    {
        $query = "SELECT hr.*, u.username as created_by_name 
                  FROM health_recommendations hr
                  LEFT JOIN users u ON hr.created_by = u.user_id
                  WHERE hr.recommendation_id = ?";
        return $this->db->query($query, [$recommendationId])->fetch();
    }

    public function addRecommendation($data)
    {
        $query = "INSERT INTO health_recommendations (
            title, 
            description, 
            bp_range_systolic_min,
            bp_range_systolic_max,
            bp_range_diastolic_min,
            bp_range_diastolic_max,
            created_by
        ) VALUES (?, ?, ?, ?, ?, ?, ?)";

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

    public function updateRecommendation($recommendationId, $data)
    {
        $query = "UPDATE health_recommendations 
                  SET title = ?,
                      description = ?,
                      bp_range_systolic_min = ?,
                      bp_range_systolic_max = ?,
                      bp_range_diastolic_min = ?,
                      bp_range_diastolic_max = ?
                  WHERE recommendation_id = ?";

        return $this->db->query($query, [
            $data['title'],
            $data['description'],
            $data['bp_range_systolic_min'],
            $data['bp_range_systolic_max'],
            $data['bp_range_diastolic_min'],
            $data['bp_range_diastolic_max'],
            $recommendationId
        ]);
    }

    public function deleteRecommendation($recommendationId)
    {
        $query = "DELETE FROM health_recommendations WHERE recommendation_id = ?";
        return $this->db->query($query, [$recommendationId]);
    }

    public function getPatientRecommendations($patientId)
    {
        $query = "SELECT pr.*, hr.title, hr.description, 
                         bpr.systolic, bpr.diastolic, bpr.reading_date
                  FROM patient_recommendations pr
                  JOIN health_recommendations hr ON pr.recommendation_id = hr.recommendation_id
                  JOIN blood_pressure_readings bpr ON pr.reading_id = bpr.reading_id
                  WHERE pr.patient_id = ?
                  ORDER BY pr.created_at DESC";
        return $this->db->query($query, [$patientId])->fetchAll();
    }

    public function addPatientRecommendation($data)
    {
        $query = "INSERT INTO patient_recommendations (
            patient_id,
            recommendation_id,
            reading_id
        ) VALUES (?, ?, ?)";

        return $this->db->query($query, [
            $data['patient_id'],
            $data['recommendation_id'],
            $data['reading_id']
        ]);
    }

    public function getRecommendationByBPReadings($systolic, $diastolic)
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

    public function getRecommendationStats()
    {
        $query = "SELECT hr.title, COUNT(pr.patient_recommendation_id) as usage_count
                  FROM health_recommendations hr
                  LEFT JOIN patient_recommendations pr ON hr.recommendation_id = pr.recommendation_id
                  GROUP BY hr.recommendation_id
                  ORDER BY usage_count DESC";
        return $this->db->query($query)->fetchAll();
    }
}
