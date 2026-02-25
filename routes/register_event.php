<?php
global $conn;

// 1. เช็คว่า Login หรือยัง (ต้องเป็นสมาชิกก่อนถึงจะเห็น user_id)
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อนเข้าร่วมกิจกรรม'); window.history.back();</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 2. ดึงข้อมูลกิจกรรมเพื่อเช็คว่าใครเป็นเจ้าของ
$sql_event = "SELECT creator_id FROM events WHERE event_id = $event_id";
$result_event = $conn->query($sql_event);
$event = $result_event->fetch_assoc();

if (!$event) {
    die("ไม่พบกิจกรรมนี้");
}

// 3. เงื่อนไขความปลอดภัย: เจ้าของงานห้ามลงทะเบียนงานตัวเอง
if ($event['creator_id'] == $user_id) {
    echo "<script>alert('คุณเป็นเจ้าของกิจกรรมนี้ ไม่จำเป็นต้องลงทะเบียน'); window.history.back();</script>";
    exit;
}

// 4. เช็คว่าเคยลงทะเบียนไปหรือยัง
$check = $conn->query("SELECT * FROM registrations WHERE event_id = $event_id AND user_id = $user_id");

if ($check->num_rows > 0) {
    echo "<script>alert('คุณได้ส่งคำขอเข้าร่วมไปแล้ว'); window.history.back();</script>";
} else {
    // 5. บันทึกคำขอลงตาราง registrations (สถานะเริ่มต้นเป็น pending)
    $sql_reg = "INSERT INTO registrations (event_id, user_id, reg_status) VALUES ($event_id, $user_id, 'pending')";

    if ($conn->query($sql_reg)) {
        echo "<script>alert('ส่งคำขอเข้าร่วมสำเร็จ! กรุณารอเจ้าของงานอนุมัติ'); window.location.href='/event_detail?id=$event_id';</script>";
    }
}
exit;
