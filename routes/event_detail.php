<?php
global $conn;

// รับ ID และทำให้เป็นตัวเลขเพื่อความปลอดภัย
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($event_id === 0) {
    die("ไม่พบรหัสกิจกรรม");
}

// Query ดึงข้อมูลกิจกรรม
$sql_event = "SELECT * FROM events WHERE event_id = $event_id";
$result_event = $conn->query($sql_event);
$event = $result_event->fetch_assoc();

if (!$event) {
    die("ไม่พบข้อมูลกิจกรรมในระบบ");
}

$sql_images = "SELECT * FROM event_img WHERE event_id = $event_id";
$result_images = $conn->query($sql_images);
$images = [];
while ($row = $result_images->fetch_assoc()) {
    $images[] = $row;
}

// ส่งข้อมูลไปที่หน้าแสดงผล
renderView('event_detail', [
    'event' => $event,
    'images' => $images
]);
