<?php

// URL dari file WSDL
$wsdl = "http://localhost/payroll_system/server/open_attendance/attendanceService.wsdl";

try {
    // Inisialisasi SOAP client
    $client = new SoapClient($wsdl);

    // Panggil metode getActiveAttendance dari layanan SOAP
    $activeAttendance = $client->getActiveAttendance();

    // Set header untuk JSON
    header('Content-Type: application/json');

    // Encode hasil ke JSON dan tampilkan
    echo json_encode($activeAttendance, JSON_PRETTY_PRINT);

} catch (SoapFault $e) {
    // Tangani kesalahan SOAP
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
