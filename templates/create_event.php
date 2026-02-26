<?php include 'head.php'; ?>

<div class="min-h-[calc(100vh-80px)] flex items-center justify-center p-4">
    <div class="max-w-3xl w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-6 md:p-8">

        <div class="flex items-center space-x-3 mb-6">
            <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900"><?php echo $title; ?></h1>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">ชื่อกิจกรรม</label>
                <input type="text" name="event_name" required
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">รายละเอียดกิจกรรม</label>
                <textarea name="description" rows="3"
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all resize-none"
                    placeholder="บอกเล่าเรื่องราวกิจกรรมของคุณ..."></textarea>
            </div>

            <div class="md:col-span-1">
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">สถานที่</label>
                <input type="text" name="location" required
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <div class="md:col-span-1">
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">จำนวนคนสูงสุด</label>
                <input type="number" name="max_people" min="1" required
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">วันที่เริ่มงาน</label>
                <input type="datetime-local" name="start_date" id="startDate" required
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1 text-red-500">วันที่สิ้นสุดงาน</label>
                <input type="datetime-local" name="end_date" id="endDate" required disabled
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm disabled:opacity-50 disabled:cursor-not-allowed outline-none transition-all">
                <p id="date-error" class="text-[10px] text-red-500 mt-1"></p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">รูปภาพกิจกรรม (หลายรูป)</label>
                <div class="flex items-center gap-2">
                    <input type="file" name="images[]" id="imageInput" accept="image/*" multiple
                        class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    <button type="button" onclick="clearImages()"
                        class="px-3 py-2 text-xs font-bold text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                        ล้างรูปภาพ
                    </button>
                </div>
            </div>

            <div class="md:col-span-2 mt-4">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-bold py-3 rounded-2xl shadow-lg shadow-indigo-100 transition-all hover:scale-[1.01] active:scale-[0.98]">
                    🚀 ยืนยันการสร้างกิจกรรม
                </button>
            </div>
        </form>
    </div>
</div>

<script src="/js/create_event.js"></script>
<?php include 'footer.php'; ?>