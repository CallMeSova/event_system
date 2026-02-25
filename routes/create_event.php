<?php
global $conn;

// 1. ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อนทำรายการนี้'); window.history.back();</script>";
    exit;
}

$data = ['title' => 'สร้างกิจกรรมใหม่'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าจากฟอร์ม
    $event_name  = trim($_POST['event_name']);
    $creator_id  = $_SESSION['user_id'];
    $description = $_POST['description'];
    $location    = $_POST['location'];
    $start_date  = $_POST['start_date'];
    $end_date    = $_POST['end_date'];
    $max_people  = intval($_POST['max_people']);

    // 2. เรียกใช้ฟังก์ชันสร้างกิจกรรม
    $event_id = createEvent($event_name, $creator_id, $description, $location, $start_date, $end_date, $max_people);

    if ($event_id) {
        // 3. จัดการอัปโหลดรูปภาพ
        if (!empty($_FILES['images']['tmp_name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $file_name = time() . "_" . $_FILES['images']['name'][$key];
                $target_path = "../public/uploads/" . $file_name;

                if (move_uploaded_file($tmp_name, $target_path)) {
                    // บันทึกชื่อรูปลง DB ผ่านฟังก์ชันที่แยกไว้
                    saveEventImage($event_id, $file_name);
                }
            }
        }
        echo "<script>alert('สร้างกิจกรรมสำเร็จแล้ว!'); window.location.href = '/';</script>";
        exit;
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการสร้างกิจกรรม'); window.history.back();</script>";
    }
}

renderView('create_event', $data);
