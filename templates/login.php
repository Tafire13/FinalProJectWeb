<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- 🔷 Navbar -->
    <?php include 'header.php'?>

    <!-- 🔷 Login Form -->
    <div class="max-w-md mx-auto mt-12 bg-white p-8 rounded shadow">

        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">
            Login to your account
        </h2>

        <!-- 🔔 Message -->
        <?php if (!empty($data['message'])) { ?>
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded text-center">
                <?= htmlspecialchars($data['message']) ?>
            </div>
        <?php } ?>

        <form action="login" method="POST" class="space-y-4">

            <!-- Email -->
            <div>
                <label class="block text-gray-600 mb-1">Email</label>
                <input type="email" name="email" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-600 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">
                Login
            </button>

        </form>

        <!-- 🔹 link ไป register -->
        <p class="text-center text-gray-600 mt-4">
            Don't have an account?
            <a href="register" class="text-blue-500 hover:underline">
                Register here
            </a>
        </p>

    </div>

</body>
</html>
