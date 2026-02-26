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
                    </div>
                </div>

                <div class="flex items-center">
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <div class="flex items-center space-x-4">
                            <a href="/my_history" class="hidden sm:block text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition">ประวัติการเข้าร่วม</a>

                            <div class="flex flex-col items-end">
                                <span class="text-xs text-gray-400">เข้าใช้งานโดย</span>
                                <a href="/profile" class="text-sm font-semibold text-gray-700 underline decoration-indigo-300"><?php echo $_SESSION['full_name']; ?></a>
                            </div>

                            <a href="/logout" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-bold transition-all border border-red-200">
                                ออกจากระบบ
                            </a>
                        </div>
                    <?php else : ?>
                        <div class="flex items-center space-x-2">
                            <a href="/login" class="text-gray-600 hover:bg-gray-100 px-4 py-2 rounded-lg text-sm font-medium transition">เข้าสู่ระบบ</a>
                            <a href="/register" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md shadow-indigo-200 transition">
                                สมัครสมาชิก
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">