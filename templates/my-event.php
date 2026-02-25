<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>My Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

<?php include 'header.php' ?>

<div class="max-w-6xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">My Events</h2>
            <p class="text-gray-500 text-sm">รายการกิจกรรมที่คุณเข้าร่วมหรือถูกปฏิเสธ</p>
        </div>
    </div>
    
    <?php if($data['events']->num_rows === 0): ?>
        <div class="text-center py-10 bg-white rounded-lg shadow">
            <div class="text-gray-400 text-6xl mb-4">
                <i class="fas fa-calendar-times"></i>
            </div>
            <p class="text-gray-500 text-lg">ยังไม่มีกิจกรรม</p>
            <p class="text-gray-400 text-sm mt-2">คุณยังไม่ได้เข้าร่วมกิจกรรมใดๆ</p>
        </div>
    <?php else: ?>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 sm:px-6 py-2 sm:py-4 font-semibold hidden sm:table-cell">ชื่อกิจกรรม</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-4 font-semibold sm:hidden">กิจกรรม</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-4 font-semibold hidden sm:table-cell">สถานะ</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-4 font-semibold">วันที่</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-4 font-semibold">แอ็คชัน</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php while ($e = $data['events']->fetch_assoc()): ?>
                        <?php
                        $statusColor = match($e['status']) {
                            'confirmed' => 'bg-yellow-100 text-yellow-700',
                            'already' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700'
                        };
                        
                        $statusText = match($e['status']) {
                            'confirmed' => 'ยืนยันแล้ว',
                            'already' => 'เข้าร่วมแล้ว',
                            'cancelled' => 'ถูกปฏิเสธ',
                            'pending' => 'รอการยืนยัน',
                            default => $e['status']
                        };
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 sm:px-6 py-2 sm:py-4 font-medium text-gray-800">
                                <?= htmlspecialchars($e['event_name']) ?>
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4 hidden sm:table-cell">
                                <span class="<?= $statusColor ?> px-2 sm:px-3 py-1 rounded-full text-xs font-medium">
                                    <?= $statusText ?>
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4 text-gray-600 text-sm">
                                <?= htmlspecialchars($e['event_date']) ?>
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-4">
                                <a href="detail?eid=<?= $e['event_id'] ?>&name=<?= urlencode($e['event_name']) ?>" 
                                   class="text-blue-500 hover:text-blue-700 font-medium text-sm">
                                    <i class="fas fa-eye mr-1"></i> <span class="hidden sm:inline">ดูรายละเอียด</span><span class="sm:hidden">ดู</span>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
