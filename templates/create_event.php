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
            <input type="datetime-local" name="start_date" id="startDate" required>
        </div><br>

        <div>
            <label>วันที่สิ้นสุดงาน:</label><br>
            <input type="datetime-local" name="end_date" id="endDate" required disabled>
            <p id="date-error" style="color: red;"></p>
        </div><br>

        <div>
            <label>จำนวนคนสูงสุด:</label><br>
            <input type="number" name="max_people" min="1" required>
        </div><br>

        <div>
            <label>รูปภาพกิจกรรม (สูงสุด 5 รูป):</label><br>
            <input type="file" name="images[]" id="imageInput" accept="image/*" multiple>
            <button type="button" onclick="clearImages()">ล้างรูปภาพ</button>
            <div id="error-msg" style="color: red;"></div>
        </div><br>

        <button type="submit">ยืนยันการสร้างกิจกรรม</button>
    </form>
</section>

<script src="/js/create_event.js"></script>
<?php include 'footer.php'; ?>