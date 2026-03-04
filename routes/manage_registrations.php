<?php
global $conn;

// 1. กรองค่า ID ให้เป็น Integer
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'] ?? 0;
$filter_status = $_GET['filter_status'] ?? '';

// 2. แก้จุดที่ 1: เช็คเจ้าของกิจกรรมด้วย Prepared Statement
$stmt_owner = $conn->prepare("SELECT creator_id FROM events WHERE event_id = ? AND creator_id = ?");
$stmt_owner->bind_param("ii", $event_id, $user_id);
$stmt_owner->execute();
$check_owner = $stmt_owner->get_result();

if ($check_owner->num_rows === 0) die("สิทธิ์ไม่เพียงพอ");

// 3. แก้จุดที่ 2 & 3: สร้าง Dynamic Query แบบปลอดภัย
$sql = "SELECT r.reg_id, r.reg_status, u.full_name, u.email, u.phone_number 
        FROM registrations r 
        JOIN users u ON r.user_id = u.user_id 
        WHERE r.event_id = ?"; // ใช้ ? แทน $event_id

$params = [$event_id];
$types = "i";

// ถ้ามีการกรองสถานะ ให้ต่อคำสั่ง SQL แต่ใช้ ? รับค่า
if (!empty($filter_status)) {
        $sql .= " AND r.reg_status = ?"; // ใช้ ? แทน '$filter_status'
        $params[] = $filter_status;
        $types .= "s";
}

$stmt_reg = $conn->prepare($sql);
$stmt_reg->bind_param($types, ...$params); // ใช้ Splat Operator กระจายค่า
$stmt_reg->execute();
$registrations = $stmt_reg->get_result();

// ส่งค่าไปที่ View
renderView('manage_registrations', [
        'registrations' => $registrations,
        'event_id' => $event_id,
        'current_filter' => $filter_status
]);
