<?php
global $conn;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // รับค่า ID ของรูปที่ถูกติ๊กเลือกมาลบ
    if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
        foreach ($_POST['delete_images'] as $img_id) {

            // --- ขั้นตอนที่ 1: ดึงชื่อไฟล์มาเก็บไว้ก่อน (SELECT) ---
            $stmt_get = $conn->prepare("SELECT img_path FROM event_img WHERE img_id = ?");
            $stmt_get->bind_param("i", $img_id); // ใช้ bind_param แทนการต่อ string
            $stmt_get->execute();
            $result = $stmt_get->get_result();

            if ($img_data = $result->fetch_assoc()) {
                $file_path = "public/uploads/" . $img_data['img_path'];

                // --- ขั้นตอนที่ 2: ลบ Record ใน Database (DELETE) ---
                $stmt_del = $conn->prepare("DELETE FROM event_img WHERE img_id = ?");
                $stmt_del->bind_param("i", $img_id); // ใช้ bind_param ปลอดภัยที่สุด

                if ($stmt_del->execute()) {
                    // --- ขั้นตอนที่ 3: ถ้าลบใน DB สำเร็จ ค่อยสั่งลบไฟล์จริง ---
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                $stmt_del->close();
            }
            $stmt_get->close();
        }
    }
}

$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'] ?? 0;

// 1. เช็คสิทธิ์ด้วยฟังก์ชันที่แยกไว้
$event = getEventForEdit($event_id, $user_id);

if (!$event) {
    die("ไม่พบกิจกรรมนี้ หรือคุณไม่มีสิทธิ์แก้ไข");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name  = trim($_POST['event_name']);
    $description = $_POST['description'];
    $location    = $_POST['location'];
    $start_date  = $_POST['start_date'];
    $end_date    = $_POST['end_date'];
    $max_people  = intval($_POST['max_people']);

    // ตรวจสอบความถูกต้องของวันที่
    if (strtotime($start_date) > strtotime($end_date)) {
        echo "<script>alert('ผิดพลาด: วันที่เริ่มห้ามอยู่หลังวันที่สิ้นสุด!'); window.history.back();</script>";
        exit;
    }

    // 2. อัปเดตข้อมูลพื้นฐาน
    if (updateEvent($event_id, $event_name, $description, $location, $start_date, $end_date, $max_people)) {

        // 3. จัดการรูปภาพใหม่ (ถ้ามี)
        if (isset($_FILES['images']) && $_FILES['images']['error'][0] === 0) {
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $file_name = time() . "_" . $_FILES['images']['name'][$key];
                $target_path = dirname(__DIR__) . "/uploads/" . $file_name;

                if (move_uploaded_file($tmp_name, $target_path)) {
                    saveEventImage($event_id, $file_name); // ใช้ฟังก์ชันเดิมที่เราทำไว้ใน events.php
                }
            }
        }
        echo "<script>alert('แก้ไขข้อมูลสำเร็จ!'); window.location.href='/event_detail?id=$event_id';</script>";
        exit;
    }
}

// 4. ดึงรูปปัจจุบันมาโชว์
$images = getEventImages($event_id);

renderView('edit_event', [
    'event' => $event,
    'images' => $images
]);
