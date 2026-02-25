<?php
global $conn;

// 1. รับ ID และทำให้เป็นตัวเลขเพื่อความปลอดภัย
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($event_id === 0) {
    die("ไม่พบรหัสกิจกรรม");
}

// 2. เรียกใช้ฟังก์ชันที่แยกไว้ใน databases/events.php
$event = getEventDetail($event_id);

if (!$event) {
    die("ไม่พบข้อมูลกิจกรรมในระบบ");
}

// 3. ดึงรูปภาพประกอบ
$images = getImagesByEventId($event_id);

// 4. ส่งข้อมูลไปที่หน้าแสดงผล
renderView('event_detail', [
    'event' => $event,
    'images' => $images
]);
