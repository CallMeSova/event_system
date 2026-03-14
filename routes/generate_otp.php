<?php
// routes/generate_otp.php
$reg_id = intval($_GET['reg_id']);
$event_id = intval($_GET['event_id']);

if (generateNewOTP($reg_id)) {
    header("Location: /event_detail?id=$event_id");
} else {
    echo "<script>alert('เกิดข้อผิดพลาด'); window.history.back();</script>";
}
exit;
