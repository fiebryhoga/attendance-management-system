<?php
header('Content-Type: application/json');
require '../config/connection.php';

try {
    // Ambil waktu saat ini
    $current_datetime = date('Y-m-d H:i:s');

    // Perbarui status absensi jika waktu sekarang melebihi waktu penutupan
    $update_query = $pdo->prepare("
        UPDATE attendance
        SET status = 'inactive'
        WHERE CONCAT(date, ' ', end_time) < :current_datetime
        AND status = 'active'
    ");
    $update_query->execute([':current_datetime' => $current_datetime]);

    // Query untuk mengambil absensi aktif
    $query = $pdo->prepare("
        SELECT id, date, start_time, end_time
        FROM attendance
        WHERE status = 'active'
    ");
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal mengambil data absensi aktif.', 'details' => $e->getMessage()]);
}