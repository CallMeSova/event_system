<?php
global $conn;

// 1. เช็คการ Login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อนเข้าร่วมกิจกรรม'); window.history.back();</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($event_id === 0) {
    die("ไม่พบกิจกรรมนี้");
}

// 2. เงื่อนไขความปลอดภัย: เจ้าของงานห้ามสมัครงานตัวเอง
if (isEventCreator($event_id, $user_id)) {
    echo "<script>alert('คุณเป็นเจ้าของกิจกรรมนี้ ไม่จำเป็นต้องลงทะเบียน'); window.history.back();</script>";
    exit;
}

// 3. เช็คว่าเคยลงทะเบียนไปหรือยัง
if (hasAlreadyRegistered($event_id, $user_id)) {
    echo "<script>alert('คุณได้ส่งคำขอเข้าร่วมไปแล้ว'); window.history.back();</script>";
} else {
    // 4. บันทึกคำขอ
    if (registerForEvent($event_id, $user_id)) {
        echo "<script>alert('ส่งคำขอเข้าร่วมสำเร็จ! กรุณารอเจ้าของงานอนุมัติ'); window.location.href='/event_detail?id=$event_id';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการลงทะเบียน'); window.history.back();</script>";
    }
}
exit;
