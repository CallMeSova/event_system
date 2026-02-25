<?php
global $conn;

if (isset($_SESSION['user_id'])) {
    header("Location: /");
    exit;
}

$data = ['title' => 'สมัครสมาชิก'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name  = trim($_POST['full_name']);
    $email      = trim($_POST['email']);
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender     = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $phone      = $_POST['phone_number'];

    // 1. เรียกใช้ฟังก์ชันจากไฟล์ databases/users.php
    if (isEmailExists($email)) {
        $data['error'] = "อีเมลนี้ถูกใช้งานแล้ว";
    } else {
        // 2. เรียกใช้ฟังก์ชันสร้าง User
        if (createUser($full_name, $email, $password, $gender, $birth_date, $phone)) {
            header("Location: /login");
            exit;
        } else {
            $data['error'] = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
        }
    }
}

renderView('register', $data);
