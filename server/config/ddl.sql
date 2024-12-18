CREATE TABLE attendance_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(255) NOT NULL,
    status ENUM('Hadir', 'Izin', 'Sakit') NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
