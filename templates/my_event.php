<?php include 'head.php'; ?>

<div class="max-w-6xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8"><?php echo $title; ?></h1>

    <div class="mb-12">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <span class="w-1.5 h-6 bg-indigo-600 rounded-full mr-3"></span>
            กิจกรรมที่ฉันสร้าง
        </h2>

        <?php if (!empty($created_events)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($created_events as $event): ?>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($event['event_name']); ?></h3>
                        <a href="/manage_registrations?id=<?php echo $event['event_id']; ?>"
                            class="inline-block bg-indigo-600 text-white text-xs px-4 py-2 rounded-xl font-bold">
                            จัดการผู้สมัคร
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-400 italic">คุณยังไม่ได้สร้างกิจกรรมใด ๆ</p>
        <?php endif; ?>
    </div>

    <div>
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <span class="w-1.5 h-6 bg-orange-500 rounded-full mr-3"></span>
            กิจกรรมที่ฉันขอเข้าร่วม
        </h2>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-xs text-gray-400 uppercase">
                    <tr>
                        <th class="px-6 py-4">ชื่อกิจกรรม</th>
                        <th class="px-6 py-4 text-center">สถานะ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if (!empty($joined_events)): foreach ($joined_events as $row): ?>
                            <tr>
                                <td class="px-6 py-4 font-bold"><?php echo htmlspecialchars($row['event_name']); ?></td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black bg-gray-100">
                                        <?php echo strtoupper($row['reg_status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="2" class="px-6 py-10 text-center text-gray-400">ยังไม่มีประวัติการสมัคร</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>