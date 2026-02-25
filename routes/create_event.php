<?php
global $conn;

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('กรุณาเข้าสู่ระบบก่อนทำรายการนี้');
            window.history.back();
        </script>";
    exit;
}

$data = [
    'title' => 'สร้างกิจกรรมใหม่',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name = $_POST['event_name'];
    $creator_id = $_SESSION['user_id'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $max_people = $_POST['max_people'];

    $sql = "INSERT INTO events (event_name, creator_id, description, location, start_date, end_date, max_people, status) 
            VALUES ('$event_name', '$creator_id', '$description', '$location', '$start_date', '$end_date', '$max_people', 'open')";

    if ($conn->query($sql)) {
        $event_id = $conn->insert_id;

        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = time() . "_" . $_FILES['images']['name'][$key];
            $target_path = "../public/uploads/" . $file_name;

            if (move_uploaded_file($tmp_name, $target_path)) {
                $sql_img = "INSERT INTO event_img (event_id, img_path) 
                        VALUES ('$event_id', '$file_name')";
                $conn->query($sql_img);
            }
        }
    }

    echo "<script>
            alert('สร้างกิจกรรมสำเร็จแล้ว!');
            window.location.href = '/';
        </script>";
    exit;
}

renderView('create_event', $data);
