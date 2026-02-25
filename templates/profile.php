<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include 'header.php' ?>
    <div class="max-w-6xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl sm:text-2xl font-bold">
                    <i class="fas fa-user"></i>
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-gray-800">โปรไฟล์</h2>
                    <p class="text-gray-500">ข้อมูลส่วนตัว</p>
                </div>
            </div>
            
            <?php 
            $user = $data['user']->fetch_assoc();
            ?>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-user mr-2"></i>ชื่อ
                    </label>
                    <p class="text-gray-900 text-base sm:text-lg font-medium"><?= htmlspecialchars($user['first_name']) ?></p>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-user mr-2"></i>นามสกุล
                    </label>
                    <p class="text-gray-900 text-base sm:text-lg font-medium"><?= htmlspecialchars($user['last_name']) ?></p>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-envelope mr-2"></i>อีเมล
                    </label>
                    <p class="text-gray-900 text-base sm:text-lg font-medium break-all"><?= htmlspecialchars($user['email']) ?></p>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-venus-mars mr-2"></i>เพศ
                    </label>
                    <p class="text-gray-900 text-base sm:text-lg font-medium"><?= htmlspecialchars($user['gender']) ?></p>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-birthday-cake mr-2"></i>อายุ
                    </label>
                    <p class="text-gray-900 text-base sm:text-lg font-medium"><?= htmlspecialchars($user['age']) ?> ปี</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>