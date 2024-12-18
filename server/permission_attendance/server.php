<?php

// Sertakan file konfigurasi dan kelas layanan
require '../config/connectionServerToDatabase.php';
require 'AttendanceIzin.php';

// Disable WSDL caching
ini_set("soap.wsdl_cache_enabled", "0");

try {
    if (!isset($pdo)) {
        throw new Exception("Koneksi ke database tidak tersedia.");
    }

    $service = new AttendanceIzin($pdo);

    // Tambahkan trace dan exception untuk debugging
    $server = new SoapServer('attendanceIzin.wsdl', ['trace' => 1, 'exceptions' => true]);

    $server->setObject($service);
    $server->handle();

} catch (Exception $e) {
    // Kirim respons error secara eksplisit
    header("HTTP/1.1 500 Internal Server Error");
    echo "SOAP Server Error: " . $e->getMessage();
    error_log("SOAP Server Error: " . $e->getMessage());
}

