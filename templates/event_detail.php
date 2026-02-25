<?php include 'head.php'; ?>
<?php global $conn; ?>

<div class="event-header">
    <h1>ชื่อกิจกรรม: <?php echo $event['event_name']; ?></h1>
    <p>สถานที่: <?php echo $event['location']; ?></p>
    <p>รับสมัคร: <?php echo $event['max_people']; ?> คน</p>
    <p>วันเริ่ม: <?php echo $event['start_date']; ?></p>
    <p>วันจบ: <?php echo $event['end_date']; ?></p>
    <p>รายละเอียด: <?php echo $event['description']; ?></p>
</div>

<h3>รูปภาพประกอบทั้งหมด (<?php echo count($images); ?> รูป):</h3>
<div style="display: flex; gap: 10px; flex-wrap: wrap;">
    <?php if (!empty($images)): ?>
        <?php foreach ($images as $img): ?>
            <img src="/uploads/<?php echo $img['img_path']; ?>" width="200" style="border-radius: 5px;">
        <?php endforeach; ?>
    <?php else: ?>
        <p>กิจกรรมนี้ไม่มีรูปภาพ</p>
    <?php endif; ?>
</div>

<hr>

<?php
// 3. ส่วนดึงสถานะการลงทะเบียน (ปรับ SQL ให้ดึง reg_id และ create_date มาด้วย)
$registration_status = null;
$reg_data = null;

if (isset($_SESSION['user_id'])) {
    $u_id = $_SESSION['user_id'];
    $e_id = $event['event_id'];

    // ดึงข้อมูลการสมัครที่จำเป็นสำหรับสร้าง OTP
    $reg_query = $conn->query("SELECT reg_id, reg_status, create_date FROM registrations WHERE event_id = $e_id AND user_id = $u_id");

    if ($reg_query && $reg_query->num_rows > 0) {
        $reg_data = $reg_query->fetch_assoc();
        $registration_status = $reg_data['reg_status'];
    }
}

// 4. ส่วนแสดงปุ่มและสถานะการสมัคร
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['creator_id']):
?>
    <div style="padding: 15px; background: #eef2ff; border-radius: 8px;">
        <p style="color: blue; font-weight: bold;">🌟 คุณคือผู้สร้างกิจกรรมนี้</p>
        <a href="/manage_registrations?id=<?php echo $event['event_id']; ?>" style="color: green;">[ดูรายชื่อคนสมัคร]</a>
        <a href="/edit_event?id=<?php echo $event['event_id']; ?>" style="color: orange; margin-left: 10px;">[แก้ไขกิจกรรม]</a>
        <a href="/delete_event?id=<?php echo $event['event_id']; ?>" onclick="return confirm('ยืนยันการลบ?')" style="color: red; margin-left: 10px;">[ลบกิจกรรม]</a>
    </div>

<?php else: ?>
    <div style="margin-top: 20px;">
        <?php if ($registration_status === 'pending'): ?>
            <button disabled style="background: #f1c40f; color: black; padding: 10px 20px; border: none; border-radius: 5px;">⏳ รอการอนุมัติจากผู้จัดงาน...</button>

        <?php elseif ($registration_status === 'approved'): ?>
            <button disabled style="background: #2ecc71; color: white; padding: 10px 20px; border: none; border-radius: 5px;">✅ คุณเข้าร่วมกิจกรรมแล้ว</button>

            <?php
            // ดึงฟังก์ชัน OTP ที่ Vigo ทำไว้ใน includes/otp.php
            // (ฟังก์ชันนี้จะทำงานได้เพราะมีการ require ไว้ใน index.php แล้ว)
            $otp_code = get_event_otp($reg_data['reg_id'], $reg_data['create_date']);
            ?>

            <div style="background: #eef2ff; border: 2px dashed #4f46e5; padding: 25px; text-align: center; border-radius: 10px; margin-top: 20px;">
                <p style="margin: 0; color: #4f46e5; font-weight: bold;">รหัส OTP สำหรับเช็คชื่อหน้างาน (6 หลัก)</p>
                <h1 style="font-size: 56px; letter-spacing: 12px; margin: 15px 0; color: #1e1b4b;">
                    <?php echo $otp_code; ?>
                </h1>
                <p style="color: #ef4444; font-weight: bold; margin-bottom: 0;">* รหัสจะเปลี่ยนอัตโนมัติทุก 30 นาที</p>
                <small>(กรุณาแสดงรหัสนี้แก่เจ้าหน้าที่เมื่อถึงหน้างาน)</small>
            </div>

        <?php elseif ($registration_status === 'rejected'): ?>
            <button disabled style="background: #e74c3c; color: white; padding: 10px 20px; border: none; border-radius: 5px;">❌ ขออภัย คำขอของคุณถูกปฏิเสธ</button>

        <?php elseif ($registration_status === 'attended'): ?>
            <div style="text-align: center;">
                <button disabled style="background: #3498db; color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: bold; width: 100%;">
                    🏁 คุณได้เข้าร่วมงานนี้เรียบร้อยแล้ว
                </button>

                <div style="margin-top: 15px; padding: 20px; background: #ebf8ff; border: 2px solid #3182ce; border-radius: 10px;">
                    <p style="color: #2c5282; font-weight: bold; margin: 0;">
                        ✨ ยืนยันตัวตนสำเร็จ! ขอบคุณที่เข้าร่วมกิจกรรม <br>
                        รหัส OTP ของคุณถูกยกเลิกการใช้งานแล้ว
                    </p>
                </div>
            </div>

        <?php else: ?>
            <a href="/register_event?id=<?php echo $event['event_id']; ?>">
                <button type="button" style="background: #3498db; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                    🎯 ขอเข้าร่วมกิจกรรม
                </button>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>