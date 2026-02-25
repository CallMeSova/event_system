<?php
global $conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = intval($_POST['event_id']);
    $input_otp = trim($_POST['input_otp']);

    // 1. เรียกใช้ฟังก์ชันตรวจสอบที่แยกไว้
    $target_reg_id = verifyEventOTP($event_id, $input_otp);

    if ($target_reg_id) {
        // 2. ถ้าเจอ ให้เปลี่ยนสถานะเป็น attended
        markAsAttended($target_reg_id);
        echo "<script>alert('✅ รหัสถูกต้อง! ยืนยันการเข้างานสำเร็จ'); window.location.href='/manage_registrations?id=$event_id';</script>";
    } else {
        echo "<script>alert('❌ รหัสไม่ถูกต้อง หรืออาจจะหมดอายุแล้ว (เกิน 30 นาที)'); window.history.back();</script>";
    }
    exit;
}
