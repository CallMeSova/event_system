<?php

function getConnection() {
    $hostname = 'localhost';
    $dbname = 'event_system';
    $username = 'admin';
    $password = '1234';
    $conn = new mysqli($hostname, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ตั้งค่าภาษาไทย
    $conn->set_charset("utf8mb4");

    return $conn;
}

$conn = getConnection();
