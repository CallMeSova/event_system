<?php
// 1. เรียกใช้ตัวแปรเชื่อมต่อ DB
global $conn;

$event_id = $_GET['id'] ?? 0;

// 2. ดึงข้อมูลกิจกรรม
$event = $conn->query("SELECT * FROM events WHERE event_id = $event_id")->fetch_assoc();

// 3. ดึงตัวเลขสถิติ (สูตรคำนวณที่ถูกต้องเพื่อป้องกันเลขติดลบ)
$sql = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN reg_status = 'pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN reg_status = 'approved' THEN 1 ELSE 0 END) as approved, 
    SUM(CASE WHEN reg_status = 'attended' THEN 1 ELSE 0 END) as attended,
    SUM(CASE WHEN reg_status = 'rejected' THEN 1 ELSE 0 END) as rejected
    FROM registrations WHERE event_id = $event_id";
$stats = $conn->query($sql)->fetch_assoc();

// 4. คำนวณ Attendance Rate (สูตร: มาจริง / (อนุมัติ + มาจริง))
$total_confirmed = $stats['approved'] + $stats['attended'];
$attendance_rate = ($total_confirmed > 0)
    ? round(($stats['attended'] / $total_confirmed) * 100, 1)
    : 0;

// 5. เตรียมข้อมูลส่งไปหน้า Template (จุดที่ตกไปเมื่อกี้)
$data = [
    'title' => 'สถิติกิจกรรม',
    'event' => $event,
    'stats' => $stats,
    'attendance_rate' => $attendance_rate,
    'event_id' => $event_id
];

renderView('event_stats', $data);
