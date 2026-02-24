<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Home</title>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <?php include 'header.php'; ?>
<?php if (!empty($_SESSION['message'])): ?>
    <div class="max-w-7xl mx-auto mt-4 px-6">
        <div class="p-4 rounded-lg text-white
            <?=
                $_SESSION['type'] === 'success' ? 'bg-green-500' :
                ($_SESSION['type'] === 'error' ? 'bg-red-500' : 'bg-yellow-500')
            ?>">
            <?= $_SESSION['message'] ?>
        </div>
    </div>

    <?php unset($_SESSION['message']); ?>
    <?php unset($_SESSION['type']); ?>
    <?php endif; ?>

    <!-- 🔎 Search + Date Range -->
<div class="max-w-7xl mx-auto px-6 mt-6">
    <form method="GET" action="search" class="grid grid-cols-1 md:grid-cols-4 gap-3">

        <!-- 🔤 ค้นหาชื่อ -->
        <div class="relative md:col-span-2">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                🔍
            </span>
            <input
                type="text"
                name="search"
                value="<?= $_GET['search'] ?? '' ?>"
                placeholder="ค้นหาชื่อกิจกรรม..."
                class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400"
            >
        </div>

        <!-- 📅 วันที่เริ่ม -->
        <input
            type="date"
            name="start_date"
            value="<?= $_GET['start_date'] ?? '' ?>"
            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400"
        >

        <!-- 📅 วันที่สิ้นสุด -->
        <input
            type="date"
            name="end_date"
            value="<?= $_GET['end_date'] ?? '' ?>"
            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400"
        >

        <!-- 🔘 ปุ่ม -->
        <div class="md:col-span-4 flex gap-3">
            <button class="bg-blue-500 text-white px-6 py-3 rounded-xl hover:bg-blue-600 font-semibold">
                ค้นหา
            </button>

            <a href="home" class="px-6 py-3 rounded-xl bg-gray-200 hover:bg-red-400 hover:text-white">
                ล้างค่า
            </a>
        </div>

    </form>
</div>
        <!-- 🔥 Container -->
        <div class="max-w-7xl mx-auto">

            <h1 class="text-3xl font-bold text-gray-700 px-6 pt-6">
                🎫 Upcoming Events
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">

                <?php while ($e = $data['events']->fetch_assoc()): ?>
        <?php
        $joined = $data['joined'] ?? [];
        $status = $joined[$e['event_id']] ?? null;
        $images = explode(',', $e['images']);
        $first_image = $images[0] ?? 'default.jpg';
        ?>
        
        <div onclick="window.location.href='detail?eid=<?= $e['event_id'] ?>&name=<?= urlencode($e['event_name']) ?>'"
            class="bg-white shadow-lg rounded-xl overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 cursor-pointer">
            
            <!-- รูป -->
            <div class="relative">
                <img src="/uploads/<?= htmlspecialchars($first_image) ?>"
                    class="w-full h-64 object-cover object-center">

                <span class="absolute top-3 right-3 bg-blue-500 text-white text-xs px-3 py-1 rounded-full shadow">
                    <?= htmlspecialchars($e['event_date']) ?>
                </span>
            </div>

            <!-- เนื้อหา -->
            <div class="p-5">
                <h2 class="text-xl font-bold text-gray-800">
                    <?= htmlspecialchars($e['event_name']) ?>
                </h2>

                <p class="text-gray-500 text-sm mt-2 line-clamp-3">
                    <?= htmlspecialchars($e['description']) ?>
                </p>

                <p class="text-sm mt-3 text-gray-600">
                    👥 รับเข้าร่วม:
                    <span class="font-semibold text-blue-500">
                        <?= htmlspecialchars($e['max_participants']) ?>
                    </span> คน
                </p>

                <p class="text-sm mt-1 text-gray-600">
                    โดย: <?= htmlspecialchars($e['first_name'] . ' ' . $e['last_name']) ?>
                </p>
                <?php if ($e['cid'] != $data['uid']): ?>
                <?php if($status === 'confirmed') {?>
                    <button 
                        class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition font-semibold" 
                        onclick="event.stopPropagation(); showOtp(<?= $e['event_id'] ?>)">
                        ขอ OTP
                    </button>
                <?php } else {?>
                <?php if ($status): ?>
                    <button disabled onclick="event.stopPropagation()" class="bg-gray-400 w-full py-2 rounded-lg">
                        สมัครแล้ว (<?= htmlspecialchars($status) ?>)
                    </button>
                <?php else: ?>
                    <button onclick="event.stopPropagation(); window.location.href='/join-event?eid=<?= $e['event_id'] ?>'"
                            class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition font-semibold">
                        ขอเข้าร่วม
                    </button>
                <?php endif; ?>
                <?php } ?>
                <?php endif; ?>
            </div>
        </div>

    <?php endwhile; ?>


        </div>

    </div>
<?php include 'otp-modal.php'; ?>
</body>
<script>
    let currentEventId = null;
    function showOtp(eid){
        currentEventId = eid;
        fetch('create-otp-ajax?eid=' + eid)
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(data => {
            if (data.error) {
                alert('Error: ' + data.error);
                return;
            }
            const modal = document.getElementById('otpModal');

            document.getElementById('otpCode').innerText = data.otp;
            startTimer(data.expire);

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        })
        .catch(error => {
            console.error('Error fetching OTP:', error);
            alert('Failed to load OTP. Please try again.');
        });
    }
</script>
</html>