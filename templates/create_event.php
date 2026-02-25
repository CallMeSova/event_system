<?php include 'head.php'; ?>
<h1>สร้างกิจกรรมใหม่</h1>

<section>
    <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <label>ชื่อกิจกรรม:</label><br>
            <input type="text" name="event_name" required>
        </div><br>

        <div>
            <label>รายละเอียด:</label><br>
            <textarea name="description"></textarea>
        </div><br>

        <div>
            <label>สถานที่:</label><br>
            <input type="text" name="location" required>
        </div><br>

        <div>
            <label>วันที่เริ่มงาน:</label><br>
            <input type="datetime-local" name="start_date" required>
        </div><br>

        <div>
            <label>วันที่สิ้นสุดงาน:</label><br>
            <input type="datetime-local" name="end_date" required>
        </div><br>

        <div>
            <label>จำนวนคนสูงสุด:</label><br>
            <input type="number" name="max_people" min="1" required>
        </div><br>

        <div>
            <label>รูปภาพกิจกรรม:</label><br>
            <input type="file" name="image" accept="image/*">
        </div><br>

        <button type="submit">ยืนยันการสร้างกิจกรรม</button>
    </form>
</section>

<?php include 'footer.php'; ?>