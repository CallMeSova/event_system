<?php include 'head.php'; ?>
<div class="search-section" style="margin: 20px; padding: 15px; background: #f9f9f9; border-radius: 8px;">
    <form action="/" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">

        <div>
            <label>ชื่อกิจกรรม:</label><br>
            <input type="text" name="search_name"
                value="<?php echo $_GET['search_name'] ?? ''; ?>"
                placeholder="ค้นหาชื่อกิจกรรม...">
        </div>

        <div>
            <label>ตั้งแต่วันที่:</label><br>
            <input type="date" name="start_date"
                value="<?php echo $_GET['start_date'] ?? ''; ?>">
        </div>

        <div>
            <label>ถึงวันที่:</label><br>
            <input type="date" name="end_date"
                value="<?php echo $_GET['end_date'] ?? ''; ?>">
        </div>

        <div style="align-self: flex-end;">
            <button type="submit" style="background: #3498db; color: white; padding: 8px 20px; border: none; border-radius: 4px; cursor: pointer;">
                🔍 ค้นหา
            </button>
            <a href="/" style="text-decoration: none; color: #666; font-size: 14px; margin-left: 10px;">ล้างค่า</a>
        </div>
    </form>
</div>

<section>

    <div class="flex grid grid-cols-4">
        <?php foreach ($events as $event): ?>

            <div class="max-h-[80%] w-[80%] flex flex-col items-center m-8 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="min-w-full aspect-[16/9] overflow-hidden">
                    <?php if (!empty($event['img_path'])): ?>
                        <img src="/uploads/<?php echo $event['img_path']; ?>"
                            class="w-full object-cover"
                            alt="<?php echo $event['event_name']; ?>">
                    <?php else: ?>
                        <img src="/uploads/no-image.png"
                            class="h-full w-full object-cover"
                            alt="ไม่พบรูปภาพกิจกรรม">
                    <?php endif; ?>
                </div>

                <div class="w-full pb-4">
                    <div class="text-lg font-bold ml-4"><?php echo $event['event_name']; ?></div>
                    <div class="ml-4 mb-2"><?php echo $event['location']; ?></div>
                    <a href="/event_detail?id=<?php echo $event['event_id']; ?>">
                        <div class="mx-4 p-1 text-center text-white bg-blue-500 rounded-lg">รายละเอียด</div>
                    </a>
                </div>
            </div>

        <?php endforeach; ?>
    </div>

</section>

<?php include 'footer.php'; ?>