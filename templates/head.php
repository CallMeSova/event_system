<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'ระบบจัดการกิจกรรม'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-indigo-600">EventManage</span>
                    </a>
                    <div class="hidden md:ml-6 md:flex md:space-x-4">
                        <a href="/" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition">หน้าแรก</a>
                        <a href="/create_event" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition">สร้างกิจกรรม</a>
                        <a href="/my_event" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition">อีเวนต์ของฉัน</a>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="hidden md:flex items-center">
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <div class="flex items-center space-x-4">
                                <a href="/my_history" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition">ประวัติการเข้าร่วม</a>
                                <div class="flex flex-col items-end">
                                    <span class="text-xs text-gray-400">เข้าใช้งานโดย</span>
                                    <a href="/profile" class="text-sm font-semibold text-gray-700 underline decoration-indigo-300"><?php echo $_SESSION['full_name']; ?></a>
                                </div>
                                <a href="/logout" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-bold transition-all border border-red-200">ออกจากระบบ</a>
                            </div>
                        <?php else : ?>
                            <div class="flex items-center space-x-2">
                                <a href="/login" class="text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-lg text-sm font-medium transition">เข้าสู่ระบบ</a>
                                <a href="/register" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md shadow-indigo-200 transition">สมัครสมาชิก</a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="flex md:hidden">
                        <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-indigo-600 hover:bg-gray-100 focus:outline-none transition">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-4 pt-2 pb-6 space-y-1 shadow-lg">
            <a href="/" class="block text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 px-3 py-3 rounded-md text-base font-medium transition">หน้าแรก</a>
            <a href="/create_event" class="block text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 px-3 py-3 rounded-md text-base font-medium transition">สร้างกิจกรรม</a>
            <a href="/my_event" class="block text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 px-3 py-3 rounded-md text-base font-medium transition">อีเวนต์ของฉัน</a>

            <?php if (isset($_SESSION['user_id'])) : ?>
                <hr class="my-2 border-gray-100">
                <a href="/my_history" class="block text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 px-3 py-3 rounded-md text-base font-medium transition">ประวัติการเข้าร่วม</a>
                <a href="/profile" class="block text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 px-3 py-3 rounded-md text-base font-medium transition italic">โปรไฟล์: <?php echo $_SESSION['full_name']; ?></a>
                <a href="/logout" class="block bg-red-50 text-red-600 px-3 py-3 rounded-md text-base font-bold mt-4">ออกจากระบบ</a>
            <?php else : ?>
                <hr class="my-2 border-gray-100">
                <a href="/login" class="block text-gray-600 hover:bg-gray-50 px-3 py-3 rounded-md text-base font-medium transition">เข้าสู่ระบบ</a>
                <a href="/register" class="block bg-indigo-600 text-white px-3 py-3 rounded-md text-base font-bold transition text-center">สมัครสมาชิก</a>
            <?php endif; ?>
        </div>
    </nav>

    <script>
        // Script สำหรับคุมการเปิด/ปิด Mobile Menu
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">