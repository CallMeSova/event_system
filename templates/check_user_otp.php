<?php include 'head.php'; ?>

<div class="max-w-md mx-auto py-12 px-4">
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-8 text-center text-white">
            <h2 class="text-2xl font-black mb-2">ตรวจสอบรหัสเข้างาน</h2>
            <p class="text-white/70 text-sm">กรอกรหัส OTP 6 หลักเพื่อยืนยันตัวตน</p>
        </div>

        <form action="/process_user_otp" method="POST" class="p-8 space-y-6">
            <input type="hidden" name="reg_id" value="<?php echo $_GET['reg_id']; ?>">
            <input type="hidden" name="event_id" value="<?php echo $_GET['id']; ?>">

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">กรอกรหัส OTP</label>
                <input type="text" name="input_otp" maxlength="6" required placeholder="000000"
                    class="w-full text-center text-4xl font-mono font-bold tracking-[0.5em] py-4 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl focus:border-indigo-500 focus:bg-white transition-all outline-none">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl font-bold shadow-lg shadow-indigo-100 transition-all active:scale-95">
                ✅ ยืนยันการเข้างาน
            </button>

            <a href="javascript:history.back()" class="block text-center text-gray-400 text-sm font-medium hover:text-gray-600">
                ย้อนกลับ
            </a>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>