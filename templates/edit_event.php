<?php include 'head.php'; ?>

<div class="min-h-[calc(100vh-80px)] flex items-center justify-center p-4">
    <div class="max-w-4xl w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-6 md:p-10">

        <div class="flex items-center justify-between mb-8 border-b pb-4">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-orange-100 rounded-lg text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900">แก้ไขกิจกรรม: <span class="text-orange-500"><?php echo $event['event_name']; ?></span></h1>
            </div>
            <a href="/event_detail?id=<?php echo $event['event_id']; ?>" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">ยกเลิก</a>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase tracking-wider">ชื่อกิจกรรม</label>
                <input type="text" name="event_name" value="<?php echo $event['event_name']; ?>" required
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-orange-100 focus:border-orange-400 outline-none transition-all">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase tracking-wider">รายละเอียด</label>
                <textarea name="description" rows="3"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-orange-100 focus:border-orange-400 outline-none transition-all resize-none"><?php echo $event['description']; ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase tracking-wider">สถานที่</label>
                <input type="text" name="location" value="<?php echo $event['location']; ?>"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-orange-100 outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase tracking-wider">จำนวนคนสูงสุด</label>
                <input type="number" name="max_people" value="<?php echo $event['max_people']; ?>"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-orange-100 outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase tracking-wider">วันที่เริ่มงาน</label>
                <input type="datetime-local" id="start_date" name="start_date"
                    value="<?php echo date('Y-m-d\TH:i', strtotime($event['start_date'])); ?>"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase tracking-wider text-red-400">วันที่สิ้นสุดงาน</label>
                <input type="datetime-local" id="end_date" name="end_date"
                    value="<?php echo date('Y-m-d\TH:i', strtotime($event['end_date'])); ?>"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white outline-none transition-all">
            </div>

            <div class="md:col-span-2 bg-gray-50 p-4 rounded-2xl border border-dashed border-gray-200">
                <h3 class="text-xs font-bold text-gray-500 mb-3 ml-1 uppercase tracking-wider">รูปภาพปัจจุบัน</h3>
                <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                    <?php while ($img = $images->fetch_assoc()): ?>
                        <div class="relative flex-shrink-0 group">
                            <img src="/uploads/<?php echo $img['img_path']; ?>"
                                class="w-20 h-20 object-cover rounded-xl shadow-sm border-2 border-white group-hover:opacity-75 transition-opacity">
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 uppercase tracking-wider">เพิ่มรูปภาพใหม่ (เลือกได้หลายรูป)</label>
                <input type="file" name="images[]" multiple
                    class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
            </div>

            <div class="md:col-span-2 pt-4">
                <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-orange-100 transition-all transform active:scale-[0.98]">
                    💾 บันทึกการแก้ไขข้อมูล
                </button>
            </div>
        </form>
    </div>
</div>

<script src="/js/edit_event.js"></script>

<?php include 'footer.php'; ?>