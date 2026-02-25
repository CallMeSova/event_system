<?php
global $conn;

// 1. ถ้า Login อยู่แล้ว ห้ามเข้าหน้านี้
if (isset($_SESSION['user_id'])) {
    header("Location: /");
    exit;
}

$data = ['title' => 'เข้าสู่ระบบ'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 2. เรียกใช้ฟังก์ชันจาก databases/users.php
    $user = getUserByEmail($email);

    if ($user) {
        // 3. ตรวจสอบรหัสผ่าน
        if (password_verify($password, $user['password'])) {
            // เก็บข้อมูลลง Session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            header("Location: /");
            exit;
        } else {
            $data['error'] = "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $data['error'] = "ไม่พบอีเมลนี้ในระบบ";
    }
}

renderView('login', $data);
