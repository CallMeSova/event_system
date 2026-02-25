<?php

// ฟังก์ชันนับจำนวนคนที่มีสถานะ approved หรือ attended ในกิจกรรมนั้นๆ
function getApprovedCount($event_id) {
    global $conn;
    // นับเฉพาะคนที่อนุมัติแล้ว หรือเข้างานแล้ว
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM registrations WHERE event_id = ? AND reg_status IN ('approved', 'attended')");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['total'];
}
