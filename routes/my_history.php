<?php
global $conn;
$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id === 0) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อน'); window.location.href='/login';</script>";
    exit;
}

// JOIN กับตาราง events เพื่อเอาชื่อกิจกรรมมาโชว์
$sql = "SELECT r.reg_status, r.create_date as reg_date, e.event_name, e.event_id, e.start_date 
        FROM registrations r 
        JOIN events e ON r.event_id = e.event_id 
        WHERE r.user_id = $user_id 
        ORDER BY r.create_date DESC"; // ตาราง registrations มี create_date

$my_history = $conn->query($sql);
renderView('my_history', ['my_history' => $my_history]);
