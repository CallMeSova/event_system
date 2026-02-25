<?php
global $conn;

$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'] ?? 0;

// 1. เช็คสิทธิ์: ต้องเป็นเจ้าของกิจกรรมเท่านั้น
$sql_check = "SELECT * FROM events WHERE event_id = $event_id AND creator_id = $user_id";
$result_check = $conn->query($sql_check);
$event = $result_check->fetch_assoc();

if (!$event) {
    die("ไม่พบกิจกรรมนี้ หรือคุณไม่มีสิทธิ์แก้ไข");
}

// 2. ถ้ามีการกด Submit (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name = $_POST['event_name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $max_people = $_POST['max_people'];

    if (strtotime($start_date) > strtotime($end_date)) {
        echo "<script>
            alert('ผิดพลาด: วันที่เริ่มกิจกรรมห้ามอยู่หลังวันที่สิ้นสุด!');
            window.history.back();
          </script>";
        exit;
    }

    // Update ข้อมูลพื้นฐาน
    $sql_update = "UPDATE events SET 
                    event_name = '$event_name', 
                    description = '$description', 
                    location = '$location', 
                    start_date = '$start_date', 
                    end_date = '$end_date', 
                    max_people = '$max_people' 
                  WHERE event_id = $event_id";

    if ($conn->query($sql_update)) {
        // จัดการรูปภาพใหม่ (ถ้ามีการอัปโหลดเพิ่ม)
        // เช็คว่ามีไฟล์ถูกเลือกมาจริงและไม่มี Error
        if (isset($_FILES['images']) && $_FILES['images']['error'][0] === 0) {
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $file_name = time() . "_" . $_FILES['images']['name'][$key];

                // 1. จุดที่ต้องแก้: Path ต้องถอยหลังออกจาก routes ไปหา public
                $target_path = "../public/uploads/" . $file_name;

                // 2. ตรวจสอบว่า move_uploaded_file ทำงานสำเร็จไหม
                if (move_uploaded_file($tmp_name, $target_path)) {
                    $sql_img = "INSERT INTO event_img (event_id, img_path) 
                           VALUES ('$event_id', '$file_name')";
                    $conn->query($sql_img);
                }
            }
        }
        echo "<script>alert('แก้ไขข้อมูลสำเร็จ!'); window.location.href='/event_detail?id=$event_id';</script>";
        exit;
    }
}

// 3. ดึงรูปภาพปัจจุบันมาโชว์ใน Form
$images = $conn->query("SELECT * FROM event_img WHERE event_id = $event_id");

renderView('edit_event', [
    'event' => $event,
    'images' => $images
]);
