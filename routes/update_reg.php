<?php
global $conn;

$reg_id = isset($_GET['reg_id']) ? intval($_GET['reg_id']) : 0;
$status = $_GET['status'] ?? '';

if ($reg_id > 0 && in_array($status, ['approved', 'rejected'])) {
    // อัปเดต reg_status ให้ตรงกับฐานข้อมูล
    $conn->query("UPDATE registrations SET reg_status = '$status' WHERE reg_id = $reg_id");
}

echo "<script>window.history.back();</script>";
exit;
