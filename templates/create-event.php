<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- 🔷 Navbar -->
    <nav class="flex justify-between items-center p-4 bg-blue-500 text-white shadow-md">
        <div class="text-xl font-bold">Ticket Consert</div>

        <div class="flex gap-4">
            <button onclick="window.location.href='home'"
                class="px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200">
                Home
            </button>

            <button onclick="window.location.href='creator'"
                class="px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200">
                Creator
            </button>

            <button onclick="window.location.href='logout'" class="px-4 py-2 bg-red-500 rounded hover:bg-red-600">
                Logout
            </button>
        </div>
    </nav>

    <!-- 🔷 Form Container -->
    <div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded shadow">

        <h2 class="text-2xl font-bold mb-6 text-gray-700 text-center">
            Create New Event
        </h2>

        <!-- 🔥 Form -->
        <form action="create-event" method="POST" enctype="multipart/form-data" class="space-y-4">
            <!-- Event Name -->
            <div>
                <label class="block text-gray-600 mb-1">Event Name</label>
                <input type="text" name="name" required
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-gray-600 mb-1">Description</label>
                <textarea name="description" rows="4"
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400"></textarea>
            </div>

            <!-- Event Date -->
            <div>
                <label class="block text-gray-600 mb-1">Event Date</label>
                <input type="date" name="date" required
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Max Participants -->
            <div>
                <label class="block text-gray-600 mb-1">Max Participants</label>
                <input type="number" name="max" min="1" required
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-gray-600 mb-1">Event Images (Multiple)</label>
                <input type="file" name="event_image[]" accept="image/*" multiple class="w-full border rounded px-3 py-2 bg-white">
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600 transition" onclick='return confirmSubmit()'>
                Create Event
            </button>

        </form>

    </div>

</body>
    <script>
        function confirmSubmit(){
            return confirm('ยืนยันการการสร้าง event ของคุณ');
        }
    </script>
</html>