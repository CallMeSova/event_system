<?php
global $conn;

// 1. ป้องกันคนแอบเข้าผ่าน URL โดยไม่ได้ Login
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. ดึงกิจกรรมที่ฉันสร้าง (Owner)
$sql_created = "SELECT * FROM events WHERE creator_id = ? ORDER BY start_date DESC";
$stmt1 = $conn->prepare($sql_created);
$stmt1->bind_param("i", $user_id);
$stmt1->execute();
$created_events = $stmt1->get_result()->fetch_all(MYSQLI_ASSOC);

// 3. ดึงกิจกรรมที่ฉันขอเข้าร่วม (Participant)
$sql_joined = "SELECT e.*, r.reg_status 
               FROM events e 
               JOIN registrations r ON e.event_id = r.event_id 
               WHERE r.user_id = ? 
               ORDER BY e.start_date DESC";
$stmt2 = $conn->prepare($sql_joined);
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$joined_events = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);

// 4. ส่งข้อมูลไปที่หน้าหน้าบ้าน (Template)
$data = [
    'title' => 'กิจกรรมของฉัน',
    'created_events' => $created_events,
    'joined_events' => $joined_events
];

renderView('my_event', $data);
