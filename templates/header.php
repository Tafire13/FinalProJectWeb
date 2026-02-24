<nav class="flex justify-between items-center p-4 bg-blue-500 text-white shadow-md">
        <div class="text-xl font-bold">Ticket Consert</div>

        <div class="flex gap-4">
                <button class="px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='home'">
                    Home
                </button>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'creator') { ?>
                <button class="px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='dashboard'">
                    DashBoard
                </button>
                <button class="px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='creator'">
                    Creator
                </button>
            <?php } ?>
            <?php if(empty($_SESSION['email'])) {?>
            <button class="px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='/register'">
                Register
            </button>
            <button class="px-4 py-2 bg-blue-700 rounded hover:bg-blue-800 transition" onclick="window.location.href='/login'">
                Login
            </button>
            <?php } else {?>
                <button class="px-4 py-2 bg-white text-red-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='logout'">
                    Logout
                </button>
            <?php } ?>
        </div>
    </nav>