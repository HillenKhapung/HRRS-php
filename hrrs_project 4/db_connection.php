<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hostel_reservation_system';


$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$conn->set_charset("utf8");
?>
