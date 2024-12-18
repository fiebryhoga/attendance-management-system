<?php
require "vendor/autoload.php";
require "SaveAttendance.php";

$gen = new \PHP2WSDL\PHPClass2WSDL("SaveAttendance",
    "http://localhost/attendance_management_system/server/attendance_handling/server.php");

$gen->generateWSDL();
file_put_contents("saveAttendance.wsdl", $gen->dump());
echo "Done!";

echo "WSDL generated successfully!";
