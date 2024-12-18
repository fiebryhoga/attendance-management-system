<?php
require '../config/connection.php'; // Pastikan path sesuai dengan lokasi file Anda

header('Content-Type: application/json');

// Ambil data JSON dari permintaan POST
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['employee_name'], $data['status']) && $data['status'] === 'Hadir') {
    $employeeName = $data['employee_name'];
    $status = $data['status'];
    $currentDate = date('Y-m-d'); // Ambil tanggal saat ini
    $currentMonth = date('m'); // Ambil bulan saat ini (angka)

    try {
        // Simpan data ke tabel attendance_records
        $stmt = $pdo->prepare(
            "INSERT INTO attendance_records (employee_name, status, date, month) VALUES (:employee_name, :status, :date, :month)"
        );
        $stmt->bindParam(':employee_name', $employeeName, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':date', $currentDate, PDO::PARAM_STR);
        $stmt->bindParam(':month', $currentMonth, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Presensi berhasil disimpan.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan presensi: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak valid atau status bukan Hadir.']);
}
