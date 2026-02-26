<?php include 'head.php'; ?>

<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">ประวัติการขอเข้าร่วมกิจกรรม</h1>
        <p class="text-gray-500 mt-2">ตรวจสอบสถานะการสมัครและรายละเอียดกิจกรรมที่คุณสนใจ</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 text-xs font-black uppercase tracking-widest">
                        <th class="px-6 py-5">ชื่อกิจกรรม</th>
                        <th class="px-6 py-5">วันที่จัดงาน</th>
                        <th class="px-6 py-5">สถานะ</th>
                        <th class="px-6 py-5 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if ($my_history->num_rows > 0): while ($row = $my_history->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-800">
                                    <?php echo $row['event_name']; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <?php echo date('d M Y', strtotime($row['start_date'])); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php
                                    $status = $row['reg_status'];
                                    $badge_class = '';

                                    switch ($status) {
                                        case 'approved':
                                            $badge_class = 'bg-green-100 text-green-700';
                                            $label = 'อนุมัติแล้ว';
                                            break;
                                        case 'rejected':
                                            $badge_class = 'bg-red-100 text-red-700';
                                            $label = 'ถูกปฏิเสธ';
                                            break;
                                        case 'attended':
                                            $badge_class = 'bg-blue-100 text-blue-700';
                                            $label = 'เข้าร่วมแล้ว';
                                            break;
                                        default:
                                            $badge_class = 'bg-yellow-100 text-yellow-700';
                                            $label = 'รอตรวจสอบ';
                                            break;
                                    }
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase <?php echo $badge_class; ?>">
                                        <?php echo $label; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="/event_detail?id=<?php echo $row['event_id']; ?>"
                                        class="inline-flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">
                                        ดูรายละเอียด
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center text-gray-400 italic font-medium">
                                ยังไม่มีประวัติการสมัครกิจกรรม
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>