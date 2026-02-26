<?php include 'head.php'; ?>

<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="relative h-64 md:h-96">
            <img src="/uploads/<?php echo !empty($images) ? $images[0]['img_path'] : 'no-image.png'; ?>"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2"><?php echo $event['event_name']; ?></h1>
                    <div class="flex flex-wrap gap-4 text-white/90 text-sm">
                        <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg><?php echo $event['location']; ?></span>
                        <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>โดย: <?php echo $event['creator_name'] ?? 'ไม่ระบุ'; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-l-4 border-indigo-500 pl-3">รายละเอียดกิจกรรม</h3>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line"><?php echo $event['description']; ?></p>
            </div>

            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    รูปภาพประกอบ (<?php echo count($images); ?>)
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <?php if (!empty($images)): foreach ($images as $img): ?>
                            <div class="aspect-square rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                                <img src="/uploads/<?php echo $img['img_path']; ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                        <?php endforeach;
                    else: ?>
                        <p class="col-span-full text-gray-400 italic py-4">กิจกรรมนี้ไม่มีรูปภาพเพิ่มเติม</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="lg:sticky lg:top-24 space-y-6">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-indigo-50">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-gray-500 text-sm">จำนวนรับสมัคร</span>
                    <span class="text-xl font-bold text-indigo-600"><?php echo $event['max_people']; ?> คน</span>
                </div>

                <?php
                $status = $reg_data['reg_status'] ?? null;
                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['creator_id']):
                ?>
                    <div class="space-y-3">
                        <p class="text-center text-xs font-bold text-indigo-400 uppercase tracking-widest mb-2">แผงจัดการผู้สร้าง</p>
                        <a href="/manage_registrations?id=<?php echo $event['event_id']; ?>" class="block w-full text-center bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition">จัดการผู้สมัคร</a>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="/edit_event?id=<?php echo $event['event_id']; ?>" class="text-center bg-gray-50 text-orange-500 py-2 rounded-xl font-bold border border-orange-100 hover:bg-orange-50 transition">แก้ไข</a>
                            <a href="/delete_event?id=<?php echo $event['event_id']; ?>" class="text-center bg-gray-50 text-red-500 py-2 rounded-xl font-bold border border-red-100 hover:bg-red-50 transition" onclick="return confirm('ยืนยันการลบกิจกรรม?')">ลบ</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php if ($status === 'pending'): ?>
                            <div class="bg-yellow-50 text-yellow-700 p-4 rounded-xl text-center font-bold border border-yellow-100 animate-pulse">⏳ รอการอนุมัติจากผู้จัด</div>
                        <?php elseif ($status === 'approved'): ?>
                            <div class="bg-green-50 text-green-700 p-4 rounded-xl text-center font-bold border border-green-100 mb-4">✅ อนุมัติการเข้าร่วมแล้ว</div>
                            <?php $otp = get_event_otp($reg_data['reg_id'], $reg_data['create_date']); ?>
                            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 p-6 text-center rounded-2xl shadow-xl shadow-indigo-200">
                                <p class="text-white/80 text-xs font-bold uppercase mb-2">OTP Check-in</p>
                                <h1 class="text-4xl font-mono font-bold text-white tracking-[0.3em] ml-[0.3em]"><?php echo $otp; ?></h1>
                                <p class="text-white/60 text-[10px] mt-4 italic">* รีเฟรชทุก 30 นาที</p>
                            </div>
                        <?php elseif ($status === 'rejected'): ?>
                            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-center font-bold border border-red-100">❌ ขออภัย คำขอถูกปฏิเสธ</div>
                        <?php elseif ($status === 'attended'): ?>
                            <div class="bg-blue-600 text-white p-5 rounded-2xl text-center font-bold shadow-lg">🏁 เข้าร่วมงานสำเร็จแล้ว</div>
                        <?php elseif ($is_full): ?>
                            <button disabled class="w-full bg-gray-200 text-gray-400 py-4 rounded-xl font-bold cursor-not-allowed">🚫 กิจกรรมเต็มแล้ว (<?php echo $current_count; ?>/<?php echo $event['max_people']; ?>)</button>
                        <?php else: ?>
                            <a href="/register_event?id=<?php echo $event['event_id']; ?>" class="block w-full">
                                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-xl font-bold shadow-lg shadow-indigo-200 transition-all transform active:scale-95">
                                    🎯 ส่งคำขอเข้าร่วม <br>
                                    <span class="text-[10px] font-normal opacity-80">(ว่าง <?php echo $event['max_people'] - $current_count; ?> ที่นั่ง)</span>
                                </button>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>