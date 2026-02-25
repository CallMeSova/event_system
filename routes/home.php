<?php
global $conn;

// 1. รับค่าการค้นหาจาก URL
$search_name = $_GET['search_name'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

// 2. สร้าง SQL แบบ Join เพื่อเอาชื่อกิจกรรมและรูปแรก (Cover) มาพร้อมกัน
$sql = "SELECT events.*, event_img.img_path 
        FROM events 
        LEFT JOIN event_img ON events.event_id = event_img.event_id 
        WHERE 1=1";

// 3. เพิ่มเงื่อนไขการค้นหา (Dynamic SQL)
if (!empty($search_name)) {
    $sql .= " AND events.event_name LIKE '%$search_name%'";
}
if (!empty($start_date) && !empty($end_date)) {
    // ค้นหาช่วงวันที่เริ่มงาน
    $sql .= " AND (events.start_date >= '$start_date' AND events.end_date <= '$end_date')";
}

// Group เพื่อให้ 1 กิจกรรมโชว์แค่รูปเดียวในหน้าแรก
$sql .= " GROUP BY events.event_id ORDER BY events.event_id DESC";

$result = $conn->query($sql);
$events = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// 4. ส่งค่าไปที่ Template
$data = [
    'title' => 'หน้าแรก',
    'events' => $events,
    'search_params' => [ // ส่งค่ากลับไปโชว์ในช่อง Input ด้วย
        'name' => $search_name,
        'start' => $start_date,
        'end' => $end_date
    ]
];

renderView('home', $data);
