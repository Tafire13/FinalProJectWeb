<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard - ผู้สมัครเข้าร่วมกิจกรรม</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

<?php include 'header.php'?>

<div class="max-w-5xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">ผู้สมัครเข้าร่วมกิจกรรม</h2>
            <p class="text-gray-500 text-sm">จัดการผู้เข้าร่วมทั้งหมดของกิจกรรมคุณ</p>
        </div>
        <a href="creator" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
            <i class="fas fa-arrow-left mr-2"></i> กลับไปหน้า Creator
        </a>
    </div>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
        </div>
    <?php endif; ?>
    
    <!-- สถิติสรุป -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-medium">อนุมัติแล้ว</p>
                    <p class="text-2xl font-bold text-green-700"><?= $data['stats']['confirmed'] ?> คน</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-600 text-sm font-medium">รออนุมัติ</p>
                    <p class="text-2xl font-bold text-yellow-700"><?= $data['stats']['pending'] ?> คน</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-600 text-sm font-medium">ปฏิเสธ</p>
                    <p class="text-2xl font-bold text-red-700"><?= $data['stats']['cancelled'] ?> คน</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-times text-red-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-medium">เข้าร่วมแล้ว</p>
                    <p class="text-2xl font-bold text-blue-700"><?= $data['stats']['already'] ?> คน</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-check text-blue-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- สถิติเพศและอายุ -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        <div class="bg-white shadow rounded-xl p-4 border">
            <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-venus-mars mr-2 text-blue-500"></i>สถิติตามเพศ</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600"><i class="fas fa-male mr-2 text-blue-500"></i>ชาย</span>
                    <span class="font-semibold text-gray-800"><?= $data['stats']['male'] ?> คน</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: <?= $data['stats']['male'] > 0 ? ($data['stats']['male'] / ($data['stats']['male'] + $data['stats']['female'] + $data['stats']['other']) * 100) : 0 ?>%"></div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600"><i class="fas fa-female mr-2 text-pink-500"></i>หญิง</span>
                    <span class="font-semibold text-gray-800"><?= $data['stats']['female'] ?> คน</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-pink-500 h-2 rounded-full" style="width: <?= $data['stats']['female'] > 0 ? ($data['stats']['female'] / ($data['stats']['male'] + $data['stats']['female'] + $data['stats']['other']) * 100) : 0 ?>%"></div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600"><i class="fas fa-user mr-2 text-gray-500"></i>อื่นๆ</span>
                    <span class="font-semibold text-gray-800"><?= $data['stats']['other'] ?> คน</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gray-500 h-2 rounded-full" style="width: <?= $data['stats']['other'] > 0 ? ($data['stats']['other'] / ($data['stats']['male'] + $data['stats']['female'] + $data['stats']['other']) * 100) : 0 ?>%"></div>
                </div>
            </div>
        </div>
        <div class="bg-white shadow rounded-xl p-4 border">
            <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-birthday-cake mr-2 text-purple-500"></i>สถิติตามช่วงอายุ</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">18 ปี ต่ำกว่า</span>
                    <span class="font-semibold text-gray-800"><?= $data['stats']['age_less_17'] ?> คน</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">18-25 ปี</span>
                    <span class="font-semibold text-gray-800"><?= $data['stats']['age_18_25'] ?> คน</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">26-35 ปี</span>
                    <span class="font-semibold text-gray-800"><?= $data['stats']['age_26_35'] ?> คน</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">36-50 ปี</span>
                    <span class="font-semibold text-gray-800"><?= $data['stats']['age_36_50'] ?> คน</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">50+ ปี</span>
                    <span class="font-semibold text-gray-800"><?= $data['stats']['age_50_plus'] ?> คน</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl overflow-hidden border overflow-x-auto">
        <table class="min-w-full text-xs sm:text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-2 sm:p-3 text-left hidden sm:table-cell">ผู้สมัคร</th>
                    <th class="p-2 sm:p-3 text-left sm:hidden">ข้อมูล</th>
                    <th class="p-2 sm:p-3 text-left hidden sm:table-cell">Event</th>
                    <th class="p-2 sm:p-3 text-center hidden sm:table-cell">Status</th>
                    <th class="p-2 sm:p-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            <?php if(empty($data['users']) || $data['users']->num_rows == 0){ ?>
                <tr>
                    <td colspan="4" class="text-center p-4 sm:p-6 text-gray-400">
                        ยังไม่มีผู้สมัคร
                    </td>
                </tr>
            <?php } else { ?>
                <?php while($row = $data['users']->fetch_object()) { ?>
                <tr class="hover:bg-gray-50 text-sm">
                    
                    <td class="p-2 sm:p-3">
                        <?php 
                        $userDetails = getDataUserById($row->uid);
                        $user = $userDetails->fetch_assoc();
                        ?>
                        <div class="space-y-1">
                            <div class="font-medium text-gray-900 text-sm">
                                <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                            </div>
                            <div class="text-xs text-gray-600 hidden sm:block">
                                <i class="fas fa-envelope mr-1"></i><?= htmlspecialchars($user['email']) ?>
                            </div>
                            <div class="text-xs text-gray-600 hidden sm:block">
                                <i class="fas fa-birthday-cake mr-1"></i><?= htmlspecialchars($user['age']) ?> ปี
                            </div>
                            <div class="text-xs text-gray-600 sm:hidden">
                                <div><i class="fas fa-envelope mr-1"></i><?= htmlspecialchars($user['email']) ?></div>
                                <div><i class="fas fa-birthday-cake mr-1"></i><?= htmlspecialchars($user['age']) ?> ปี</div>
                            </div>
                        </div>
                    </td>

                    <td class="p-2 sm:p-3 text-gray-600 hidden sm:table-cell">
                        <?= htmlspecialchars($row->event_name) ?>
                    </td>

                    <td class="p-2 sm:p-3 text-center hidden sm:table-cell">
                        <?php
                            $statusColor = 'bg-gray-200 text-gray-700';
                            if($row->status == 'pending'){
                                $statusColor = 'bg-yellow-100 text-yellow-700';
                            } elseif($row->status == 'confirmed'){
                                $statusColor = 'bg-green-100 text-green-700';
                            } elseif($row->status == 'cancelled'){
                                $statusColor = 'bg-red-100 text-red-700';
                            } elseif($row->status == 'already'){
                                $statusColor = 'bg-blue-100 text-blue-700';
                            }
                        ?>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $statusColor ?>">
                            <?= $row->status ?>
                        </span>
                    </td>

                    <td class="p-2 sm:p-3 text-center">
                        <div class="flex flex-col sm:flex-row justify-center gap-2">

                        <?php if($row->status == 'pending'){ ?>

                            <!-- ปุ่มรับเข้า -->
                            <form method="POST" action="update-status"
                                onsubmit="return confirm('จะรับเข้าจริงไหม?')">
                                <input type="hidden" name="reg_id" value="<?= $row->reg_id ?>">
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit"
                                    class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 text-xs">
                                    รับเข้า
                                </button>
                            </form>

                            <!-- ปุ่มปฏิเสธ -->
                            <form method="POST" action="update-status"
                                onsubmit="return confirm('จะปฏิเสธจริงไหม?')">
                                <input type="hidden" name="reg_id" value="<?= $row->reg_id ?>">
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit"
                                    class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 text-xs">
                                    ปฏิเสธ
                                </button>
                            </form>

                        <?php } else if($row->status == 'confirmed') { ?>
                            <form action="verify-otp" method="POST">
                                <input type="hidden" name="reg_id" value="<?= $row->reg_id ?>">
                                <input type="text" name="otp_code" placeholder="ยืนยันรหัส OTP" class="px-2 py-1 border rounded-md text-xs">
                                <button type="submit"
                                    class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 text-xs">
                                    ยืนยัน OTP
                                </button>
                            </form>
                        <?php } else { ?>
                            <span class="text-xs text-black">เข้าร่วมงานแล้ว</span>
                        <?php } ?>

                        </div>
                    </td>

                </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>