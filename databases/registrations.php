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

// ฟังก์ชันดึงประวัติการสมัครกิจกรรมของผู้ใช้คนนั้นๆ
function getUserRegistrationHistory($user_id) {
    global $conn;
    // ใช้ Prepared Statement และ JOIN เพื่อดึงชื่อกิจกรรมและข้อมูลการสมัคร
    $sql = "SELECT r.reg_status, r.create_date AS reg_date, e.event_name, e.event_id, e.start_date 
            FROM registrations r 
            JOIN events e ON r.event_id = e.event_id 
            WHERE r.user_id = ? 
            ORDER BY r.create_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result(); // ส่งคืนชุดข้อมูลผลลัพธ์
}

// ฟังก์ชันเช็คว่าผู้ใช้เป็นเจ้าของกิจกรรมหรือไม่
function isEventCreator($event_id, $user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT creator_id FROM events WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $event = $stmt->get_result()->fetch_assoc();
    return ($event && $event['creator_id'] == $user_id);
}

// ฟังก์ชันเช็คว่าเคยลงทะเบียนกิจกรรมนี้ไปหรือยัง
function hasAlreadyRegistered($event_id, $user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT reg_id FROM registrations WHERE event_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    return ($stmt->get_result()->num_rows > 0);
}

// ฟังก์ชันบันทึกการลงทะเบียนกิจกรรม
function registerForEvent($event_id, $user_id) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO registrations (event_id, user_id, reg_status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("ii", $event_id, $user_id);
    return $stmt->execute();
}
