-- Create database
CREATE DATABASE blood_pressure_monitoring;
USE blood_pressure_monitoring;

-- Users table (for all types of users)
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('admin', 'doctor', 'patient') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Patient profiles
CREATE TABLE patient_profiles (
    patient_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender ENUM('M', 'F') NOT NULL,
    address TEXT,
    phone_number VARCHAR(20),
    emergency_contact VARCHAR(100),
    emergency_phone VARCHAR(20),
    medical_history TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Doctor profiles
CREATE TABLE doctor_profiles (
    doctor_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    specialization VARCHAR(100),
    license_number VARCHAR(50) UNIQUE NOT NULL,
    phone_number VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Doctor-Patient relationship
CREATE TABLE doctor_patients (
    doctor_id INT,
    patient_id INT,
    assigned_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (doctor_id, patient_id),
    FOREIGN KEY (doctor_id) REFERENCES doctor_profiles(doctor_id),
    FOREIGN KEY (patient_id) REFERENCES patient_profiles(patient_id)
);

-- Blood pressure readings
CREATE TABLE blood_pressure_readings (
    reading_id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT,
    systolic INT NOT NULL,
    diastolic INT NOT NULL,
    pulse_rate INT,
    reading_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notes TEXT,
    FOREIGN KEY (patient_id) REFERENCES patient_profiles(patient_id)
);

-- Medications
CREATE TABLE medications (
    medication_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    dosage_form VARCHAR(50),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- Patient medications
CREATE TABLE patient_medications (
    patient_medication_id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT,
    medication_id INT,
    dosage VARCHAR(50),
    frequency VARCHAR(50),
    start_date DATE,
    end_date DATE,
    prescribed_by INT,
    notes TEXT,
    FOREIGN KEY (patient_id) REFERENCES patient_profiles(patient_id),
    FOREIGN KEY (medication_id) REFERENCES medications(medication_id),
    FOREIGN KEY (prescribed_by) REFERENCES doctor_profiles(doctor_id)
);

-- Health recommendations
CREATE TABLE health_recommendations (
    recommendation_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    bp_range_systolic_min INT,
    bp_range_systolic_max INT,
    bp_range_diastolic_min INT,
    bp_range_diastolic_max INT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- Patient recommendations log
CREATE TABLE patient_recommendations (
    patient_recommendation_id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT,
    recommendation_id INT,
    reading_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patient_profiles(patient_id),
    FOREIGN KEY (recommendation_id) REFERENCES health_recommendations(recommendation_id),
    FOREIGN KEY (reading_id) REFERENCES blood_pressure_readings(reading_id)
);

-- Create indexes for better performance
CREATE INDEX idx_bp_readings_patient_date ON blood_pressure_readings(patient_id, reading_date);
CREATE INDEX idx_patient_meds_patient ON patient_medications(patient_id);
CREATE INDEX idx_patient_recommendations_patient ON patient_recommendations(patient_id);