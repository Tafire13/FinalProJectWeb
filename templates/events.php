<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กิจกรรมของฉัน</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

<?php include 'header.php'?>

<div class="max-w-5xl mx-auto mt-10 px-4">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">กิจกรรมของฉัน</h2>
            <p class="text-gray-500 text-sm">รายการกิจกรรมที่คุณเข้าร่วมหรือถูกปฏิเสธ</p>
        </div>
    </div>
    
    <?php if($data['events']->num_rows === 0): ?>
        <div class="text-center py-10">
            <div class="text-gray-400 text-6xl mb-4">
                <i class="fas fa-calendar-times"></i>
            </div>
            <p class="text-gray-500 text-lg">ยังไม่มีกิจกรรม</p>
            <p class="text-gray-400 text-sm mt-2">คุณยังไม่ได้เข้าร่วมกิจกรรมใดๆ</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($e = $data['events']->fetch_assoc()): ?>
                <?php
                $images = explode(',', $e['images']);
                $first_image = $images[0] ?? 'default.jpg';
                
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
                    default => $e['status']
                };
                ?>
                
                <div onclick="window.location.href='detail?eid=<?= $e['event_id'] ?>&name=<?= urlencode($e['event_name']) ?>'"
                    class="bg-white shadow-lg rounded-xl overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 cursor-pointer">
                    
                    <div class="relative">
                        <img src="/uploads/<?= htmlspecialchars($first_image) ?>"
                            class="w-full h-48 object-cover object-center">
                        
                        <span class="absolute top-3 right-3 <?= $statusColor ?> text-xs px-3 py-1 rounded-full shadow font-medium">
                            <?= $statusText ?>
                        </span>
                    </div>

                    <div class="p-5">
                        <h2 class="text-xl font-bold text-gray-800">
                            <?= htmlspecialchars($e['event_name']) ?>
                        </h2>

                        <p class="text-gray-500 text-sm mt-2 line-clamp-3">
                            <?= htmlspecialchars($e['description']) ?>
                        </p>

                        <p class="text-sm mt-3 text-gray-600">
                            <i class="fas fa-calendar mr-1"></i>
                            <?= htmlspecialchars($e['event_date']) ?>
                        </p>
                        
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            <?= htmlspecialchars($e['location']) ?>
                        </p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
