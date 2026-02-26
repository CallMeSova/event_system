<?php include 'head.php'; ?>

<div class="min-h-[calc(100vh-80px)] flex items-center justify-center py-10 px-4">
    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-xl shadow-indigo-100/50 border border-gray-100 overflow-hidden">

        <div class="bg-indigo-600 px-8 py-10 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-md rounded-full border-2 border-white/50 mb-4">
                <span class="text-3xl font-black text-white uppercase">
                    <?= mb_substr($user['full_name'], 0, 1, 'UTF-8') ?>
                </span>
            </div>
            <h2 class="text-2xl font-extrabold text-white uppercase tracking-tight">
                <?= htmlspecialchars($user['full_name']) ?>
            </h2>
            <p class="text-indigo-100 text-sm mt-1">สมาชิกในระบบ EventHub</p>
        </div>

        <div class="p-8 md:p-10 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-gray-50 rounded-lg"><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg></div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">อีเมล</p>
                        <p class="text-gray-700 font-medium"><?= htmlspecialchars($user['email']) ?></p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-gray-50 rounded-lg"><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg></div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">เบอร์โทรศัพท์</p>
                        <p class="text-gray-700 font-medium"><?= htmlspecialchars($user['phone_number']) ?></p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-gray-50 rounded-lg"><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg></div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">เพศ</p>
                        <p class="text-gray-700 font-medium"><?= htmlspecialchars($user['gender']) ?></p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-gray-50 rounded-lg"><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg></div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">วันเกิด</p>
                        <p class="text-gray-700 font-medium"><?= htmlspecialchars($user['birth_date']) ?></p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-gray-50 rounded-lg"><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg></div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">สถานะบัญชี</p>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest <?= $user['role'] === 'admin' ? 'bg-red-100 text-red-600' : 'bg-indigo-100 text-indigo-600' ?>">
                            <?= htmlspecialchars($user['role']) ?>
                        </span>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-gray-50 rounded-lg"><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg></div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">วันที่สมัครสมาชิก</p>
                        <p class="text-gray-700 font-medium"><?= date('d/m/Y', strtotime($user['created_at'])) ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>