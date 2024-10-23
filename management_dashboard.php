<?php
include_once "./crest/crest.php";
include_once "./crest/settings.php";
include('includes/header.php');
include('includes/sidebar.php');
// include('includes/sidepanel.php');
// get deals
include_once "./data/fetch_deals.php";

$deals = get_all_deals();

function get_closed_deals($deals)
{
    return array_filter($deals, function ($deal) {
        return $deal['CLOSED'] == 'Y';
    });
}

$closed_deals = get_closed_deals($deals);

$final_list = [
    'January' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
    'February' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
    'March' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
    'April' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
    'May' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
    'June' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
    'July' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
    'August' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
    'September' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
    'October' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
    'November' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
    'December' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
    'total' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'amount_receivable' => 0,
    ],
];

foreach ($deals as $deal) {
    $final_list['total']['count_of_closed_deals'] += $deal['CLOSED'] == 'Y' ? 1 : 0;
    $final_list['total']['property_price'] += (int)$deal['OPPORTUNITY'] ?? 0;
    $final_list['total']['gross_commission'] += (int)explode('|', $deal['UF_CRM_1727871887978'])[0] ?? 0;
    $final_list['total']['net_commission'] += (int)explode('|', $deal['UF_CRM_1727871971926'])[0] ?? 0;
    $final_list['total']['total_payment_received'] += (int)explode('|', $deal['UF_CRM_1727628185464'])[0] ?? 0;
    $final_list['total']['amount_receivable'] += $deal['UF_CRM_1727628203466'] ?? 0;

    $month = date('F', strtotime($deal['BEGINDATE']));
    $final_list[$month]['count_of_closed_deals'] += $deal['CLOSED'] == 'Y' ? 1 : 0;
    $final_list[$month]['property_price'] += (int)$deal['OPPORTUNITY'] ?? 0;
    $final_list[$month]['gross_commission'] += (int)explode('|', $deal['UF_CRM_1727871887978'])[0] ?? 0;
    $final_list[$month]['net_commission'] += (int)explode('|', $deal['UF_CRM_1727871971926'])[0] ?? 0;
    $final_list[$month]['total_payment_received'] += (int)explode('|', $deal['UF_CRM_1727628185464'])[0] ?? 0;
    $final_list[$month]['amount_receivable'] += $deal['UF_CRM_1727628203466'] ?? 0;
};

$total_deals = array_pop($final_list);

// echo "<pre>";
// print_r($deals);
// echo "</pre>";

?>

<div class="bg-gray-100 dark:bg-[#141418]">
    <div class="px-8 py-5 flex justify-between  bg-gray-100 dark:bg-[#23232E]">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Springfield Dashboard</h2>
        <div class="flex items-center">
            <a href="overall_deals.php" class="px-4 py-2 mr-4 bg-gray-300 rounded-md dark:bg-gray-700">View Overall Deals</a>
        </div>
    </div>
    <div class="px-8 py-6">
        <!-- <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">WIP</h2> -->

        <!-- cards container -->
        <div class="mb-6 max-w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 justify-between gap-4">
            <a href="#" class="block max-w-sm p-6 bg-white border-l-8 border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#23232E] dark:border-green-300/60 dark:hover:bg-green-200/10">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
            </a>
            <a href="#" class="block max-w-sm p-6 bg-white border-l-8 border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#23232E] dark:border-red-300/60 dark:hover:bg-red-200/10">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
            </a>
            <a href="#" class="block max-w-sm p-6 bg-white border-l-8 border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#23232E] dark:border-blue-300/60 dark:hover:bg-blue-200/10">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
            </a>
            <a href="#" class="block max-w-sm p-6 bg-white border-l-8 border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-[#23232E] dark:border-pink-300/60 dark:hover:bg-pink-200/10">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
            </a>
        </div>
        <!-- header -->
        <div class="w-full p-6 bg-white dark:bg-[#141418] border-l-8 shadow-xl border-gray-200 dark:border-gray-700 rounded-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">WIP</h3>
            </div>
        </div>
        <div class="my-4 grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- table container -->
            <div class="w-full h-[65vh] col-span-2 bg-white dark:bg-gray-800 border shadow-xl border-gray-200 dark:border-gray-700 rounded-xl">
                <div class="relative h-full overflow-auto sm:rounded-lg">
                    <table class="w-full h-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="sticky top-0 text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Month
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Count of Closed Deals
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Property Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Gross Commission
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Net Commission
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total Payment Received
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Amount Receivable
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($final_list as $month => $details) : ?>
                                <tr class="bg-white border-b dark:bg-[#23232E] dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?= $month ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?= $details['count_of_closed_deals'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= number_format($details['property_price'], 2) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= number_format($details['gross_commission'], 2) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= number_format($details['net_commission'], 2) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= number_format($details['total_payment_received'], 2) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= number_format($details['amount_receivable'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="sticky bottom-0 text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="row" class="px-6 py-4 font-medium font-bold whitespace-nowrap">
                                    Total
                                </th>
                                <td class="px-6 py-4">
                                    <?= $total_deals['count_of_closed_deals'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= number_format($total_deals['property_price'], 2) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= number_format($total_deals['gross_commission'], 2) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= number_format($total_deals['net_commission'], 2) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= number_format($total_deals['total_payment_received'], 2) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= number_format($total_deals['amount_receivable'], 2) ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- chart -->
            <div class="w-full col-span-1 p-6 bg-white dark:bg-[#23232E] border-t-8 shadow-xl border-gray-200 dark:border-green-300/60 rounded-xl">

            </div>
        </div>

        <div class="my-8 grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- table container -->
            <div class="w-full h-[50vh] col-span-1 bg-white dark:bg-[#23232E] border-t-8 shadow-xl border-gray-200 dark:border-red-300/60 rounded-xl">

            </div>

            <!-- chart -->
            <div class="w-full col-span-2 p-6 bg-white dark:bg-[#23232E] border-t-8 shadow-xl border-gray-200 dark:border-blue-300/60 rounded-xl">

            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>