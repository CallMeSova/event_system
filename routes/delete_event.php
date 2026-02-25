<?php
global $conn;

$current_user_id = $_SESSION['user_id'] ?? 0;
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($current_user_id === 0 || $event_id === 0) {
    die("ข้อมูลไม่ถูกต้อง");
}

// เรียกใช้ฟังก์ชันลบที่แยกไว้ใน Model
if (deleteEvent($event_id, $current_user_id)) {
    echo "<script>alert('ลบกิจกรรมและข้อมูลที่เกี่ยวข้องทั้งหมดเรียบร้อยแล้ว'); window.location.href='/';</script>";
} else {
    die("คุณไม่มีสิทธิ์ลบกิจกรรมนี้ หรือเกิดข้อผิดพลาด!");
}
