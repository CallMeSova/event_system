<?php include 'head.php'; ?>

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
// 1. เช็คว่า Login หรือยัง และเป็นเจ้าของกิจกรรมไหม
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['creator_id']):
?>
    <p style="color: blue; font-weight: bold;">คุณคือผู้สร้างกิจกรรมนี้</p>
    <a href="/edit_event?id=<?php echo $event['event_id']; ?>" style="color: orange;">[แก้ไขกิจกรรม]</a>
    <a href="/delete_event?id=<?php echo $event['event_id']; ?>"
        onclick="return confirm('ยืนยันการลบ?')"
        style="color: red; margin-left: 10px;">[ลบกิจกรรม]</a>

<?php else: ?>
    <button type="button">ปุ่มเข้าร่วมกิจกรรม</button>
<?php endif; ?>

<?php include 'footer.php'; ?>