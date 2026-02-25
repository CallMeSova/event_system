<?php
global $conn;

$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'] ?? 0;
// รับค่าสถานะที่ผู้ใช้เลือกกรอง
$filter_status = $_GET['filter_status'] ?? '';

$check_owner = $conn->query("SELECT creator_id FROM events WHERE event_id = $event_id AND creator_id = $user_id");
if ($check_owner->num_rows === 0) die("สิทธิ์ไม่เพียงพอ");

// สร้าง SQL พื้นฐาน
$sql = "SELECT r.reg_id, r.reg_status, u.full_name, u.email, u.phone_number 
        FROM registrations r 
        JOIN users u ON r.user_id = u.user_id 
        WHERE r.event_id = $event_id";

// ถ้ามีการเลือกกรองสถานะ ให้เพิ่มเงื่อนไข WHERE เข้าไป
if (!empty($filter_status)) {
        $sql .= " AND r.reg_status = '$filter_status'";
}

$registrations = $conn->query($sql);

// ส่งตัวแปร $current_filter ไปใช้ที่ Template เพื่อให้ Dropdown ค้างค่าที่เลือกไว้
renderView('manage_registrations', [
        'registrations' => $registrations,
        'event_id' => $event_id,
        'current_filter' => $filter_status
]);
