<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<?php include 'header.php'?>

<div class="max-w-5xl mx-auto mt-10 px-4">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">ผู้สมัครเข้าร่วมกิจกรรม</h2>
        <p class="text-gray-500 text-sm">จัดการผู้เข้าร่วมทั้งหมดของกิจกรรมคุณ</p>
    </div>

    <div class="bg-white shadow-lg rounded-xl overflow-hidden border">
        <table class="min-w-full">
            <thead class="bg-indigo-500 text-white">
                <tr>
                    <th class="p-3 text-left">Username</th>
                    <th class="p-3 text-left">Event</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            <?php if(empty($data['users']) || $data['users']->num_rows == 0){ ?>
                <tr>
                    <td colspan="4" class="text-center p-6 text-gray-400">
                        ยังไม่มีผู้สมัคร
                    </td>
                </tr>
            <?php } else { ?>
                <?php while($row = $data['users']->fetch_object()) { ?>
                <tr class="hover:bg-gray-50 text-sm">
                    
                    <td class="p-3 font-medium text-gray-700">
                        <?= htmlspecialchars($row->username) ?>
                    </td>

                    <td class="p-3 text-gray-600">
                        <?= htmlspecialchars($row->event_name) ?>
                    </td>

                    <td class="p-3 text-center">
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

                    <td class="p-3 text-center">
                        <div class="flex justify-center gap-2">

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
                            <span class="text-xs text-black">ยืนยันแล้ว</span>
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