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
                    <span style="font-weight: bold; color: <?php
                                                            echo ($row['reg_status'] == 'approved') ? 'green' : (($row['reg_status'] == 'rejected') ? 'red' : 'orange');
                                                            ?>">
                        <?php echo strtoupper($row['reg_status']); ?>
                    </span>
                </td>
                <td>
                    <a href="/update_reg?reg_id=<?php echo $row['reg_id']; ?>&status=approved" style="color: green;">อนุมัติ</a> |
                    <a href="/update_reg?reg_id=<?php echo $row['reg_id']; ?>&status=rejected" style="color: red;" onclick="return confirm('ยืนยันการปฏิเสธ?')">ปฏิเสธ</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" style="text-align: center; padding: 20px;">ไม่พบข้อมูลผู้สมัครในสถานะนี้</td>
        </tr>
    <?php endif; ?>
</table>

<?php include 'footer.php'; ?>