<?php include 'head.php'; ?>

<h1>แก้ไขกิจกรรม: <?php echo $event['event_name']; ?></h1>
<form action="" method="POST" enctype="multipart/form-data">
    <label>ชื่อกิจกรรม:</label><br>
    <input type="text" name="event_name" value="<?php echo $event['event_name']; ?>" required><br><br>

    <label>สถานที่:</label><br>
    <input type="text" name="location" value="<?php echo $event['location']; ?>"><br><br>

    <label>จำนวนคนสูงสุด:</label><br>
    <input type="number" name="max_people" value="<?php echo $event['max_people']; ?>"><br><br>

    <label>รายละเอียด:</label><br>
    <textarea name="description"><?php echo $event['description']; ?></textarea><br><br>

    <label>วันที่เริ่ม - จบ:</label><br>
    <input type="datetime-local" id="start_date" name="start_date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['start_date'])); ?>">
    <input type="datetime-local" id="end_date" name="end_date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['end_date'])); ?>"><br><br>

    <h3>รูปภาพปัจจุบัน:</h3>
    <div>
        <?php while ($img = $images->fetch_assoc()): ?>
            <img src="/uploads/<?php echo $img['img_path']; ?>" width="100">
        <?php endwhile; ?>
    </div><br>

    <label>เพิ่มรูปภาพใหม่:</label><br>
    <input type="file" name="images[]" multiple><br><br>

    <button type="submit" style="background: orange; color: white; padding: 10px;">บันทึกการแก้ไข</button>
    <a href="/event_detail?id=<?php echo $event['event_id']; ?>">ยกเลิก</a>
</form>

<script src="/js/edit_event.js"></script>

<?php include 'footer.php'; ?>