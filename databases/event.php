<?php

// ฟังก์ชันสร้างกิจกรรมใหม่ 
function createEvent($name, $creator, $desc, $loc, $start, $end, $max) {
    global $conn;
    $sql = "INSERT INTO events (event_name, creator_id, description, location, start_date, end_date, max_people, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'open')";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssi", $name, $creator, $desc, $loc, $start, $end, $max);

    if ($stmt->execute()) {
        return $conn->insert_id; // คืนค่า ID ของกิจกรรมที่เพิ่งสร้าง
    }
    return false;
}

// ฟังก์ชันบันทึกที่อยู่รูปภาพลงฐานข้อมูล
function saveEventImage($event_id, $file_name) {
    global $conn;
    $sql = "INSERT INTO event_img (event_id, img_path) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $event_id, $file_name);
    return $stmt->execute();
}

// ฟังก์ชันสำหรับลบกิจกรรมและข้อมูลที่เกี่ยวข้องทั้งหมด
function deleteEvent($event_id, $current_user_id) {
    global $conn;

    // 1. เช็คสิทธิ์ก่อนว่าคนลบคือเจ้าของกิจกรรมจริงไหม
    $stmt = $conn->prepare("SELECT creator_id FROM events WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $event = $stmt->get_result()->fetch_assoc();

    if (!$event || $event['creator_id'] != $current_user_id) {
        return false; // ไม่มีสิทธิ์ลบ
    }

    // 2. ลบข้อมูลคนสมัคร (Registrations)
    $stmt_reg = $conn->prepare("DELETE FROM registrations WHERE event_id = ?");
    $stmt_reg->bind_param("i", $event_id);
    $stmt_reg->execute();

    // 3. ลบรูปภาพจริงในโฟลเดอร์ และข้อมูลใน DB
    $stmt_img = $conn->prepare("SELECT img_path FROM event_img WHERE event_id = ?");
    $stmt_img->bind_param("i", $event_id);
    $stmt_img->execute();
    $result_imgs = $stmt_img->get_result();

    while ($img = $result_imgs->fetch_assoc()) {
        $path = "../public/uploads/" . $img['img_path']; // ปรับ Path ให้ถูกต้อง
        if (file_exists($path)) {
            unlink($path); // ลบไฟล์รูปจริงออกจาก Disk
        }
    }

    // 4. ลบข้อมูลรูปใน DB
    $stmt_del_img = $conn->prepare("DELETE FROM event_img WHERE event_id = ?");
    $stmt_del_img->bind_param("i", $event_id);
    $stmt_del_img->execute();

    // 5. ลบตัวกิจกรรมหลัก
    $stmt_del_event = $conn->prepare("DELETE FROM events WHERE event_id = ?");
    $stmt_del_event->bind_param("i", $event_id);

    return $stmt_del_event->execute();
}

// ฟังก์ชันดึงข้อมูลกิจกรรมพร้อมตรวจสอบสิทธิ์ผู้สร้าง
function getEventForEdit($event_id, $user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM events WHERE event_id = ? AND creator_id = ?");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// ฟังก์ชันดึงรูปภาพทั้งหมดของกิจกรรม
function getEventImages($event_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM event_img WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    return $stmt->get_result();
}

// ฟังก์ชันอัปเดตข้อมูลกิจกรรมพื้นฐาน
function updateEvent($id, $name, $desc, $loc, $start, $end, $max) {
    global $conn;
    $sql = "UPDATE events SET 
                event_name = ?, description = ?, location = ?, 
                start_date = ?, end_date = ?, max_people = ? 
            WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssii", $name, $desc, $loc, $start, $end, $max, $id);
    return $stmt->execute();
}

// ฟังก์ชันดึงข้อมูลกิจกรรมแบบละเอียด (รวมชื่อผู้จัดงาน)
function getEventDetail($event_id) {
    global $conn;
    // ใช้ JOIN เพื่อดึงชื่อผู้สร้าง (creator_name) มาแสดงผลในหน้าเดียวเลยครับ
    $sql = "SELECT events.*, users.full_name AS creator_name 
            FROM events 
            JOIN users ON events.creator_id = users.user_id 
            WHERE events.event_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// ฟังก์ชันดึงรูปภาพทั้งหมดของกิจกรรมนั้นๆ
function getImagesByEventId($event_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM event_img WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $images = [];
    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
    return $images;
}
