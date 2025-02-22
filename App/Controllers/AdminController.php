<?php
require_once __DIR__ . '/../Models/AdminModel.php';

class AdminController
{
    private $adminModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->adminModel = new AdminModel();
    }

    public function getTotalUsers()
    {
        return $this->adminModel->getTotalUsers();
    }

    public function getTotalDoctors()
    {
        return $this->adminModel->getTotalDoctors();
    }

    public function getTotalPatients()
    {
        return $this->adminModel->getTotalPatients();
    }

    public function getTotalReadings()
    {
        return $this->adminModel->getTotalReadings();
    }

    public function getTotalMedications()
    {
        return $this->adminModel->getTotalMedications();
    }

    public function getRecentActivities()
    {
        return $this->adminModel->getRecentActivities();
    }
}
