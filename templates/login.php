<?php include 'head.php'; ?>
<h1><?php echo $title; ?></h1>

<section>
    <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['success'])) : ?>
        <p style="color: green;">สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ</p>
    <?php endif; ?>

    <form action="" method="POST">
        <div>
            <label>อีเมล:</label><br>
            <input type="email" name="email" required>
        </div><br>

        <div>
            <label>รหัสผ่าน:</label><br>
            <input type="password" name="password" required>
        </div><br>

        <button type="submit">เข้าสู่ระบบ</button>
    </form>

    <p>ยังไม่มีบัญชี? <a href="/register">สมัครสมาชิกที่นี่</a></p>
</section>

<?php include 'footer.php'; ?>