<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- 🔷 Navbar -->
    <?php include 'header.php'?>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="max-w-xl mx-auto mt-4 px-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
            </div>
        </div>
    <?php endif; ?>
    <!-- 🔷 Form -->
    <div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded shadow">

        <h2 class="text-2xl font-bold mb-6 text-gray-700 text-center">
            Create Account
        </h2>
        <form action="/create-user" method="POST" class="space-y-4">
            <!-- Username -->
            <div>
                <label class="block text-gray-600 mb-1">Username</label>
                <input type="text" name="username" required
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- First Name -->
            <div>
                <label class="block text-gray-600 mb-1">First Name</label>
                <input type="text" name="first_name" required
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Last Name -->
            <div>
                <label class="block text-gray-600 mb-1">Last Name</label>
                <input type="text" name="last_name" required
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-gray-600 mb-1">Email</label>
                <input type="email" name="email" required
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Birthday -->
            <div>
                <label class="block text-gray-600 mb-1">Birthday</label>
                <input type="date" name="birthday" required
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-600 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-gray-600 mb-1">Confirm Password</label>
                <input type="password" name="confirm_password" required
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-gray-600 mb-1">Gender</label>
                <select name="gender" required
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Select Gender --</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="others">Others</option>
                </select>
            </div>

            <!-- Role -->
            <div>
                <label class="block text-gray-600 mb-1">Role</label>
                <select name="role" required
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400">
                    <option value="user">User</option>
                    <option value="creator">Creator</option>
                </select>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">
                Register
            </button>

        </form>

    </div>

</body>
</html>
