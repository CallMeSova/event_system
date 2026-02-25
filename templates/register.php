<?php include 'head.php'; ?>
<h1><?php echo $title; ?></h1>

<section>
    <?php if (isset($error)) {
        echo $error;
    } ?>

    <form action="" method="POST">
        <div>
            <label>ชื่อ-นามสกุล:</label><br>
            <input type="text" name="full_name" required>
        </div><br>

        <div>
            <label>อีเมล:</label><br>
            <input type="email" name="email" required>
        </div><br>

        <div>
            <label>รหัสผ่าน:</label><br>
            <input type="password" name="password" required>
        </div><br>

        <div>
            <label>เพศ:</label><br>
            <select name="gender" required>
                <option value="">-- เลือกเพศ --</option>
                <option value="Male">ชาย</option>
                <option value="Female">หญิง</option>
                <option value="Other">อื่นๆ</option>
            </select>
        </div><br>

        <div>
            <label>วันเกิด:</label><br>
            <input type="date" name="birth_date" required>
        </div><br>

        <div>
            <label>เบอร์โทรศัพท์:</label><br>
            <input type="tel" name="phone_number" required>
        </div><br>

        <button type="submit">ลงทะเบียน</button>
    </form>

    <p>มีบัญชีอยู่แล้ว? <a href="/login">เข้าสู่ระบบ</a></p>
</section>

<?php include 'footer.php'; ?>