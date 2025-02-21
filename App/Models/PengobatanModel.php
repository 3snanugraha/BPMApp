<?php
require_once __DIR__ . '/../Config/Database.php';

class PengobatanModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllPrescriptions()
    {
        $query = "SELECT pm.*, 
                         m.name as medication_name, 
                         m.dosage_form,
                         pp.full_name as patient_name,
                         dp.full_name as doctor_name
                  FROM patient_medications pm
                  JOIN medications m ON pm.medication_id = m.medication_id
                  JOIN patient_profiles pp ON pm.patient_id = pp.patient_id
                  JOIN doctor_profiles dp ON pm.prescribed_by = dp.doctor_id
                  ORDER BY pm.start_date DESC";
        return $this->db->query($query)->fetchAll();
    }

    public function getPrescriptionById($prescriptionId)
    {
        $query = "SELECT pm.*, 
                         m.name as medication_name,
                         m.dosage_form,
                         pp.full_name as patient_name,
                         dp.full_name as doctor_name
                  FROM patient_medications pm
                  JOIN medications m ON pm.medication_id = m.medication_id
                  JOIN patient_profiles pp ON pm.patient_id = pp.patient_id
                  JOIN doctor_profiles dp ON pm.prescribed_by = dp.doctor_id
                  WHERE pm.patient_medication_id = ?";
        return $this->db->query($query, [$prescriptionId])->fetch();
    }

    public function getPatientPrescriptions($userId)
    {
        $query = "SELECT pm.*, 
                         m.name as medication_name, 
                         m.dosage_form,
                         pp.full_name as patient_name,
                         dp.full_name as doctor_name
                  FROM patient_medications pm
                  JOIN medications m ON pm.medication_id = m.medication_id
                  JOIN patient_profiles pp ON pm.patient_id = pp.patient_id
                  JOIN doctor_profiles dp ON pm.prescribed_by = dp.doctor_id
                  WHERE pp.user_id = ?
                  ORDER BY pm.start_date DESC";
        return $this->db->query($query, [$userId])->fetchAll();
    }

    public function getDashboardMedications($patientId)
    {
        $query = "SELECT pm.dosage,
                     pm.frequency,
                     pm.start_date,
                     pm.end_date,
                     m.name as medication_name,
                     m.dosage_form,
                     dp.full_name as doctor_name
              FROM patient_medications pm
              JOIN medications m ON pm.medication_id = m.medication_id
              JOIN doctor_profiles dp ON pm.prescribed_by = dp.doctor_id
              WHERE pm.patient_id = ?
              AND pm.end_date >= CURRENT_DATE
              AND pm.start_date <= CURRENT_DATE
              ORDER BY pm.start_date DESC";
        return $this->db->query($query, [$patientId])->fetchAll();
    }


    public function getDoctorPrescriptions($doctorId)
    {
        $query = "SELECT pm.*, 
                         m.name as medication_name,
                         m.dosage_form,
                         pp.full_name as patient_name
                  FROM patient_medications pm
                  JOIN medications m ON pm.medication_id = m.medication_id
                  JOIN patient_profiles pp ON pm.patient_id = pp.patient_id
                  WHERE pm.prescribed_by = ?
                  ORDER BY pm.start_date DESC";
        return $this->db->query($query, [$doctorId])->fetchAll();
    }

    public function addPrescription($data)
    {
        $query = "INSERT INTO patient_medications 
                  (patient_id, medication_id, dosage, frequency, 
                   start_date, end_date, prescribed_by, notes)
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
                      start_date = ?,
                      end_date = ?,
                      notes = ?
                  WHERE patient_medication_id = ?";

        return $this->db->query($query, [
            $data['dosage'],
            $data['frequency'],
            $data['start_date'],
            $data['end_date'],
            $data['notes'],
            $prescriptionId
        ]);
    }

    public function deletePrescription($prescriptionId)
    {
        $query = "DELETE FROM patient_medications WHERE patient_medication_id = ?";
        return $this->db->query($query, [$prescriptionId]);
    }

    public function getActivePrescriptions()
    {
        $query = "SELECT pm.*, 
                         m.name as medication_name,
                         m.dosage_form,
                         pp.full_name as patient_name,
                         dp.full_name as doctor_name
                  FROM patient_medications pm
                  JOIN medications m ON pm.medication_id = m.medication_id
                  JOIN patient_profiles pp ON pm.patient_id = pp.patient_id
                  JOIN doctor_profiles dp ON pm.prescribed_by = dp.doctor_id
                  WHERE pm.end_date >= CURRENT_DATE
                  ORDER BY pm.start_date DESC";
        return $this->db->query($query)->fetchAll();
    }

    public function getExpiredPrescriptions()
    {
        $query = "SELECT pm.*, 
                         m.name as medication_name,
                         m.dosage_form,
                         pp.full_name as patient_name,
                         dp.full_name as doctor_name
                  FROM patient_medications pm
                  JOIN medications m ON pm.medication_id = m.medication_id
                  JOIN patient_profiles pp ON pm.patient_id = pp.patient_id
                  JOIN doctor_profiles dp ON pm.prescribed_by = dp.doctor_id
                  WHERE pm.end_date < CURRENT_DATE
                  ORDER BY pm.end_date DESC";
        return $this->db->query($query)->fetchAll();
    }
}
