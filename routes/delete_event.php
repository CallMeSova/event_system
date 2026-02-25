<?php
global $conn;

$current_user_id = $_SESSION['user_id'] ?? 0;
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($current_user_id === 0 || $event_id === 0) {
    die("ข้อมูลไม่ถูกต้อง");
}

// 1. เช็คสิทธิ์เจ้าของกิจกรรมก่อนลบ
$sql_check = "SELECT creator_id FROM events WHERE event_id = $event_id";
$result = $conn->query($sql_check);
$event = $result->fetch_assoc();

if ($event && $event['creator_id'] == $current_user_id) {

    // 2. ลบข้อมูลคนสมัคร (Registrations) ออกก่อน
    $conn->query("DELETE FROM registrations WHERE event_id = $event_id");

    // 3. ลบรูปภาพจริงในโฟลเดอร์ และข้อมูลในตาราง event_img
    $sql_imgs = "SELECT img_path FROM event_img WHERE event_id = $event_id";
    $result_imgs = $conn->query($sql_imgs);
    while ($img = $result_imgs->fetch_assoc()) {
        $path = "public/uploads/" . $img['img_path'];
        if (file_exists($path)) {
            unlink($path);
        }
    }
    $conn->query("DELETE FROM event_img WHERE event_id = $event_id");

    // 4. สุดท้าย ลบตัวกิจกรรมหลัก
    $conn->query("DELETE FROM events WHERE event_id = $event_id");

    echo "<script>alert('ลบกิจกรรมและข้อมูลที่เกี่ยวข้องทั้งหมดเรียบร้อยแล้ว'); window.location.href='/';</script>";
} else {
    die("คุณไม่มีสิทธิ์ลบกิจกรรมนี้!");
}
