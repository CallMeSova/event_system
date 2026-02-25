<?php

/**
 * ไฟล์: databases/events.php
 * รวมฟังก์ชันจัดการข้อมูลกิจกรรม (Events Model)
 */

/**
 * ฟังก์ชันสร้างกิจกรรมใหม่ 
 * ใช้ในไฟล์: routes/create_event.php
 */
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

/**
 * ฟังก์ชันบันทึกที่อยู่รูปภาพลงฐานข้อมูล
 * ใช้ในไฟล์: routes/create_event.php และ routes/edit_event.php
 */
function saveEventImage($event_id, $file_name) {
    global $conn;
    $sql = "INSERT INTO event_img (event_id, img_path) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $event_id, $file_name);
    return $stmt->execute();
}

/**
 * ฟังก์ชันสำหรับลบกิจกรรมและข้อมูลที่เกี่ยวข้องทั้งหมด (รวมถึงไฟล์รูปภาพ)
 * ใช้ในไฟล์: routes/delete_event.php
 */
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
        $path = "../public/uploads/" . $img['img_path'];
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

/**
 * ฟังก์ชันดึงข้อมูลกิจกรรมพร้อมตรวจสอบสิทธิ์ผู้สร้าง
 * ใช้ในไฟล์: routes/edit_event.php
 */
function getEventForEdit($event_id, $user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM events WHERE event_id = ? AND creator_id = ?");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/**
 * ฟังก์ชันดึงรูปภาพทั้งหมดของกิจกรรม
 * ใช้ในไฟล์: routes/edit_event.php
 */
function getEventImages($event_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM event_img WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * ฟังก์ชันอัปเดตข้อมูลกิจกรรมพื้นฐาน
 * ใช้ในไฟล์: routes/edit_event.php
 */
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

/**
 * ฟังก์ชันดึงข้อมูลกิจกรรมแบบละเอียด (รวมชื่อผู้จัดงาน)
 * ใช้ในไฟล์: routes/event_detail.php
 */
function getEventDetail($event_id) {
    global $conn;
    $sql = "SELECT events.*, users.full_name AS creator_name 
            FROM events 
            JOIN users ON events.creator_id = users.user_id 
            WHERE events.event_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/**
 * ฟังก์ชันดึงรูปภาพทั้งหมดของกิจกรรมนั้นๆ
 * ใช้ในไฟล์: routes/event_detail.php
 */
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

/**
 * ฟังก์ชันสำหรับดึงรายการกิจกรรมทั้งหมดพร้อมระบบค้นหา
 * ใช้ในไฟล์: routes/home.php
 */
function getEvents($search_name = '', $start_date = '', $end_date = '') {
    global $conn;

    $sql = "SELECT events.*, event_img.img_path 
            FROM events 
            LEFT JOIN event_img ON events.event_id = event_img.event_id 
            WHERE 1=1";

    $params = [];
    $types = "";

    if (!empty($search_name)) {
        $sql .= " AND events.event_name LIKE ?";
        $params[] = "%$search_name%";
        $types .= "s";
    }

    if (!empty($start_date) && !empty($end_date)) {
        $sql .= " AND (events.start_date >= ? AND events.end_date <= ?)";
        $params[] = $start_date;
        $params[] = $end_date;
        $types .= "ss";
    }

    $sql .= " GROUP BY events.event_id ORDER BY events.event_id DESC";

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt->get_result();
}
