<?php
$data = ['title' => 'สมัครสมาชิก'];

// ตรวจสอบว่ามีการส่งข้อมูลแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. รับค่าจากฟอร์ม
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัสผ่านเพื่อความปลอดภัย
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $phone = $_POST['phone_number'];
    $role = 'user'; // กำหนดค่าเริ่มต้นเป็นผู้ใช้งานทั่วไป

    // 2. ตรวจสอบอีเมลซ้ำ (ตัวอย่างการใช้ $conn จาก database.php)
    $check_email = $conn->query("SELECT user_id FROM users WHERE email = '$email'");

    if ($check_email->num_rows > 0) {
        $data['error'] = "อีเมลนี้ถูกใช้งานแล้ว";
    } else {
        // 3. บันทึกข้อมูลลงตาราง users
        $sql = "INSERT INTO users (full_name, email, password, gender, birth_date, phone_number, role, create_date) 
                VALUES ('$full_name', '$email', '$password', '$gender', '$birth_date', '$phone', '$role', NOW())";

        if ($conn->query($sql)) {
            header("Location: /login?success=registered"); // สมัครเสร็จแล้วส่งไปหน้า Login
            exit;
        } else {
            $data['error'] = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
        }
    }
}

// แสดงหน้าฟอร์มสมัครสมาชิก
renderView('register', $data);
