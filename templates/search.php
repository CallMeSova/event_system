<div class="search-section" style="margin: 20px; padding: 15px; background: #f9f9f9; border-radius: 8px;">
    <form action="/" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">

        <div>
            <label>ชื่อกิจกรรม:</label><br>
            <input type="text" name="search_name"
                value="<?php echo $_GET['search_name'] ?? ''; ?>"
                placeholder="ค้นหาชื่อกิจกรรม...">
        </div>

        <div>
            <label>ตั้งแต่วันที่:</label><br>
            <input type="date" name="start_date"
                value="<?php echo $_GET['start_date'] ?? ''; ?>">
        </div>

        <div>
            <label>ถึงวันที่:</label><br>
            <input type="date" name="end_date"
                value="<?php echo $_GET['end_date'] ?? ''; ?>">
        </div>

        <div style="align-self: flex-end;">
            <button type="submit" style="background: #3498db; color: white; padding: 8px 20px; border: none; border-radius: 4px; cursor: pointer;">
                🔍 ค้นหา
            </button>
            <a href="/" style="text-decoration: none; color: #666; font-size: 14px; margin-left: 10px;">ล้างค่า</a>
        </div>
    </form>
</div>