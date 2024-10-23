<!-- <nav class="bg-gray-800 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">

        <div class="text-2xl font-bold">
            <a href="index.php" class="hover:text-gray-300">MyApp</a>
        </div>

        <div class="hidden md:flex space-x-4">
            <a href="dashboard.php" class="hover:text-gray-300 <?php echo $current_page === 'dashboard.php' ? 'text-gray-300' : ''; ?>">Dashboard</a>
            <a href="users.php" class="hover:text-gray-300 <?php echo $current_page === 'users.php' ? 'text-gray-300' : ''; ?>">Users</a>
            <a href="products.php" class="hover:text-gray-300 <?php echo $current_page === 'products.php' ? 'text-gray-300' : ''; ?>">Products</a>
            <a href="settings.php" class="hover:text-gray-300 <?php echo $current_page === 'settings.php' ? 'text-gray-300' : ''; ?>">Settings</a>
        </div>

        <div class="flex items-center space-x-2">
            <div class="text-sm md:block hidden">Hello, User</div>
            <button class="bg-gray-700 p-2 rounded-full hover:bg-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A1 1 0 016.293 17h11.414a1 1 0 01.707.293l2.586 2.586a1 1 0 001.414 0l2.293-2.293a1 1 0 00-1.414-1.414l-2.586 2.586a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414l2.121-2.121a1 1 0 01.707-.293h11.414a1 1 0 01.707.293L21 14.707a1 1 0 010 1.414l-2.121 2.121a1 1 0 01-.707.293H6.293a1 1 0 01-.707-.293L3 15.707a1 1 0 010-1.414z" />
                </svg>
            </button>
        </div>

    </div>
</nav> -->

<div class="px-8 py-5 flex justify-between bg-white shadow-md dark:bg-gray-800">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Springfield Dashboard</h2>
    <!-- <div class="flex items-center">
        <a href="overall_deals.php" class="px-4 py-2 mr-4 bg-gray-300 rounded-md dark:bg-gray-700">View Overall Deals</a>
    </div> -->
    <!-- toggle -->
    <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
        </svg>
        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
        </svg>
    </button>
</div>

<script>
    var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Change the icons inside the button based on previous settings
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
    }

    var themeToggleBtn = document.getElementById('theme-toggle');

    themeToggleBtn.addEventListener('click', function() {

        // toggle icons inside button
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        // if set via local storage previously
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }

            // if NOT set via local storage previously
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }

    });
</script>