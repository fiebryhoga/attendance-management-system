create database attendance_management_system;

use attendance_management_system;


CREATE TABLE `attendance_izin` (
  `id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `request_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Pending','Approved') NOT NULL DEFAULT 'Pending')


CREATE TABLE attendance_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(255) NOT NULL,
    status ENUM('Hadir', 'Izin', 'Sakit') NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

