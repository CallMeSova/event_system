<?php
// routes/check_user_otp.php
global $conn;

// --- 1. ส่วนประมวลผลเมื่อมีการส่งฟอร์ม (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_id = intval($_POST['reg_id']);
    $event_id = intval($_POST['event_id']);
    $input_otp = trim($_POST['input_otp']);

    if (verifyUserOTP($reg_id, $input_otp)) {
        if (markAsAttended($reg_id)) {
            echo "<script>alert('✅ ยืนยันเข้างานสำเร็จ!'); window.location.href='/manage_registrations?id=$event_id';</script>";
            exit;
        }
    } else {
        echo "<script>alert('❌ รหัส OTP ไม่ถูกต้อง หรือหมดอายุแล้ว'); window.history.back();</script>";
        exit;
    }
}

// --- 2. ส่วนแสดงผลเมื่อเปิดหน้าเว็บปกติ (GET) ---
$reg_id = isset($_GET['reg_id']) ? intval($_GET['reg_id']) : 0;
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// เช็คความปลอดภัยสักหน่อย: ถ้าไม่มี ID ส่งมาให้ดีดกลับ
if ($reg_id === 0 || $event_id === 0) {
    header('Location: /');
    exit;
}

renderView('check_user_otp', [
    'reg_id' => $reg_id,
    'event_id' => $event_id
]);
