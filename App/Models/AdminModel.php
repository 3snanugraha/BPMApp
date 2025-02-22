<?php
require_once __DIR__ . '/../Config/Database.php';

class AdminModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getTotalUsers()
    {
        $query = "SELECT COUNT(*) as total FROM users";
        $result = $this->db->query($query)->fetch();
        return $result['total'];
    }

    public function getTotalDoctors()
    {
        $query = "SELECT COUNT(*) as total FROM users WHERE role = 'doctor'";
        $result = $this->db->query($query)->fetch();
        return $result['total'];
    }

    public function getTotalPatients()
    {
        $query = "SELECT COUNT(*) as total FROM users WHERE role = 'patient'";
        $result = $this->db->query($query)->fetch();
        return $result['total'];
    }

    public function getTotalReadings()
    {
        $query = "SELECT COUNT(*) as total FROM blood_pressure_readings";
        $result = $this->db->query($query)->fetch();
        return $result['total'];
    }

    public function getTotalMedications()
    {
        $query = "SELECT COUNT(*) as total FROM patient_medications";
        $result = $this->db->query($query)->fetch();
        return $result['total'];
    }

    public function getRecentActivities()
    {
        $query = "SELECT 
                    CASE 
                        WHEN u.role = 'doctor' THEN dp.full_name
                        WHEN u.role = 'patient' THEN pp.full_name
                        ELSE u.username
                    END as user_name,
                    u.role as type,
                    CASE 
                        WHEN u.role = 'doctor' THEN 'Menambahkan pengobatan baru'
                        WHEN u.role = 'patient' THEN 'Mencatat tekanan darah'
                        ELSE 'Mengelola sistem'
                    END as description,
                    CASE 
                        WHEN u.role = 'doctor' THEN 'Aktif'
                        WHEN u.role = 'patient' THEN 'Terdaftar'
                        ELSE 'Admin'
                    END as status,
                    CASE 
                        WHEN u.role = 'doctor' THEN 'success'
                        WHEN u.role = 'patient' THEN 'info'
                        ELSE 'primary'
                    END as status_color,
                    u.created_at
                FROM users u
                LEFT JOIN doctor_profiles dp ON u.user_id = dp.user_id
                LEFT JOIN patient_profiles pp ON u.user_id = pp.user_id
                ORDER BY u.created_at DESC
                LIMIT 10";
        return $this->db->query($query)->fetchAll();
    }

}
