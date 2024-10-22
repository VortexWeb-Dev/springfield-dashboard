<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>

<div class="p-10 w-[80%]">
    <p class="text-xl font-semibold mb-4">Table 1</p>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Name of Agent</th>
                    <th scope="col" class="px-6 py-3">Team</th>
                    <th scope="col" class="px-6 py-3">Commission if Personal Lead</th>
                    <th scope="col" class="px-6 py-3">Commission if Company Lead</th>
                    <th scope="col" class="px-6 py-3">Special Notes</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Adilet Chynystanov</th >
                    <td class="px-6 py-4">No Team</td>
                    <td class="px-6 py-4">50% to Agent / 50% to Company</td>
                    <td class="px-6 py-4">50% to Agent / 50% to Company</td>
                    <td class="px-6 py-4">Adilet to 60% commission on his personal social media clients without kick back. For Adilet it will be applicable from today onwards. So will be applicable from today's SO Uptown deal he closed.</td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Ahmad Hassan</th>
                    <td class="px-6 py-4">Faisal Mushtaq's Team</td>
                    <td class="px-6 py-4">50% to Agent / 50% to Company</td>
                    <td class="px-6 py-4">50% to Agent / 50% to Company</td>
                    <td class="px-6 py-4"></td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">Ali Memon</th>
                    <td class="px-6 py-4">No Team</td>
                    <td class="px-6 py-4">50% to Agent / 50% to Company</td>
                    <td class="px-6 py-4">50% to Agent / 50% to Company</td>
                    <td class="px-6 py-4"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include('includes/footer.php'); ?>