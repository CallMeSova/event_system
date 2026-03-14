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
function getUserRegistration($event_id, $user_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT reg_id, reg_status, otp_code, create_date FROM registrations WHERE event_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    $reg = $stmt->get_result()->fetch_assoc();

    if ($reg && $reg['otp_code'] !== null) {
        $created_time = strtotime($reg['create_date']);
        $current_time = time(); // เวลา PHP (Bangkok)

        // คำนวณส่วนต่างเป็นนาที
        $diff_minutes = floor(($current_time - $created_time) / 60);

        // ถ้าค่าติดลบหรือเกิน 30 ให้ Reset (ป้องกันเรื่อง Timezone หลอน)
        if ($diff_minutes >= 30 || $diff_minutes < 0) {
            $new_otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // ใช้เวลาจาก PHP ในการอัปเดตแทน NOW() ของ SQL เพื่อความซิงค์กัน
            $now = date('Y-m-d H:i:s');
            $update_stmt = $conn->prepare("UPDATE registrations SET otp_code = ?, create_date = ? WHERE reg_id = ?");
            $update_stmt->bind_param("ssi", $new_otp, $now, $reg['reg_id']);
            $update_stmt->execute();

            $reg['otp_code'] = $new_otp;
            $reg['create_date'] = $now;
        }
    }
    return $reg;
}

/**
 * ฟังก์ชันตรวจสอบ OTP โดยเช็คจาก Database
 */
function verifyUserOTP($reg_id, $input_otp) {
    global $conn;
    $stmt = $conn->prepare("SELECT reg_id FROM registrations WHERE reg_id = ? AND otp_code = ? AND reg_status = 'approved'");
    $stmt->bind_param("is", $reg_id, $input_otp);
    $stmt->execute();
    return ($stmt->get_result()->num_rows > 0);
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
