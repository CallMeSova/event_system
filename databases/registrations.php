<?php

// ฟังก์ชันนับจำนวนคนที่มีสถานะ approved หรือ attended ในกิจกรรมนั้นๆ
function getApprovedCount($event_id) {
    global $conn;
    // นับเฉพาะคนที่อนุมัติแล้ว หรือเข้างานแล้ว
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM registrations WHERE event_id = ? AND reg_status IN ('approved', 'attended')");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['total'];
}

//ฟังก์ชันตรวจสอบ OTP ของผู้สมัครในกิจกรรม
function verifyEventOTP($event_id, $input_otp) {
    global $conn;

    // 1. ดึงข้อมูลเฉพาะคนที่เป็น 'approved' ในกิจกรรมนี้มาเช็ค
    $stmt = $conn->prepare("SELECT reg_id, create_date FROM registrations WHERE event_id = ? AND reg_status = 'approved'");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        // 2. คำนวณ OTP ปัจจุบันของคนนี้ (ฟังก์ชัน get_event_otp อยู่ใน includes/otp.php)
        $calculated_otp = get_event_otp($row['reg_id'], $row['create_date']);

        if ($input_otp === $calculated_otp) {
            return $row['reg_id']; // พบคนที่รหัสตรงกัน
        }
    }
    return false; // ไม่พบรหัสที่ตรงกัน
}

//  ฟังก์ชันอัปเดตสถานะการเข้างาน
function markAsAttended($reg_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE registrations SET reg_status = 'attended' WHERE reg_id = ?");
    $stmt->bind_param("i", $reg_id);
    return $stmt->execute();
}
