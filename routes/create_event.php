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

        if (!empty($_FILES['image']['name'])) {
            $file_name = time() . "_" . $_FILES['image']['name'];
            $target_path = "public/uploads/" . $file_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $conn->query("INSERT INTO event_img (event_id, img_path) VALUES ('$event_id', '$file_name')");
            }
        }

        header("Location: /?success=event_created");
        exit;
    }
}

renderView('create_event', $data);
