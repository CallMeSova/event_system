<?php include 'head.php'; ?>
<h1>จัดการผู้สมัครกิจกรรม</h1>
<a href="/event_detail?id=<?php echo $event_id; ?>">← กลับ</a>
<hr>

<div style="margin: 15px 0;">
    <form action="/manage_registrations" method="GET">
        <input type="hidden" name="id" value="<?php echo $event_id; ?>">

        <label>กรองสถานะ: </label>
        <select name="filter_status" onchange="this.form.submit()" style="padding: 5px;">
            <option value="">-- ทั้งหมด --</option>
            <option value="pending" <?php echo ($current_filter == 'pending') ? 'selected' : ''; ?>>⏳ รอการอนุมัติ (PENDING)</option>
            <option value="approved" <?php echo ($current_filter == 'approved') ? 'selected' : ''; ?>>✅ อนุมัติแล้ว (APPROVED)</option>
            <option value="rejected" <?php echo ($current_filter == 'rejected') ? 'selected' : ''; ?>>❌ ปฏิเสธแล้ว (REJECTED)</option>
            <option value="attended" <?php echo ($current_filter == 'attended') ? 'selected' : ''; ?>>🏃 เข้าร่วมงานแล้ว (ATTENDED)</option>
        </select>

        <?php if (!empty($current_filter)): ?>
            <a href="/manage_registrations?id=<?php echo $event_id; ?>" style="margin-left: 10px; font-size: 13px; color: #666;">ล้างการกรอง</a>
        <?php endif; ?>
    </form>
</div>

<table border="1" style="width:100%; border-collapse: collapse;">
    <tr style="background: #f0f0f0;">
        <th>ชื่อ-นามสกุล</th>
        <th>อีเมล / เบอร์โทร</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
    </tr>
    <?php if ($registrations->num_rows > 0): ?>
        <?php while ($row = $registrations->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['email']; ?> / <?php echo $row['phone_number']; ?></td>
                <td>
                    <span style="font-weight: bold; color: 
                    <?php
                    if ($row['reg_status'] == 'pending') {
                        echo 'orange';
                    } else if ($row['reg_status'] == 'approved') {
                        echo 'green';
                    } else if ($row['reg_status'] == 'rejected') {
                        echo 'red';
                    } else {
                        echo 'blue';
                    }
                    ?>">
                        <?php echo strtoupper($row['reg_status']); ?>
                    </span>
                </td>
                <td>
                    <?php if ($row['reg_status'] === 'attended'): ?>
                        <span style="color: #666; font-style: italic;">บันทึกสำเร็จแล้ว</span>
                    <?php else: ?>
                        <a href="/update_reg?reg_id=<?php echo $row['reg_id']; ?>&status=approved" style="color: green;">อนุมัติ</a> |
                        <a href="/update_reg?reg_id=<?php echo $row['reg_id']; ?>&status=rejected" style="color: red;" onclick="return confirm('ยืนยันการปฏิเสธ?')">ปฏิเสธ</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" style="text-align: center; padding: 20px;">ไม่พบข้อมูลผู้สมัครในสถานะนี้</td>
        </tr>
    <?php endif; ?>
</table>

<div style="background: #fdf2e9; padding: 20px; border-radius: 10px; border: 2px solid #e67e22; margin-bottom: 25px;">
    <h3 style="margin-top: 0; color: #d35400;">🔎 ตรวจสอบรหัส OTP (เช็คชื่อหน้างาน)</h3>
    <form action="/check_otp" method="POST" style="display: flex; gap: 10px; align-items: center;">
        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">

        <input type="text" name="input_otp" placeholder="กรอกเลข 6 หลัก"
            maxlength="6" required
            style="font-size: 20px; padding: 10px; width: 200px; text-align: center; letter-spacing: 5px;">

        <button type="submit" style="background: #e67e22; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
            ยืนยันการเข้างาน
        </button>
    </form>
    <p style="font-size: 13px; color: #666; margin-top: 10px;">* ระบบจะคำนวณรหัสปัจจุบันเพื่อตรวจสอบโดยอัตโนมัติ</p>
</div>

<?php include 'footer.php'; ?>