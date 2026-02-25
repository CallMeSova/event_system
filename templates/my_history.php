<?php include 'head.php'; ?>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">ประวัติการขอเข้าร่วมกิจกรรม</h1>
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2 text-left">กิจกรรม</th>
                <th class="border p-2 text-left">วันที่จัดงาน</th>
                <th class="border p-2 text-left">สถานะ</th>
                <th class="border p-2 text-center">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $my_history->fetch_assoc()): ?>
                <tr>
                    <td class="border p-2"><?php echo $row['event_name']; ?></td>
                    <td class="border p-2"><?php echo $row['start_date']; ?></td>
                    <td class="border p-2 font-bold">
                        <?php
                        $status = $row['reg_status'];

                        // กำหนดสีตามสถานะต่างๆ
                        if ($status == 'approved') {
                            $color = 'text-green-600'; // สีเขียว: อนุมัติแล้ว
                        } elseif ($status == 'rejected') {
                            $color = 'text-red-600';   // สีแดง: ถูกปฏิเสธ
                        } elseif ($status == 'attended') {
                            $color = 'text-blue-600';  // สีน้ำเงิน: เข้าร่วมงานเรียบร้อยแล้ว (หลังแอดมินตรวจ OTP)
                        } else {
                            $color = 'text-yellow-600'; // สีเหลือง: รอการตรวจสอบ (pending)
                        }

                        echo "<span class='$color'>" . strtoupper($status) . "</span>";
                        ?>
                    </td>
                    <td class="border p-2 text-center">
                        <a href="/event_detail?id=<?php echo $row['event_id']; ?>" class="text-blue-500 hover:underline">ดูรายละเอียด</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>