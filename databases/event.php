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
