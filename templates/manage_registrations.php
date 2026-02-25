<?php include 'head.php'; ?>
<h1>จัดการผู้สมัครกิจกรรม</h1>
<a href="/event_detail?id=<?php echo $event_id; ?>">← กลับ</a>
<hr>

<table border="1" style="width:100%; border-collapse: collapse;">
    <tr style="background: #f0f0f0;">
        <th>ชื่อ-นามสกุล</th>
        <th>อีเมล / เบอร์โทร</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
    </tr>
    <?php while ($row = $registrations->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['email']; ?> / <?php echo $row['phone_number']; ?></td>
            <td><strong><?php echo $row['reg_status']; ?></strong></td>
            <td>
                <a href="/update_reg?reg_id=<?php echo $row['reg_id']; ?>&status=approved" style="color: green;">อนุมัติ</a> |
                <a href="/update_reg?reg_id=<?php echo $row['reg_id']; ?>&status=rejected" style="color: red;">ปฏิเสธ</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<?php include 'footer.php'; ?>