<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
</head>

<body>
    <header>
        <h1>WebSite Name</h1>
    </header>
    <nav>
        <a href="/">หน้าแรก</a>
        <a href="/create_event">สร้างกิจกรรม</a>

        <?php if (isset($_SESSION['user_id'])) : ?>
            <span>สวัสดีคุณ <?php echo $_SESSION['full_name']; ?></span>
            <a href="/logout">ออกจากระบบ</a>
        <?php else : ?>
            <a href="/login">เข้าสู่ระบบ</a>
            <a href="/register">สมัครสมาชิก</a>
        <?php endif; ?>

    </nav>