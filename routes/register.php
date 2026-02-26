<?php
global $conn;

// ถ้า Login อยู่แล้ว ให้ดีดกลับหน้าแรก
if (isset($_SESSION['user_id'])) {
    header("Location: /");
    exit;
}

$data = ['title' => 'สมัครสมาชิก'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name        = trim($_POST['full_name']);
    $email            = trim($_POST['email']);
    $raw_password     = $_POST['password'];         // รหัสผ่านดิบ
    $confirm_password = $_POST['confirm_password']; // ยืนยันรหัสผ่าน
    $gender           = $_POST['gender'];
    $birth_date       = $_POST['birth_date'];
    $phone            = $_POST['phone_number'];

    // 1. เช็คว่ารหัสผ่านทั้งสองช่องตรงกันหรือไม่
    if ($raw_password !== $confirm_password) {
        $data['error'] = "รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง";
    }
    // 2. เช็คว่าอีเมลนี้ถูกใช้งานไปหรือยัง
    elseif (isEmailExists($email)) {
        $data['error'] = "อีเมลนี้ถูกใช้งานแล้ว";
    } else {
        // 3. เมื่อข้อมูลถูกต้องค่อยทำการ Hash รหัสผ่าน
        $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

        // 4. เรียกใช้ฟังก์ชันสร้าง User จากไฟล์ databases/users.php
        if (createUser($full_name, $email, $hashed_password, $gender, $birth_date, $phone)) {
            header("Location: /login");
            exit;
        } else {
            $data['error'] = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
        }
    }
}

renderView('register', $data);
