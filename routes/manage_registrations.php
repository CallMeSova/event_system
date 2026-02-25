<?php
global $conn;

$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'] ?? 0;

// เช็คสิทธิ์เจ้าของงาน
$check = $conn->query("SELECT creator_id FROM events WHERE event_id = $event_id AND creator_id = $user_id");
if ($check->num_rows === 0) die("สิทธิ์ไม่เพียงพอ");

// ดึงข้อมูลผู้สมัครพร้อมรายละเอียดติดต่อ
$sql = "SELECT r.reg_id, r.reg_status, u.full_name, u.email, u.phone_number 
        FROM registrations r 
        JOIN users u ON r.user_id = u.user_id 
        WHERE r.event_id = $event_id";
$registrations = $conn->query($sql);

renderView('manage_registrations', ['registrations' => $registrations, 'event_id' => $event_id]);
