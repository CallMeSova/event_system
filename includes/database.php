<?php

function getConnection() {
    $hostname = 'gonggang.net';
    $dbname = 'u910454988_evently';
    $username = 'u910454988_evently';
    $password = 'X+z?M9LdT983**Q9';
    $conn = new mysqli($hostname, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ตั้งค่าภาษาไทย
    $conn->set_charset("utf8mb4");

    return $conn;
}

$conn = getConnection();
