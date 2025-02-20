<?php
require_once __DIR__ . '/../Config/Database.php';
class RekomendasiModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // For Admin/Doctor: Get all recommendations with patient info
    public function getAllRecommendations()
    {
        $query = "SELECT pr.patient_recommendation_id, pr.title, pr.description, 
                  pr.created_at, u.username as created_by_name,
                  pp.full_name as patient_name,
                  bpr.systolic, bpr.diastolic, bpr.reading_date
                  FROM patient_recommendations pr
                  JOIN users u ON pr.created_by = u.user_id
                  JOIN patient_profiles pp ON pr.patient_id = pp.patient_id
                  JOIN blood_pressure_readings bpr ON pr.reading_id = bpr.reading_id
                  ORDER BY pr.created_at DESC";
        return $this->db->query($query)->fetchAll();
    }

    // For Admin/Doctor: Add recommendation for specific reading
    public function addRecommendation($data)
    {
        $query = "INSERT INTO patient_recommendations (
            patient_id,
            reading_id,
            title,
            description,
            created_by
        ) VALUES (?, ?, ?, ?, ?)";

        return $this->db->query($query, [
            $data['patient_id'],
            $data['reading_id'],
            $data['title'],
            $data['description'],
            $data['created_by']
        ]);
    }

    // For Patient: Get their recommendations with reading context
    public function getPatientRecommendations($userId)
    {
        $query = "SELECT pr.*, u.username as created_by_name,
                  pp.full_name as patient_name,
                  bpr.systolic, bpr.diastolic, bpr.reading_date
                  FROM patient_recommendations pr
                  JOIN users u ON pr.created_by = u.user_id
                  JOIN patient_profiles pp ON pr.patient_id = pp.patient_id
                  JOIN blood_pressure_readings bpr ON pr.reading_id = bpr.reading_id
                  WHERE pp.user_id = ?
                  ORDER BY pr.created_at DESC";
        return $this->db->query($query, [$userId])->fetchAll();
    }

    // For Admin/Doctor: Get recommendation details
    public function getRecommendationById($recommendationId)
    {
        $query = "SELECT pr.*, u.username as created_by_name,
                  pp.full_name as patient_name,
                  bpr.systolic, bpr.diastolic, bpr.reading_date
                  FROM patient_recommendations pr
                  JOIN users u ON pr.created_by = u.user_id
                  JOIN patient_profiles pp ON pr.patient_id = pp.patient_id
                  JOIN blood_pressure_readings bpr ON pr.reading_id = bpr.reading_id
                  WHERE pr.patient_recommendation_id = ?";
        return $this->db->query($query, [$recommendationId])->fetch();
    }

    // For Admin/Doctor: Update recommendation
    public function updateRecommendation($recommendationId, $data)
    {
        $query = "UPDATE patient_recommendations 
                  SET title = ?,
                      description = ?
                  WHERE patient_recommendation_id = ?";
        return $this->db->query($query, [
            $data['title'],
            $data['description'],
            $recommendationId
        ]);
    }

    // For Admin/Doctor: Delete recommendation
    public function deleteRecommendation($recommendationId)
    {
        $query = "DELETE FROM patient_recommendations WHERE patient_recommendation_id = ?";
        return $this->db->query($query, [$recommendationId]);
    }

    // For Admin/Doctor: Get recommendation statistics
    public function getRecommendationStats()
    {
        $query = "SELECT u.username as doctor_name,
                  COUNT(pr.patient_recommendation_id) as total_recommendations,
                  COUNT(DISTINCT pr.patient_id) as total_patients
                  FROM patient_recommendations pr
                  JOIN users u ON pr.created_by = u.user_id
                  GROUP BY pr.created_by
                  ORDER BY total_recommendations DESC";
        return $this->db->query($query)->fetchAll();
    }
}


