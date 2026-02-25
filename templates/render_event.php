<?php global $conn; ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php foreach ($events as $event):
        // 1. นับจำนวนคนที่ได้อนุมัติ (approved) หรือเข้างานแล้ว (attended) สำหรับกิจกรรมนี้
        $e_id = $event['event_id'];
        $count_res = $conn->query("SELECT COUNT(*) as total FROM registrations WHERE event_id = $e_id AND reg_status IN ('approved', 'attended')");
        $current_reg = $count_res->fetch_assoc()['total'];

        // 2. เช็คว่าเต็มหรือยังเพื่อเตรียมแสดงสี
        $is_full = ($current_reg >= $event['max_people']);
        $status_color = $is_full ? 'text-red-600' : 'text-green-600';
    ?>
        <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden transition-transform hover:scale-105">
            <div class="aspect-[16/9] overflow-hidden relative">

                <?php if (!empty($event['img_path'])): ?>
                    <img src="/uploads/<?php echo $event['img_path']; ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <img src="/uploads/no-image.png" class="w-full h-full object-cover">
                <?php endif; ?>
            </div>

            <div class="p-4 flex flex-col flex-grow">
                <h2 class="text-lg font-bold text-gray-800 line-clamp-1"><?php echo $event['event_name']; ?></h2>
                <p class="text-sm text-gray-600 mb-2"><i class="fas fa-map-marker-alt mr-1"></i> <?php echo $event['location']; ?></p>

                <p class="text-xs mb-3 <?php echo $status_color; ?> font-bold">
                    <?php echo $is_full ? '❌ เต็มแล้ว' : '✅ ว่าง: ' . ($event['max_people'] - $current_reg) . ' ที่'; ?>
                </p>

                <div class="mt-auto border-t pt-3 mb-4">
                    <div class="flex items-center text-xs text-blue-700 font-semibold mb-1">
                        <span class="w-16">เริ่ม:</span>
                        <span><?php echo date('d/m/Y H:i', strtotime($event['start_date'])); ?></span>
                    </div>
                    <div class="flex items-center text-xs text-red-600 font-semibold">
                        <span class="w-16">สิ้นสุด:</span>
                        <span><?php echo date('d/m/Y H:i', strtotime($event['end_date'])); ?></span>
                    </div>
                </div>

                <a href="/event_detail?id=<?php echo $event['event_id']; ?>" class="block w-full">
                    <div class="py-2 text-center text-white <?php echo $is_full ? 'bg-gray-500' : 'bg-blue-600 hover:bg-blue-700'; ?> rounded-lg transition-colors font-medium">
                        <?php echo $is_full ? 'ดูรายละเอียด' : 'สมัครเลย'; ?>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>