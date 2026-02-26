<?php include 'head.php'; ?>

<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <a href="/event_detail?id=<?php echo $event_id; ?>" class="text-sm text-indigo-600 hover:text-indigo-800 font-bold flex items-center mb-2 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                กลับไปยังรายละเอียดกิจกรรม
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900">จัดการผู้สมัครกิจกรรม</h1>
        </div>

        <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-100 flex items-center">
            <form action="/manage_registrations" method="GET" class="flex items-center gap-3">
                <input type="hidden" name="id" value="<?php echo $event_id; ?>">
                <label class="text-xs font-bold text-gray-400 uppercase ml-2">ตัวกรอง:</label>
                <select name="filter_status" onchange="this.form.submit()"
                    class="bg-gray-50 border-none rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-100 py-2 pl-3 pr-10 cursor-pointer">
                    <option value="">ทั้งหมด</option>
                    <option value="pending" <?php echo ($current_filter == 'pending') ? 'selected' : ''; ?>>PENDING</option>
                    <option value="approved" <?php echo ($current_filter == 'approved') ? 'selected' : ''; ?>>APPROVED</option>
                    <option value="rejected" <?php echo ($current_filter == 'rejected') ? 'selected' : ''; ?>>REJECTED</option>
                    <option value="attended" <?php echo ($current_filter == 'attended') ? 'selected' : ''; ?>>ATTENDED</option>
                </select>
                <?php if (!empty($current_filter)): ?>
                    <a href="/manage_registrations?id=<?php echo $event_id; ?>" class="p-2 text-gray-400 hover:text-red-500 transition" title="ล้างการกรอง">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="bg-gradient-to-r from-orange-500 to-amber-500 p-8 rounded-3xl shadow-lg shadow-orange-100 mb-10 text-white">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
            <div class="text-center lg:text-left">
                <h3 class="text-2xl font-black mb-2 flex items-center justify-center lg:justify-start">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    ตรวจสอบรหัส OTP หน้างาน
                </h3>
                <p class="text-orange-100 text-sm">กรอกรหัส 6 หลักจากผู้เข้าร่วมเพื่อบันทึกการเข้างาน</p>
            </div>

            <form action="/check_otp" method="POST" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                <input type="text" name="input_otp" placeholder="000000" maxlength="6" required
                    class="text-3xl font-mono font-bold text-center tracking-[0.5em] py-3 px-6 rounded-2xl border-none text-orange-600 focus:ring-4 focus:ring-orange-300 outline-none w-full sm:w-64 shadow-inner">
                <button type="submit"
                    class="bg-white text-orange-600 font-black py-4 px-8 rounded-2xl hover:bg-orange-50 transition-all active:scale-95 shadow-md">
                    ยืนยันเข้างาน
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 text-xs font-black uppercase tracking-widest">
                        <th class="px-6 py-5">ข้อมูลผู้สมัคร</th>
                        <th class="px-6 py-5">สถานะปัจจุบัน</th>
                        <th class="px-6 py-5 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if ($registrations->num_rows > 0): while ($row = $registrations->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900"><?php echo $row['full_name']; ?></div>
                                    <div class="text-xs text-gray-400 mt-1"><?php echo $row['email']; ?> • <?php echo $row['phone_number']; ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php
                                    $status_classes = [
                                        'pending' => 'bg-yellow-50 text-yellow-600',
                                        'approved' => 'bg-green-50 text-green-600',
                                        'rejected' => 'bg-red-50 text-red-600',
                                        'attended' => 'bg-blue-50 text-blue-600'
                                    ];
                                    $cls = $status_classes[$row['reg_status']] ?? 'bg-gray-50 text-gray-600';
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter <?php echo $cls; ?>">
                                        <?php echo $row['reg_status']; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <?php if ($row['reg_status'] === 'attended'): ?>
                                            <span class="text-xs text-blue-500 font-bold italic flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </path>
                                                </svg>
                                                บันทึกแล้ว
                                            </span>
                                        <?php else: ?>
                                            <a href="/update_reg?reg_id=<?php echo $row['reg_id']; ?>&status=approved"
                                                class="p-2 text-green-500 hover:bg-green-50 rounded-lg transition" title="อนุมัติ">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </a>
                                            <a href="/update_reg?reg_id=<?php echo $row['reg_id']; ?>&status=rejected"
                                                class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="ปฏิเสธ" onclick="return confirm('ยืนยันการปฏิเสธผู้สมัคร?')">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="3" class="px-6 py-20 text-center text-gray-400 italic">ไม่พบข้อมูลผู้สมัครในสถานะนี้</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>