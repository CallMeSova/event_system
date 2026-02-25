<?php include 'head.php'; ?>

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