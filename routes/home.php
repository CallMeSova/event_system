<?php
global $conn;

// 1. รับค่าค้นหาจาก URL
$search_name = $_GET['search_name'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

// 2. เรียกใช้ฟังก์ชันที่แยกไว้ใน Model
$result = getEvents($search_name, $start_date, $end_date);

$events = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// 3. ส่งข้อมูลเข้า View
$data = [
    'title' => 'หน้าแรก',
    'events' => $events
];

renderView('home', $data);
