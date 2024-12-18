<?php

// URL dari file WSDL
$wsdl = "http://localhost/payroll_system/server/open_attendance/attendanceService.wsdl";

try {
    $client = new SoapClient($wsdl);

    $activeAttendance = $client->getActiveAttendance();

    header('Content-Type: application/json');

    echo json_encode($activeAttendance, JSON_PRETTY_PRINT);

} catch (SoapFault $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
