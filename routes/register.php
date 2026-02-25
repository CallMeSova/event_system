<?php

global $conn;

//ถ้า Login อยู่แล้ว ห้ามเข้าหน้านี้
if (isset($_SESSION['user_id'])) {
    header("Location: /");
    exit;
}

$data = [
    'title' => 'สมัครสมาชิก'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $phone = $_POST['phone_number'];
    $role = 'user';

    $check_email = $conn->query("SELECT user_id FROM users WHERE email = '$email'");

    if ($check_email->num_rows > 0) {
        $data['error'] = "อีเมลนี้ถูกใช้งานแล้ว";
    } else {
        $sql = "INSERT INTO users (full_name, email, password, gender, birth_date, phone_number, role, created_at) 
                VALUES ('$full_name', '$email', '$password', '$gender', '$birth_date', '$phone', '$role', NOW())";

        if ($conn->query($sql)) {
            header("Location: /login");
            exit;
        } else {
            $data['error'] = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
        }
    }
}

renderView('register', $data);
