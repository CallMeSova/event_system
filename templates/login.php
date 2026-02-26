<?php include 'head.php'; ?>

<div class="min-h-[80vh] flex flex-col items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl shadow-indigo-100/50 border border-gray-100 p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2"><?php echo $title; ?></h1>
            <p class="text-gray-500 text-sm">ยินดีต้อนรับกลับมา! กรุณากรอกข้อมูลเพื่อเข้าสู่ระบบ</p>
        </div>

        <?php if (isset($error)) : ?>
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm text-red-700 font-medium"><?php echo $error; ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])) : ?>
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm text-green-700 font-medium">สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ</p>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">อีเมล</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path>
                        </svg>
                    </span>
                    <input type="email" name="email" required
                        class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none"
                        placeholder="example@mail.com">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">รหัสผ่าน</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </span>
                    <input type="password" name="password" required
                        class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition-all outline-none"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-2xl shadow-lg shadow-indigo-200 transition-all active:scale-[0.98] mt-2">
                เข้าสู่ระบบ
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">
                ยังไม่มีบัญชี?
                <a href="/register" class="text-indigo-600 font-bold hover:underline">สมัครสมาชิกที่นี่</a>
            </p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>