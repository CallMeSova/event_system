<?php include 'head.php'; ?>

<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tighter">EVENT STATISTICS</h1>
            <p class="text-indigo-600 font-bold italic"><?= htmlspecialchars($event['event_name']) ?></p>
        </div>
        <a href="/event_detail?id=<?= $event_id ?>" class="px-6 py-2 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-gray-800 transition shadow-lg">
            ← กลับหน้ากิจกรรม
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">ผู้สมัครทั้งหมด</p>
            <h3 class="text-3xl font-black text-gray-800"><?= $stats['total'] ?></h3>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-green-600">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 text-green-400">อนุมัติแล้ว</p>
            <h3 class="text-3xl font-black"><?= $stats['approved'] ?></h3>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-blue-600">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 text-blue-400">เช็คชื่อแล้ว</p>
            <h3 class="text-3xl font-black"><?= $stats['attended'] ?></h3>
        </div>
        <div class="bg-indigo-600 p-6 rounded-3xl shadow-xl shadow-indigo-100 text-white">
            <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mb-1">ATTENDANCE RATE</p>
            <h3 class="text-3xl font-black"><?= $attendance_rate ?>%</h3>
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-8 border-l-4 border-indigo-500 pl-4">สถานะการสมัครรายบุคคล</h3>

        <div class="h-8 w-full bg-gray-100 rounded-2xl overflow-hidden flex shadow-inner mb-8">
            <div style="width: <?= ($stats['total'] > 0 ? ($stats['attended'] / $stats['total']) * 100 : 0) ?>%" class="bg-blue-500" title="มางานแล้ว"></div>
            <div style="width: <?= ($stats['total'] > 0 ? (($stats['approved'] - $stats['attended']) / $stats['total']) * 100 : 0) ?>%" class="bg-green-400" title="อนุมัติแต่ยังไม่มา"></div>
            <div style="width: <?= ($stats['total'] > 0 ? ($stats['pending'] / $stats['total']) * 100 : 0) ?>%" class="bg-yellow-400" title="รออนุมัติ"></div>
            <div style="width: <?= ($stats['total'] > 0 ? ($stats['rejected'] / $stats['total']) * 100 : 0) ?>%" class="bg-red-400" title="ปฏิเสธ"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                <div class="text-xs font-bold text-gray-600">Checked-in: <span class="text-gray-900"><?= $stats['attended'] ?></span></div>
            </div>

            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                <div class="text-xs font-bold text-gray-600">Approved: <span class="text-gray-900"><?= $stats['approved'] ?></span></div>
            </div>

            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                <div class="text-xs font-bold text-gray-600">Pending: <span class="text-gray-900"><?= $stats['pending'] ?></span></div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                <div class="text-xs font-bold text-gray-600">Rejected: <span class="text-gray-900"><?= $stats['rejected'] ?></span></div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>