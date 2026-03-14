<?php

/**
 * ฟังก์ชันบันทึกการลงทะเบียนกิจกรรม (สุ่ม OTP และเก็บลง DB)
 * ใช้ในไฟล์: routes/register_event.php
 */
function registerForEvent($event_id, $user_id, $otp) {
    global $conn;
    // ใช้ create_date ตามที่เห็นใน phpMyAdmin ของนาย
    $sql = "INSERT INTO registrations (event_id, user_id, reg_status, otp_code, create_date) 
            VALUES (?, ?, 'pending', ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $event_id, $user_id, $otp);
    return $stmt->execute();
}

/**
 * ฟังก์ชันเช็คว่าผู้ใช้เป็นเจ้าของกิจกรรมหรือไม่
 */
function isEventCreator($event_id, $user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT creator_id FROM events WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $event = $stmt->get_result()->fetch_assoc();
    return ($event && $event['creator_id'] == $user_id);
}

/**
 * ฟังก์ชันเช็คว่าเคยลงทะเบียนกิจกรรมนี้ไปหรือยัง
 */
function hasAlreadyRegistered($event_id, $user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT reg_id FROM registrations WHERE event_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    return ($stmt->get_result()->num_rows > 0);
}

/**
 * ฟังก์ชันดึงสถานะการลงทะเบียนและข้อมูล OTP
 */
/**
 * ฟังก์ชันสำหรับเจน OTP ใหม่ (เรียกใช้ผ่าน Route เฉพาะตอนกดปุ่ม)
 */
function generateNewOTP($reg_id) {
    global $conn;
    $new_otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $now = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("UPDATE registrations SET otp_code = ?, create_date = ? WHERE reg_id = ?");
    $stmt->bind_param("ssi", $new_otp, $now, $reg_id);
    return $stmt->execute() ? $new_otp : false;
}

/**
 * ปรับปรุง getUserRegistration ให้ดึงแค่ข้อมูล (ไม่เจนอัตโนมัติแล้ว)
 */
function getUserRegistration($event_id, $user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT reg_id, reg_status, otp_code, create_date FROM registrations WHERE event_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    $reg = $stmt->get_result()->fetch_assoc();

    // เช็คว่าถ้ามีรหัสแล้ว แต่มันนานเกิน 30 นาที ให้ถือว่าไม่มีรหัส (NULL) เพื่อให้ปุ่มเจ็นใหม่โผล่ขึ้นมา
    if ($reg && $reg['otp_code'] !== null) {
        $diff_seconds = time() - strtotime($reg['create_date']);
        if ($diff_seconds > 1800) { // กำหนดเวลาตรงนี้ (30 นาที)
            $reg['otp_code'] = null; // บังคับให้เป็น NULL เพื่อให้หน้าบ้านโชว์ปุ่มเจ็นใหม่
        }
    }
    return $reg;
}

/**
 * ฟังก์ชันตรวจสอบ OTP โดยเช็คจาก Database
 */
function verifyUserOTP($reg_id, $input_otp) {
    global $conn;
    // 1. ดึงข้อมูลขึ้นมาเช็คเวลาด้วย
    $stmt = $conn->prepare("SELECT otp_code, create_date FROM registrations WHERE reg_id = ? AND reg_status = 'approved'");
    $stmt->bind_param("i", $reg_id);
    $stmt->execute();
    $reg = $stmt->get_result()->fetch_assoc();

    if ($reg && $reg['otp_code'] === $input_otp) {
        // 2. คำนวณเวลา (30 นาที = 1800 วินาที)
        $is_expired = (time() - strtotime($reg['create_date'])) > 1800; // 👈 กำหนดเวลาตรงนี้ (วินาที)

        if (!$is_expired) {
            return true; // รหัสถูกต้องและยังไม่หมดอายุ
        }
    }
    return false;
}

/**
 * ฟังก์ชันอัปเดตสถานะการเข้างานและล้าง OTP
 */
function markAsAttended($reg_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE registrations SET reg_status = 'attended', otp_code = NULL WHERE reg_id = ?");
    $stmt->bind_param("i", $reg_id);
    return $stmt->execute();
}

/**
 * ฟังก์ชันเช็คจำนวนคนที่ถูกอนุมัติหรือเข้างานแล้ว
 */
function getConfirmedParticipantCount($event_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM registrations WHERE event_id = ? AND reg_status IN ('approved', 'attended')");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['total'] ?? 0;
}

/**
 * ฟังก์ชันสำหรับแสดงผลหน้าแรก (Home) และ Card กิจกรรม
 * ใช้ในไฟล์: templates/render_event.php
 */
function getConfirmedCount($event_id) {
    // เรียกใช้ฟังก์ชันเดิมที่มีอยู่ เพื่อให้ชื่อตรงกับที่หน้า Home เรียกใช้
    return getConfirmedParticipantCount($event_id);
}

/**
 * ฟังก์ชันดึงรายการกิจกรรมที่ User สมัคร (แก้ไขชื่อคอลัมน์ให้ตรงกับ DB ของ Vigo)
 */
function getUserRegistrationHistory($user_id) {
    global $conn;
    // เปลี่ยนจาก title เป็น event_name และใช้ start_date ตามรูปครับ
    $sql = "SELECT r.*, e.event_name, e.start_date, e.location 
            FROM registrations r
            JOIN events e ON r.event_id = e.event_id
            WHERE r.user_id = ?
            ORDER BY r.create_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
