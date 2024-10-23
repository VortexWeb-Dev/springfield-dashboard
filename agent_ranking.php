<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>

<div class="w-[85%] bg-gray-100 dark:bg-gray-900">
    <?php include('includes/navbar.php'); ?>
    <div class="px-8 py-6">
        <p class="text-2xl font-bold dark:text-white mb-4">Agent Ranking</p>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Agent</th>
                        <th scope="col" class="px-6 py-3">Jan 2024</th>
                        <th scope="col" class="px-6 py-3">Feb 2024</th>
                        <th scope="col" class="px-6 py-3">Mar 2024</th>
                        <th scope="col" class="px-6 py-3">Apr 2024</th>
                        <th scope="col" class="px-6 py-3">May 2024</th>
                        <th scope="col" class="px-6 py-3">Jun 2024</th>
                        <th scope="col" class="px-6 py-3">Jul 2024</th>
                        <th scope="col" class="px-6 py-3">Aug 2024</th>
                        <th scope="col" class="px-6 py-3">Sep 2024</th>
                        <th scope="col" class="px-6 py-3">Grand Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Agent 1</th>
                        <td class="px-6 py-4">10</td>
                        <td class="px-6 py-4">20</td>
                        <td class="px-6 py-4">30</td>
                        <td class="px-6 py-4">40</td>
                        <td class="px-6 py-4">50</td>
                        <td class="px-6 py-4">60</td>
                        <td class="px-6 py-4">70</td>
                        <td class="px-6 py-4">80</td>
                        <td class="px-6 py-4">90</td>
                        <td class="px-6 py-4">100</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>