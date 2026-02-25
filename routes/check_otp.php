<?php
global $conn;
// ไม่ต้อง include otp.php ซ้ำ เพราะ require ไว้ใน index.php แล้ว

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = intval($_POST['event_id']);
    $input_otp = $_POST['input_otp']; // เลขที่ Admin กรอกมา

    // 1. ดึงข้อมูลทุกคนที่ถูก 'approved' ในกิจกรรมนี้มาเช็ค
    $sql = "SELECT reg_id, create_date FROM registrations 
            WHERE event_id = $event_id AND reg_status = 'approved'";
    $result = $conn->query($sql);

    $found_match = false;

    while ($row = $result->fetch_assoc()) {
        // 2. ใช้ Algorithm ตัวเดียวกับหน้าบ้านคำนวณหา OTP ของคนๆ นี้ ณ ตอนนี้
        $calculated_otp = get_event_otp($row['reg_id'], $row['create_date']);

        if ($input_otp === $calculated_otp) {
            $target_reg_id = $row['reg_id'];
            // 3. ถ้าตรงกัน ให้เปลี่ยนสถานะเป็น 'attended' (เข้าร่วมงานแล้ว)
            $conn->query("UPDATE registrations SET reg_status = 'attended' WHERE reg_id = $target_reg_id");
            $found_match = true;
            break;
        }
    }

    if ($found_match) {
        echo "<script>alert('✅ รหัสถูกต้อง! ยืนยันการเข้างานสำเร็จ'); window.location.href='/manage_registrations?id=$event_id';</script>";
    } else {
        echo "<script>alert('❌ รหัสไม่ถูกต้อง หรืออาจจะหมดอายุแล้ว (เกิน 30 นาที)'); window.history.back();</script>";
    }
    exit;
}
