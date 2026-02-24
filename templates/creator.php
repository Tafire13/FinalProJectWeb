<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creator Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50">

    <?php include 'header.php'?>
    
    <div class="max-w-6xl mx-auto mt-10 px-4 mb-10">
        <?php if(!empty($_SESSION['message'])) { ?>
            <div class="bg-green-300 p-2 text-center rouneded">
                <?= $_SESSION['message'] ?? ''?>
                <?php unset($_SESSION['message']) ?>
            </div>
        <?php } ?>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">Your Events</h2>
                <p class="text-gray-500 mt-1">จัดการและติดตามกิจกรรมทั้งหมดที่คุณสร้างขึ้น</p>
            </div>

            <button onclick="window.location.href='create-event'"
                class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-lg transition duration-200 ease-in-out transform hover:-translate-y-0.5">
                <i class="fas fa-plus-circle mr-2"></i>
                Create New Event
            </button>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-blue-500 text-white text-sm uppercase tracking-wider">
                            <th class="p-4 font-semibold">ID</th>
                            <th class="p-4 font-semibold">Event Name</th>
                            <th class="p-4 font-semibold">Description</th>
                            <th class="p-4 font-semibold text-center">Date</th>
                            <th class="p-4 font-semibold text-center">Capacity</th>
                            <th class="p-4 font-semibold text-center">Creator</th>
                            <th class="p-4 font-semibold text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        <?php if(empty($data['events']) || $data['events']->num_rows == 0){ ?>
                        <tr>
                            <td colspan="7" class="text-center p-12">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-calendar-times text-gray-300 text-5xl mb-3"></i>
                                    <p class="text-gray-400 text-lg">ยังไม่มีกิจกรรมที่คุณสร้างไว้</p>
                                </div>
                            </td>
                        </tr>
                        <?php } else { ?>
                        <?php while($row = $data['events']->fetch_object()) { ?>
                        <tr class="hover:bg-blue-50/50 transition duration-150">
                            <td class="p-4 font-mono text-sm text-gray-500">#<?= htmlspecialchars($row->event_id) ?></td>
                            <td class="p-4">
                                <span class="font-bold text-gray-800"><?= htmlspecialchars($row->event_name) ?></span>
                            </td>
                            <td class="p-4">
                                <p class="text-gray-600 line-clamp-1 w-48 text-sm"><?= htmlspecialchars($row->description) ?></p>
                            </td>
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    <?= htmlspecialchars($row->event_date) ?>
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="font-semibold text-gray-700">
                                    <i class="fas fa-users text-gray-400 mr-1"></i>
                                    <?= htmlspecialchars($row->max_participants) ?>
                                </span>
                            </td>
                            <td class="p-4 text-center text-sm text-gray-500"><?= htmlspecialchars($row->first_name . ' ' . $row->last_name) ?></td>
                            
                            <td class="p-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <button 
                                        onclick="openModal(
                                            '<?= $row->event_id ?>',
                                            '<?= htmlspecialchars($row->event_name) ?>',
                                            '<?= htmlspecialchars($row->description) ?>',
                                            '<?= $row->event_date ?>',
                                            '<?= $row->max_participants ?>'
                                        )"
                                        class="flex items-center px-3 py-1.5 bg-amber-100 text-amber-700 rounded-md hover:bg-amber-200 transition font-medium text-sm"
                                    >
                                        <i class="fas fa-edit mr-1"></i> แก้ไข
                                    </button>
                                    <a href="delete-event?id=<?= $row->event_id ?>" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบกิจกรรมนี้?')"class="flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition font-medium text-sm">
                                        <i class="fas fa-trash-alt mr-1"></i> ลบ
                                    </a>
                                    <a href="dashboard">
                                        <button class="flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition font-medium text-sm">
                                            <i class="fas fa-users mr-1"></i> ผู้สมัคร
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <p class="mt-4 text-xs text-center text-gray-400">
            แสดงรายการกิจกรรมทั้งหมดของคุณในระบบ
        </p>

    </div>
    <?php include 'edit-modal.php' ?>
</body>
<script>
function openModal(id, name, desc, date, max){
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = desc;
    document.getElementById('edit_date').value = date;
    document.getElementById('edit_max').value = max;

    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeModal(){
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}

</script>
</html>