<?php include 'head.php'; ?>

<div class="min-h-[calc(100vh-80px)] flex items-center justify-center p-4">
    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-6 md:p-8">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-gray-900"><?php echo $title; ?></h1>
            <p class="text-xs text-gray-500">กรอกข้อมูลให้ครบถ้วนเพื่อสร้างบัญชี</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 rounded text-xs text-red-700 font-bold">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" id="registerForm" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">ชื่อ-นามสกุล</label>
                <input type="text" name="full_name" required
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">อีเมล</label>
                <input type="email" name="email" required
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">รหัสผ่าน</label>
                <input type="password" name="password" id="password" required
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">ยืนยันรหัสผ่าน</label>
                <input type="password" name="confirm_password" id="confirm_password" required
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">เพศ</label>
                <select name="gender" required
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white outline-none">
                    <option value="">-- เลือกเพศ --</option>
                    <option value="Male">ชาย</option>
                    <option value="Female">หญิง</option>
                    <option value="Other">อื่นๆ</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">วันเกิด</label>
                <input type="date" name="birth_date" required
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white outline-none">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-700 mb-1 ml-1">เบอร์โทรศัพท์</label>
                <input type="tel" name="phone_number" required
                    class="block w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white outline-none">
            </div>

            <div class="md:col-span-2 mt-2">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-md transition-all active:scale-95">
                    ลงทะเบียน
                </button>
            </div>
        </form>

        <p class="mt-4 text-center text-xs text-gray-500">
            มีบัญชีอยู่แล้ว? <a href="/login" class="text-indigo-600 font-bold hover:underline">เข้าสู่ระบบ</a>
        </p>
    </div>
</div>

<script src="/js/register.js"></script>

<?php include 'footer.php'; ?>