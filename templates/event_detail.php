<?php include 'head.php'; ?>

<div class="event-header">
    <h1 class="text-2xl font-bold">ชื่อกิจกรรม: <?php echo $event['event_name']; ?></h1>
    <p>ผู้จัดงาน: <?php echo $event['creator_name'] ?? 'ไม่ระบุ'; ?></p>
    <p>สถานที่: <?php echo $event['location']; ?></p>
    <p>รับสมัคร: <?php echo $event['max_people']; ?> คน</p>
    <p>รายละเอียด: <?php echo $event['description']; ?></p>
</div>

<h3 class="mt-4 font-bold">รูปภาพประกอบ (<?php echo count($images); ?>):</h3>
<div class="flex gap-3 flex-wrap mt-2">
    <?php if (!empty($images)): ?>
        <?php foreach ($images as $img): ?>
            <img src="/uploads/<?php echo $img['img_path']; ?>" width="200" class="rounded shadow-sm">
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-gray-400">กิจกรรมนี้ไม่มีรูปภาพ</p>
    <?php endif; ?>
</div>

<hr class="my-6">

<?php
// ดึงสถานะจากตัวแปรที่ Route ส่งมาให้
$status = $reg_data['reg_status'] ?? null;

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['creator_id']):
?>
    <div class="p-4 bg-blue-50 border rounded-lg">
        <p class="text-blue-700 font-bold mb-2">🌟 คุณคือผู้สร้างกิจกรรมนี้</p>
        <div class="flex gap-4">
            <a href="/manage_registrations?id=<?php echo $event['event_id']; ?>" class="text-green-600 font-bold">จัดการผู้สมัคร</a>
            <a href="/edit_event?id=<?php echo $event['event_id']; ?>" class="text-orange-500 font-bold">แก้ไข</a>
            <a href="/delete_event?id=<?php echo $event['event_id']; ?>" class="text-red-600 font-bold" onclick="return confirm('ลบกิจกรรม?')">ลบกิจกรรม</a>
        </div>
    </div>

<?php else: ?>
    <div class="mt-4">
        <?php if ($status === 'pending'): ?>
            <button disabled class="bg-yellow-400 px-6 py-2 rounded font-bold">⏳ รอการอนุมัติ...</button>

        <?php elseif ($status === 'approved'): ?>
            <button disabled class="bg-green-500 text-white px-6 py-2 rounded font-bold mb-4">✅ อนุมัติแล้ว</button>
            <?php $otp = get_event_otp($reg_data['reg_id'], $reg_data['create_date']); ?>
            <div class="bg-indigo-50 border-2 border-dashed border-indigo-500 p-8 text-center rounded-xl shadow-inner">
                <p class="text-indigo-600 font-bold">รหัส OTP สำหรับเช็คชื่อ (6 หลัก)</p>
                <h1 class="text-6xl font-mono tracking-widest my-4"><?php echo $otp; ?></h1>
                <p class="text-red-500 text-xs font-semibold">* รหัสจะรีเฟรชใหม่ทุก 30 นาที</p>
            </div>

        <?php elseif ($status === 'rejected'): ?>
            <button disabled class="bg-red-500 text-white px-6 py-2 rounded font-bold">❌ คำขอถูกปฏิเสธ</button>

        <?php elseif ($status === 'attended'): ?>
            <button disabled class="bg-blue-600 text-white px-8 py-4 rounded-xl text-xl font-bold w-full">🏁 เข้าร่วมงานสำเร็จ</button>

        <?php elseif ($is_full): ?>
            <button disabled class="bg-gray-400 text-white px-6 py-3 rounded-md w-full font-bold">
                🚫 เต็มแล้ว (<?php echo $current_count; ?>/<?php echo $event['max_people']; ?>)
            </button>

        <?php else: ?>
            <a href="/register_event?id=<?php echo $event['event_id']; ?>">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-md font-bold transition-all">
                    🎯 ขอเข้าร่วมกิจกรรม (ว่าง: <?php echo $event['max_people'] - $current_count; ?> ที่)
                </button>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>