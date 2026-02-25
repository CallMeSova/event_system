<?php
global $conn;

// 1. ตรวจสอบการเข้าสู่ระบบ
$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id === 0) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อน'); window.location.href='/login';</script>";
    exit;
}

// 2. เรียกใช้ฟังก์ชันที่แยกไว้ใน Model
$my_history = getUserRegistrationHistory($user_id);

// 3. ส่งข้อมูลไปแสดงผลที่ View
renderView('my_history', [
    'my_history' => $my_history
]);
