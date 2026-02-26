<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
    <form action="/" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">

        <div class="flex flex-col space-y-2">
            <label class="text-sm font-semibold text-gray-700 ml-1">ชื่อกิจกรรม</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search_name"
                    value="<?php echo htmlspecialchars($_GET['search_name'] ?? ''); ?>"
                    placeholder="ค้นหาชื่อกิจกรรม..."
                    class="block w-full pl-10 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
            </div>
        </div>

        <div class="flex flex-col space-y-2">
            <label class="text-sm font-semibold text-gray-700 ml-1">ตั้งแต่วันที่</label>
            <input type="date" name="start_date"
                value="<?php echo htmlspecialchars($_GET['start_date'] ?? ''); ?>"
                class="block w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
        </div>

        <div class="flex flex-col space-y-2">
            <label class="text-sm font-semibold text-gray-700 ml-1">ถึงวันที่</label>
            <input type="date" name="end_date"
                value="<?php echo htmlspecialchars($_GET['end_date'] ?? ''); ?>"
                class="block w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
        </div>

        <div class="flex items-center space-x-2">
            <button type="submit"
                class="flex-grow bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-xl shadow-md shadow-indigo-100 transition-all active:scale-95">
                🔍 ค้นหา
            </button>
            <a href="/"
                class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                ล้างค่า
            </a>
        </div>

    </form>
</div>