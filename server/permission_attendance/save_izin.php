<?php
require '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $employeeName = trim($data['employee_name'] ?? '');
    $reason = trim($data['reason'] ?? '');

    if (empty($employeeName) || empty($reason)) {
        echo json_encode(['success' => false, 'message' => 'Nama karyawan dan alasan izin harus diisi.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO attendance_izin (employee_name, reason, request_date, status)
             VALUES (:employee_name, :reason, CURDATE(), 'Pending')"
        );
        $stmt->bindParam(':employee_name', $employeeName, PDO::PARAM_STR);
        $stmt->bindParam(':reason', $reason, PDO::PARAM_STR);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Izin berhasil diajukan dengan status Pending.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan izin: ' . $e->getMessage()]);
    }
} else {
   
    http_response_code(405); 
    echo json_encode(['success' => false, 'message' => 'Metode tidak valid. Gunakan metode POST.']);
}
