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

<button type="button">ปุ่มเข้าร่วมกิจกรรม</button>

<?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['creator_id']): ?>
    <a href="/delete_event?id=<?php echo $event['event_id']; ?>"
        onclick="return confirm('คุณแน่ใจนะว่าจะลบกิจกรรมนี้?')"
        style="color: red; font-weight: bold;">
        [ลบกิจกรรมนี้]
    </a>
<?php endif; ?>

<?php include 'footer.php'; ?>