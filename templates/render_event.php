<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <?php foreach ($events as $event):
        $current_reg = getConfirmedCount($event['event_id']);
        $is_full = ($current_reg >= $event['max_people']);
        // ปรับการเลือกสีให้ดูซอฟต์ลงตามสไตล์ Modern UI
        $status_bg = $is_full ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700';
    ?>
        <div class="group flex flex-col bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-2">
            <div class="aspect-[16/10] overflow-hidden relative">
                <img src="/uploads/<?php echo !empty($event['img_path']) ? $event['img_path'] : 'no-image.png'; ?>"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                    alt="<?php echo $event['event_name']; ?>">

                <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold shadow-sm <?php echo $status_bg; ?>">
                    <?php echo $is_full ? '● เต็มแล้ว' : '● ว่าง ' . ($event['max_people'] - $current_reg) . ' ที่'; ?>
                </div>
            </div>

            <div class="p-5 flex flex-col flex-grow">
                <h2 class="text-lg font-bold text-gray-800 line-clamp-1 group-hover:text-blue-600 transition-colors">
                    <?php echo $event['event_name']; ?>
                </h2>

                <p class="text-sm text-gray-500 mt-1 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <?php echo $event['location']; ?>
                </p>

                <div class="mt-4 pt-4 border-t border-dashed border-gray-100 space-y-2">
                    <div class="flex items-center text-xs text-gray-600">
                        <span class="w-16 font-medium text-blue-500">เริ่มกิจกรรม:</span>
                        <span class="font-mono"><?php echo date('d M y | H:i', strtotime($event['start_date'])); ?></span>
                    </div>
                    <div class="flex items-center text-xs text-gray-600">
                        <span class="w-16 font-medium text-red-400">สิ้นสุด:</span>
                        <span class="font-mono"><?php echo date('d M y | H:i', strtotime($event['end_date'])); ?></span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="/event_detail?id=<?php echo $event['event_id']; ?>"
                        class="block w-full py-2.5 text-center text-sm font-bold rounded-xl transition-all
                       <?php echo $is_full
                            ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                            : 'bg-indigo-600 text-white hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-200'; ?>">
                        <?php echo $is_full ? 'ปิดรับสมัคร' : 'ดูรายละเอียดกิจกรรม'; ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>