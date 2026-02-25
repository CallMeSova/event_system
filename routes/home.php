<?php
global $conn;

// ดึงข้อมูลกิจกรรมพร้อมรูปภาพ (เอาเฉพาะรูปแรกมาเป็น Cover)
$sql = "SELECT events.*, event_img.img_path 
        FROM events 
        LEFT JOIN event_img ON events.event_id = event_img.event_id
        GROUP BY events.event_id";

$result = $conn->query($sql);
$events = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

$data = [
    'title' => 'หน้าแรก',
    'events' => $events
];

renderView('home', $data);
