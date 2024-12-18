<?php

require '../config/connectionServerToDatabase.php';
require 'AttendanceIzin.php';

ini_set("soap.wsdl_cache_enabled", "0");

try {
    if (!isset($pdo)) {
        throw new Exception("Koneksi ke database tidak tersedia.");
    }

    $service = new AttendanceIzin($pdo);

    $server = new SoapServer('attendanceIzin.wsdl', ['trace' => 1, 'exceptions' => true]);

    $server->setObject($service);
    $server->handle();

} catch (Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "SOAP Server Error: " . $e->getMessage();
    error_log("SOAP Server Error: " . $e->getMessage());
}

