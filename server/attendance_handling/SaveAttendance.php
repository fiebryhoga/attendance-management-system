<?php

class SaveAttendance
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Method untuk menyimpan data kehadiran
    public function saveAttendance($employeeName, $status)
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO attendance_records (employee_name, status, timestamp)
                VALUES (:employee_name, :status, NOW())
            ");

            $stmt->execute([
                ':employee_name' => $employeeName,
                ':status' => $status,
            ]);

            return "Presensi berhasil disimpan.";
        } catch (PDOException $e) {
            throw new SoapFault("Server", "Kesalahan saat menyimpan presensi: " . $e->getMessage());
        }
    }

    // Method untuk mendapatkan kehadiran (Hadir)
    public function getAttendanceHadir($employeeName, $month)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM attendance_records
                WHERE employee_name = :employee_name
                AND status = 'Hadir'
                AND MONTH(timestamp) = :month
            ");

            $stmt->execute([
                ':employee_name' => $employeeName,
                ':month' => $month,
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new SoapFault("Server", "Kesalahan saat mengambil data kehadiran: " . $e->getMessage());
        }
    }

    // Method untuk mendapatkan kehadiran (Sakit)
    public function getAttendanceSakit($employeeName, $month)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM attendance_records
                WHERE employee_name = :employee_name
                AND status = 'Sakit'
                AND MONTH(timestamp) = :month
            ");

            $stmt->execute([
                ':employee_name' => $employeeName,
                ':month' => $month,
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new SoapFault("Server", "Kesalahan saat mengambil data kehadiran: " . $e->getMessage());
        }
    }
}
