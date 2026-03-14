<?php
global $conn;

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อนเข้าร่วมกิจกรรม'); window.history.back();</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($event_id === 0) {
    die("ไม่พบกิจกรรมนี้");
}

if (isEventCreator($event_id, $user_id)) {
    echo "<script>alert('คุณเป็นเจ้าของกิจกรรมนี้ ไม่จำเป็นต้องลงทะเบียน'); window.history.back();</script>";
    exit;
}

if (hasAlreadyRegistered($event_id, $user_id)) {
    echo "<script>alert('คุณได้ส่งคำขอเข้าร่วมไปแล้ว'); window.history.back();</script>";
} else {
    // ส่งค่า null ไปแทน $otp เพราะยังไม่อนุมัติ
    if (registerForEvent($event_id, $user_id, null)) {
        echo "<script>alert('ส่งคำขอเข้าร่วมสำเร็จ! โปรดรอผู้จัดงานอนุมัติ'); window.location.href='/event_detail?id=$event_id';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด'); window.history.back();</script>";
    }
}
exit;
