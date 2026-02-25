<?php
global $conn;

// 1. รับค่าค้นหาจาก URL
$search_name = $_GET['search_name'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

// 2. เตรียม SQL พื้นฐาน (ดึงกิจกรรม + รูปแรก)
$sql = "SELECT events.*, event_img.img_path 
        FROM events 
        LEFT JOIN event_img ON events.event_id = event_img.event_id 
        WHERE 1=1";

// 3. เพิ่มเงื่อนไขการค้นหา (ถ้ามีการกรอกข้อมูล)
if (!empty($search_name)) {
    $sql .= " AND events.event_name LIKE '%$search_name%'";
}
if (!empty($start_date) && !empty($end_date)) {
    $sql .= " AND (events.start_date >= '$start_date' AND events.end_date <= '$end_date')";
}

// 4. สั่งจัดกลุ่มและเรียงลำดับ (แก้ปัญหา Error create_date โดยใช้ event_id แทน)
$sql .= " GROUP BY events.event_id ORDER BY events.event_id DESC";

// 5. ประมวลผลและเตรียมข้อมูลส่งไปที่ View
$result = $conn->query($sql);
$events = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// 6. ส่งข้อมูลทั้งหมดเข้า $data ครั้งเดียวตอนท้าย
$data = [
    'title' => 'หน้าแรก',
    'events' => $events
];

renderView('home', $data);
