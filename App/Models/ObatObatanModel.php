<?php
require_once __DIR__ . '/../Config/Database.php';

class ObatObatanModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllMedications()
    {
        $query = "SELECT m.*, u.username as created_by_name 
                  FROM medications m
                  LEFT JOIN users u ON m.created_by = u.user_id
                  ORDER BY m.name ASC";
        return $this->db->query($query)->fetchAll();
    }

    public function getMedicationById($medicationId)
    {
        $query = "SELECT m.*, u.username as created_by_name 
                  FROM medications m
                  LEFT JOIN users u ON m.created_by = u.user_id
                  WHERE m.medication_id = ?";
        return $this->db->query($query, [$medicationId])->fetch();
    }

    public function addMedication($data)
    {
        $query = "INSERT INTO medications (
            name, 
            description, 
            dosage_form, 
            created_by
        ) VALUES (?, ?, ?, ?)";

        return $this->db->query($query, [
            $data['name'],
            $data['description'],
            $data['dosage_form'], // Example: "Tablet 5mg"
            $data['created_by']
        ]);
    }

    public function updateMedication($medicationId, $data)
    {
        $query = "UPDATE medications 
                  SET name = ?, 
                      description = ?, 
                      dosage_form = ? 
                  WHERE medication_id = ?";
        return $this->db->query($query, [
            $data['name'],
            $data['description'],
            $data['dosage_form'],
            $medicationId
        ]);
    }

    public function deleteMedication($medicationId)
    {
        $query = "DELETE FROM medications WHERE medication_id = ?";
        return $this->db->query($query, [$medicationId]);
    }

    public function getPatientMedications($patientId)
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
                  (patient_id, medication_id, dosage, frequency, start_date, 
                   end_date, prescribed_by, notes) 
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

    public function deletePrescription($prescriptionId)
    {
        $query = "DELETE FROM patient_medications WHERE patient_medication_id = ?";
        return $this->db->query($query, [$prescriptionId]);
    }

    public function getActivePrescriptions()
    {
        $query = "SELECT pm.*, m.name as medication_name, 
                         p.full_name as patient_name,
                         d.full_name as doctor_name
                  FROM patient_medications pm
                  JOIN medications m ON pm.medication_id = m.medication_id
                  JOIN patient_profiles p ON pm.patient_id = p.patient_id
                  JOIN doctor_profiles d ON pm.prescribed_by = d.doctor_id
                  WHERE pm.end_date >= CURRENT_DATE
                  ORDER BY pm.start_date DESC";
        return $this->db->query($query)->fetchAll();
    }
}
