<nav class="flex justify-between items-center p-4 bg-blue-500 text-white shadow-md">
        <div class="text-xl font-bold">Ticket Consert</div>

        <!-- Desktop Navigation -->
        <div class="hidden sm:flex gap-4">
                <button class="px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='home'">
                    Home
                </button>
                <button class="px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='my-event'">
                    My Events
                </button>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'creator') { ?>
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
                <button class="px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='profile'">
                    Profile
                </button>
                <button class="px-4 py-2 bg-white text-red-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='logout'">
                    Logout
                </button>
            <?php } ?>
        </div>

        <!-- Mobile Hamburger Menu -->
        <div class="sm:hidden">
            <button id="mobile-menu-button" class="p-2 rounded-md hover:bg-blue-600 transition">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden sm:hidden bg-blue-500 border-t border-blue-600">
        <div class="flex flex-col p-4 space-y-2">
                <button class="w-full text-left px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='home'">
                    <i class="fas fa-home mr-2"></i>Home
                </button>
                <button class="w-full text-left px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='my-event'">
                    <i class="fas fa-calendar mr-2"></i>My Events
                </button>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'creator') { ?>
                <button class="w-full text-left px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='creator'">
                    <i class="fas fa-plus-circle mr-2"></i>Creator
                </button>
            <?php } ?>
            <?php if(empty($_SESSION['email'])) {?>
            <button class="w-full text-left px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='/register'">
                <i class="fas fa-user-plus mr-2"></i>Register
            </button>
            <button class="w-full text-left px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800 transition" onclick="window.location.href='/login'">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>
            <?php } else {?>
                <button class="w-full text-left px-4 py-2 bg-white text-blue-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='profile'">
                    <i class="fas fa-user mr-2"></i>Profile
                </button>
                <button class="w-full text-left px-4 py-2 bg-white text-red-500 rounded hover:bg-gray-200 transition" onclick="window.location.href='logout'">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            <?php } ?>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const menuButton = document.getElementById('mobile-menu-button');
            
            if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>