<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>


<?php
include_once "./crest/crest.php";
include_once "./crest/settings.php";
function getAllDeals()
{
    $result = CRest::call('crm.deal.list', [
        'select' => ['*', 'UF_*'],
        'filter' => ['CATEGORY_ID' => 0],
    ]);
    $deals = $result['result'];
    return $deals;
}

$deals = getAllDeals();

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
        'account_receivable' => 0,
    ],
    'February' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'account_receivable' => 0,
    ],
    'March' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'account_receivable' => 0,
    ],
    'April' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'account_receivable' => 0,
    ],
    'May' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'account_receivable' => 0,
    ],
    'June' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'account_receivable' => 0,
    ],
    'July' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'account_receivable' => 0,
    ],
    'August' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'account_receivable' => 0,
    ],
    'September' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'account_receivable' => 0,
    ],
    'October' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'account_receivable' => 0,
    ],
    'November' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'account_receivable' => 0,
    ],
    'December' => [
        'count_of_closed_deals' => 0,
        'property_price' => 0,
        'gross_commission' => 0,
        'net_commission' => 0,
        'total_payment_received' => 0,
        'account_receivable' => 0,
    ],
];

foreach ($deals as $deal) {
    $month = date('F', strtotime($deal['CLOSEDATE']));
    $final_list[$month]['count_of_closed_deals'] += $deal['CLOSED'] == 'Y' ? 1 : 0;
    $final_list[$month]['property_price'] += (int)$deal['OPPORTUNITY'] ?? 0;
    $final_list[$month]['gross_commission'] += (int)explode('|', $deal['UF_CRM_1727871887978'])[0] ?? 0;
    $final_list[$month]['net_commission'] += (int)explode('|', $deal['UF_CRM_1727871971926'])[0] ?? 0;
    $final_list[$month]['total_payment_received'] += (int)explode('|', $deal['UF_CRM_1727628185464'])[0] ?? 0;
    $final_list[$month]['account_receivable'] += $deal['UF_CRM_1727628203466'] ?? 0;
};

echo "<pre>";
print_r($deals);
echo "</pre>";

?>

<div class="p-10 w-[80%]">
    <h2 class="text-xl font-semibold mb-4">WIP</h2>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                        Account Receivable
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($final_list as $month => $details) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
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
                            <?= number_format($details['account_receivable'], 2) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


</div>

<?php include('includes/footer.php'); ?>