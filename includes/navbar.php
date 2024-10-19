<nav class="bg-gray-800 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">

        <!-- Logo or Brand Name -->
        <div class="text-2xl font-bold">
            <a href="index.php" class="hover:text-gray-300">MyApp</a>
        </div>

        <!-- Navigation Links -->
        <div class="hidden md:flex space-x-4">
            <a href="dashboard.php" class="hover:text-gray-300 <?php echo $current_page === 'dashboard.php' ? 'text-gray-300' : ''; ?>">Dashboard</a>
            <a href="users.php" class="hover:text-gray-300 <?php echo $current_page === 'users.php' ? 'text-gray-300' : ''; ?>">Users</a>
            <a href="products.php" class="hover:text-gray-300 <?php echo $current_page === 'products.php' ? 'text-gray-300' : ''; ?>">Products</a>
            <a href="settings.php" class="hover:text-gray-300 <?php echo $current_page === 'settings.php' ? 'text-gray-300' : ''; ?>">Settings</a>
        </div>

        <!-- Profile or Settings Icon -->
        <div class="flex items-center space-x-2">
            <div class="text-sm md:block hidden">Hello, User</div>
            <button class="bg-gray-700 p-2 rounded-full hover:bg-gray-600">
                <!-- Placeholder for an icon, e.g., user profile -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A1 1 0 016.293 17h11.414a1 1 0 01.707.293l2.586 2.586a1 1 0 001.414 0l2.293-2.293a1 1 0 00-1.414-1.414l-2.586 2.586a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414z" />
                </svg>
            </button>
        </div>

    </div>
</nav>