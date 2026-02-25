<?php
global $conn;

// 1. รับ ID และทำให้เป็นตัวเลขเพื่อความปลอดภัย
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'] ?? 0;

if ($event_id === 0) {
    die("ไม่พบรหัสกิจกรรม");
}

// 2. เรียกใช้ฟังก์ชันดึงรายละเอียดกิจกรรมและรูปภาพ
$event = getEventDetail($event_id);
if (!$event) {
    die("ไม่พบข้อมูลกิจกรรมในระบบ");
}
$images = getImagesByEventId($event_id);

// 3. ดึงสถานะการสมัครของผู้ใช้ (ถ้า Login อยู่)
$reg_data = ($user_id > 0) ? getUserRegistration($event_id, $user_id) : null;

// 4. ดึงจำนวนคนที่สมัครแล้ว และเช็คว่าเต็มหรือยัง
$current_count = getConfirmedParticipantCount($event_id);
$is_full = ($current_count >= $event['max_people']);

// 5. ส่งข้อมูลทั้งหมดเข้า View
renderView('event_detail', [
    'event' => $event,
    'images' => $images,
    'reg_data' => $reg_data,
    'current_count' => $current_count,
    'is_full' => $is_full
]);
