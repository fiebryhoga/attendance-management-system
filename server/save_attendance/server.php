<?php
require '../config/connection.php'; // Pastikan path ini sesuai dengan lokasi file koneksi database Anda

header('Content-Type: application/json');

// Fungsi untuk menangani pengambilan data presensi
function getAttendance($pdo)
{
    // Ambil parameter nama dan bulan dari query string
    $name = isset($_GET['name']) ? $_GET['name'] : null;
    $month = isset($_GET['month']) ? $_GET['month'] : null;

    if ($name && $month) {
        try {
            // Query untuk mengambil data presensi berdasarkan nama dan bulan
            $stmt = $pdo->prepare(
                "SELECT employee_name, status, date
                 FROM attendance_records
                 WHERE employee_name = :name AND month = :month"
            );
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':month', $month, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                echo json_encode(['success' => true, 'data' => $result]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Gagal mengambil data: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Parameter nama dan bulan diperlukan.']);
    }
}

// Cek metode HTTP
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    getAttendance($pdo);
} else {
    echo json_encode(['success' => false, 'message' => 'Metode HTTP tidak didukung.']);
}
