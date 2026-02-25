<?php include 'head.php'; ?>

<?php global $conn; ?>

<h1>ชื่อกิจกรรม: <?php echo $event['event_name']; ?></h1>
<p>สถานที่: <?php echo $event['location']; ?></p>
<p>รับสมัคร: <?php echo $event['max_people']; ?> คน</p>
<p>วันเริ่ม: <?php echo $event['start_date']; ?></p>
<p>วันจบ: <?php echo $event['end_date']; ?></p>
<p>รายละเอียด: <?php echo $event['description']; ?></p>

<h3>รูปภาพประกอบทั้งหมด (<?php echo count($images); ?> รูป):</h3>
<div>
    <?php if (!empty($images)): ?>
        <?php foreach ($images as $img): ?>
            <div>
                <img src="/uploads/<?php echo $img['img_path']; ?>" width="200">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>กิจกรรมนี้ไม่มีรูปภาพ</p>
    <?php endif; ?>
</div>

<?php
// --- ส่วนที่เพิ่มใหม่ 1: ดึงสถานะการลงทะเบียนจาก Database ---
$registration_status = null;
if (isset($_SESSION['user_id'])) {
    $u_id = $_SESSION['user_id'];
    $e_id = $event['event_id'];
    // เช็คในตาราง registrations
    $reg_query = $conn->query("SELECT reg_status FROM registrations WHERE event_id = $e_id AND user_id = $u_id");
    if ($reg_query->num_rows > 0) {
        $reg_data = $reg_query->fetch_assoc();
        $registration_status = $reg_data['reg_status'];
    }
}
// -------------------------------------------------------------

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['creator_id']):
?>
    <p style="color: blue; font-weight: bold;">คุณคือผู้สร้างกิจกรรมนี้</p>
    <a href="/manage_registrations?id=<?php echo $event['event_id']; ?>" style="color: green;">[ดูรายชื่อคนสมัคร]</a>
    <a href="/edit_event?id=<?php echo $event['event_id']; ?>" style="color: orange; margin-left: 10px;">[แก้ไขกิจกรรม]</a>
    <a href="/delete_event?id=<?php echo $event['event_id']; ?>"
        onclick="return confirm('ยืนยันการลบ?')"
        style="color: red; margin-left: 10px;">[ลบกิจกรรม]</a>

<?php else: ?>
    <?php if ($registration_status === 'pending'): ?>
        <button disabled style="background: #f1c40f; color: black;">⏳ รอการอนุมัติ...</button>

    <?php elseif ($registration_status === 'approved'): ?>
        <button disabled style="background: #2ecc71; color: white;">✅ คุณเข้าร่วมกิจกรรมแล้ว</button>

    <?php elseif ($registration_status === 'rejected'): ?>
        <button disabled style="background: #e74c3c; color: white;">❌ คำขอของคุณถูกปฏิเสธ</button>

    <?php else: ?>
        <a href="/register_event?id=<?php echo $event['event_id']; ?>">
            <button type="button" style="background: #3498db; color: white; cursor: pointer;">
                ขอเข้าร่วมกิจกรรม
            </button>
        </a>
    <?php endif; ?>
<?php endif; ?>

<?php include 'footer.php'; ?>