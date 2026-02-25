<?php
global $conn;

// 1. รับค่าจาก Session และ URL
$current_user_id = $_SESSION['user_id'] ?? 0;
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($current_user_id === 0 || $event_id === 0) {
    die("ข้อมูลไม่ถูกต้อง หรือคุณยังไม่ได้ Login");
}

// 2. ตรวจสอบว่าคนที่จะลบ เป็นเจ้าของกิจกรรมนี้จริงไหม
$sql_check = "SELECT creator_id FROM events WHERE event_id = $event_id";
$result = $conn->query($sql_check);
$event = $result->fetch_assoc();

if ($event && $event['creator_id'] == $current_user_id) {
    // 3. เริ่มกระบวนการลบ: ลบรูปภาพจริงในโฟลเดอร์ก่อน
    $sql_imgs = "SELECT img_path FROM event_img WHERE event_id = $event_id";
    $result_imgs = $conn->query($sql_imgs);
    while ($img = $result_imgs->fetch_assoc()) {
        $path = "public/uploads/" . $img['img_path']; // เช็ค path ให้ดีครับ
        if (file_exists($path)) {
            unlink($path);
        }
    }

    // 4. ลบข้อมูลในฐานข้อมูล
    $conn->query("DELETE FROM event_img WHERE event_id = $event_id");
    $conn->query("DELETE FROM events WHERE event_id = $event_id");

    echo "<script>alert('ลบกิจกรรมสำเร็จ!'); window.location.href='/';</script>";
} else {
    die("คุณไม่มีสิทธิ์ลบกิจกรรมนี้!");
}
