<?php

// Sertakan file konfigurasi dan kelas layanan
require '../config/connection.php';
require 'SaveAttendance.php';

try {
    // Pastikan koneksi database tersedia
    if (!isset($pdo)) {
        throw new Exception("Koneksi ke database tidak tersedia.");
    }

    // Buat instance dari AttendanceService dengan $pdo
    $service = new SaveAttendance($pdo);

    // Buat instance SoapServer dengan WSDL
    $server = new SoapServer('saveAttendance.wsdl');

    // Atur objek layanan
    $server->setObject($service);

    // Tangani permintaan SOAP
    $server->handle();

} catch (Exception $e) {
    // Tangani kesalahan dan tampilkan pesan
    echo "SOAP Server Error: " . $e->getMessage();
}


