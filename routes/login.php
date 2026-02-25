<?php
global $conn;

//ถ้า Login อยู่แล้ว ห้ามเข้าหน้านี้
if (isset($_SESSION['user_id'])) {
    header("Location: /");
    exit;
}

$data = [
    'title' => 'เข้าสู่ระบบ'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
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
