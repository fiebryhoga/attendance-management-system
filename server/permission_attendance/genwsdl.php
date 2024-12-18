<?php
require "vendor/autoload.php";
require "AttendanceIzin.php";

$gen = new \PHP2WSDL\PHPClass2WSDL("AttendanceIzin",
    "http://localhost/attendance_management_system/server/permission_attendance/server.php");

$gen->generateWSDL();
file_put_contents("attendanceIzin.wsdl", $gen->dump());
echo "Done!";

echo "WSDL generated successfully!";
