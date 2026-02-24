<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Event Detail - <?= htmlspecialchars($data['event']['event_name']) ?></title>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <?php include 'header.php'; ?>

    <div class="max-w-4xl mx-auto mt-8 px-6">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- รูป -->
            <div class="relative overflow-hidden">
                <div class="slider w-full h-96 relative">
                    <?php
                    $images = explode(',', $data['event']['images']);
                    $has_images = false;
                    foreach ($images as $image) {
                        if (!empty($image)) {
                            $has_images = true;
                            echo '<img src="/uploads/' . htmlspecialchars($image) . '" class="w-full h-96 object-cover object-center absolute top-0 left-0 opacity-0 transition-opacity duration-1000 slide-image">';
                        }
                    }
                    if (!$has_images) {
                        echo '<img src="/uploads/default.jpg" class="w-full h-96 object-cover object-center">';
                    }
                    ?>
                </div>
                <!-- badge วันที่ -->
                <span class="absolute top-4 right-4 bg-blue-500 text-white text-sm px-4 py-2 rounded-full shadow z-10">
                    <?= htmlspecialchars($data['event']['event_date']) ?>
                </span>
            </div>

            <!-- เนื้อหา -->
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">
                    <?= htmlspecialchars($data['event']['event_name']) ?>
                </h1>

                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    <?= htmlspecialchars($data['event']['description']) ?>
                </p>

                <p class="text-gray-600 text-lg mb-6">
                    โดย: <?= htmlspecialchars($data['event']['first_name'] . ' ' . $data['event']['last_name']) ?>
                </p>

                <div class="flex items-center justify-between">
                    <p class="text-lg text-gray-700">
                        👥 เข้าร่วมแล้ว:
                        <span class="font-semibold text-blue-500">
                            <?= $data['registered_count'] ?>
                        </span> /
                        <span class="font-semibold text-gray-500">
                            <?= htmlspecialchars($data['event']['max_participants']) ?>
                        </span> คน
                    </p>

                    <?php if (isset($_SESSION['uid']) && $_SESSION['uid'] == $data['event']['cid']): ?>
                        <!-- ไม่แสดงปุ่มสำหรับ creator -->
                    <?php elseif ($data['status'] === 'confirmed'): ?>
                        <button 
                            class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition font-semibold" 
                            onclick="showOtp(<?= $data['event']['event_id'] ?>)">
                            ขอ OTP
                        </button>
                    <?php elseif ($data['status']): ?>
                        <button disabled class="bg-gray-400 text-white px-6 py-3 rounded-lg">
                            สมัครแล้ว (<?= htmlspecialchars($data['status']) ?>)
                        </button>
                    <?php else: ?>
                        <button onclick="window.location.href='/join-event?eid=<?= $data['event']['event_id'] ?>'"
                            class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition font-semibold">
                            ขอเข้าร่วม
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        const images = document.querySelectorAll('.slide-image');
        let currentIndex = 0;

        if (images.length > 1) {
            images[0].classList.remove('opacity-0');
            images[0].classList.add('opacity-100');

            setInterval(() => {
                images[currentIndex].classList.remove('opacity-100');
                images[currentIndex].classList.add('opacity-0');
                currentIndex = (currentIndex + 1) % images.length;
                images[currentIndex].classList.remove('opacity-0');
                images[currentIndex].classList.add('opacity-100');
            }, 3000);
        } else if (images.length === 1) {
            images[0].classList.remove('opacity-0');
            images[0].classList.add('opacity-100');
        }
    </script>
<?php include 'otp-modal.php'; ?>
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
</body>

</html>