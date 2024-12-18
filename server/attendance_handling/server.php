<?php

require '../config/connection.php';
require 'SaveAttendance.php';

try {
    if (!isset($pdo)) {
        throw new Exception("Koneksi ke database tidak tersedia.");
    }

    $service = new SaveAttendance($pdo);

    $server = new SoapServer('saveAttendance.wsdl');

    $server->setObject($service);

    $server->handle();

} catch (Exception $e) {
    echo "SOAP Server Error: " . $e->getMessage();
}


