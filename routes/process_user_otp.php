<?php

/**
 * ไฟล์ประมวลผลการเช็ค OTP จากฝั่งเจ้าของงาน
 */
global $conn;

// 1. ตรวจสอบว่าเป็นการส่งค่าแบบ POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าและทำความสะอาดข้อมูล
    $reg_id = isset($_POST['reg_id']) ? intval($_POST['reg_id']) : 0;
    $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;
    $input_otp = isset($_POST['input_otp']) ? trim($_POST['input_otp']) : '';

    // 2. ตรวจสอบเบื้องต้นว่าค่าไม่ว่าง
    if (empty($input_otp)) {
        echo "<script>alert('กรุณากรอกรหัส OTP'); window.history.back();</script>";
        exit;
    }

    // 3. เรียกใช้ฟังก์ชันตรวจสอบ OTP จาก Model (registrations.php)
    // ฟังก์ชันนี้จะเช็คว่า reg_id ตรงกับ otp_code และสถานะต้องเป็น 'approved'
    if (verifyUserOTP($reg_id, $input_otp)) {

        // 4. ถ้ารหัสถูกต้อง -> อัปเดตสถานะเป็น 'attended' และล้าง OTP
        if (markAsAttended($reg_id)) {
            echo "<script>
                    alert('✅ ยืนยันการเข้างานสำเร็จ! เช็คชื่อเรียบร้อยครับ');
                    window.location.href = '/manage_registrations?id=$event_id';
                  </script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตสถานะ'); window.history.back();</script>";
        }
    } else {
        // 5. ถ้ารหัสผิด
        echo "<script>
                alert('❌ รหัส OTP ไม่ถูกต้อง หรือรหัสพัง (หมดอายุ) ไปแล้ว ลองให้ User รีเฟรชหน้าจอใหม่นะ');
                window.history.back();
              </script>";
    }
    exit;
} else {
    // ถ้าพยายามเข้าถึงไฟล์นี้ตรงๆ โดยไม่ผ่าน Form
    header("Location: /");
    exit;
}
