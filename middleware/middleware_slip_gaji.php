<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Hanya metode GET yang diizinkan.']);
    exit;
}

if (!isset($_GET['name']) || !isset($_GET['month'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Parameter "name" dan "month" diperlukan.']);
    exit;
}

$name = $_GET['name'];
$month = $_GET['month'];

$apiUrl = "http://localhost/payroll_system/server/slip_gaji/server.php?name=" . urlencode($name) . "&month=" . urlencode($month);

try {
    $response = file_get_contents($apiUrl);

    if ($response === false) {
        throw new Exception("Gagal menghubungi API backend.");
    }

    $data = json_decode($response, true);

    if ($data === null) {
        throw new Exception("Respon API tidak valid.");
    }

    echo json_encode($data);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
