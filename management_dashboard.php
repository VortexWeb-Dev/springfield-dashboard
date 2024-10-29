<?php
include_once "./crest/crest.php";
include_once "./crest/settings.php";
include('includes/header.php');
include('includes/sidebar.php');
// include('includes/sidepanel.php');
// get deals
include_once "./data/fetch_deals.php";

// import utils 
include_once "./utils/index.php";

//get the year from get request
$selected_year = isset($_GET['year']) ? explode('/', $_GET['year'])[2] : date('Y');
$developer_name = isset($_GET['developer_name']) ? $_GET['developer_name'] : null;

// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

$filter = [
    'CATEGORY_ID' => 0,
    '>=BEGINDATE' => "$selected_year-01-01",
    '<=BEGINDATE' => "$selected_year-12-31",
];

$deals = get_filtered_deals($filter) ?? [];
$deal_fields = get_deal_fileds();

$developerwise_deals = $deals;

if (!empty($developer_name)) {
    $developerwise_deals = array_filter($deals, function ($deal) use ($developer_name) {
        return $deal['UF_CRM_1727625822094'] == $developer_name;
    });
}

// get the develpers name
include_once "./static/developers.php";
$developers = getDevelopers();

if (!empty($deals)) {

    // get deals per deal type
    function get_deals_per_deal_type($deals, $deal_fields)
    {
        $deal_types = $deal_fields['UF_CRM_1727625752721']['items'] ?? [];

        $deals_per_deal_type = [];

        foreach ($deal_types as $deal_type) {
            $type_id = $deal_type['ID'] ?? null;
            $deal_type_name = map_enum($deal_fields, 'UF_CRM_1727625752721', $type_id) ?? 'Unknown';

            $deals_per_deal_type[$deal_type_name] = array_filter($deals, function ($deal) use ($type_id) {
                return $deal['UF_CRM_1727625752721'] ==  $type_id;
            });
        }

        return $deals_per_deal_type;
    }

    $deals_per_deal_type = get_deals_per_deal_type($deals, $deal_fields);

    // echo "<pre>";
    // print_r($deals_per_deal_type);
    // echo "</pre>";

    function get_closed_deals($deals)
    {
        return array_filter($deals, function ($deal) {
            return $deal['CLOSED'] == 'Y';
        });
    }

    $closed_deals = get_closed_deals($deals);

    function get_formatted_deals(&$deals)
    {

        $final_deals = [
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
            $final_deals['total']['count_of_closed_deals'] += $deal['CLOSED'] == 'Y' ? 1 : 0;
            $final_deals['total']['property_price'] += (int)$deal['OPPORTUNITY'] ?? 0;
            $final_deals['total']['gross_commission'] += (int)explode('|', $deal['UF_CRM_1727871887978'])[0] ?? 0;
            $final_deals['total']['net_commission'] += (int)explode('|', $deal['UF_CRM_1727871971926'])[0] ?? 0;
            $final_deals['total']['total_payment_received'] += (int)explode('|', $deal['UF_CRM_1727628185464'])[0] ?? 0;
            $final_deals['total']['amount_receivable'] += $deal['UF_CRM_1727628203466'] ?? 0;

            $month = date('F', strtotime($deal['BEGINDATE']));
            $final_deals[$month]['count_of_closed_deals'] += $deal['CLOSED'] == 'Y' ? 1 : 0;
            $final_deals[$month]['property_price'] += (int)$deal['OPPORTUNITY'] ?? 0;
            $final_deals[$month]['gross_commission'] += (int)explode('|', $deal['UF_CRM_1727871887978'])[0] ?? 0;
            $final_deals[$month]['net_commission'] += (int)explode('|', $deal['UF_CRM_1727871971926'])[0] ?? 0;
            $final_deals[$month]['total_payment_received'] += (int)explode('|', $deal['UF_CRM_1727628185464'])[0] ?? 0;
            $final_deals[$month]['amount_receivable'] += $deal['UF_CRM_1727628203466'] ?? 0;
        };

        return $final_deals;
    }

    $final_deals = get_formatted_deals($deals);
    $developerwise_final_deals = get_formatted_deals($developerwise_deals);

    $total_deals = array_pop($final_deals);
    $developerwise_total_deals = array_pop($developerwise_final_deals);


    // monthly deals per developer with total monthly and yearly property value
    function get_monthly_deals_per_developer($deals, &$developers)
    {
        $monthlyDealsPerDeveloper = [];

        foreach ($developers as $developer) {
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            foreach ($months as $month) {
                // get monthwise deals
                $monthwiseDeals = array_filter($deals, function ($deal) use ($month) {
                    return date('M', strtotime($deal['BEGINDATE'])) == $month;
                });

                $monthlyDealsPerDeveloper[$developer]['monthly_deals'][$month]['deals'] = array_filter($monthwiseDeals, function ($deal) use ($developer) {
                    return $deal['UF_CRM_1727625822094'] == $developer;
                });

                $monthlyDealsPerDeveloper[$developer]['monthly_deals'][$month]['total_monthly_property_value'] = array_reduce($monthlyDealsPerDeveloper[$developer]['monthly_deals'][$month]['deals'], function ($total, $deal) {
                    return isset($deal['OPPORTUNITY']) ? $total + (int)$deal['OPPORTUNITY'] : $total;
                });
            }

            $monthlyDealsPerDeveloper[$developer]['total_property_value'] = array_reduce($monthlyDealsPerDeveloper[$developer]['monthly_deals'], function ($total, $prev) {
                return isset($prev['total_monthly_property_value']) ? $total + (int)$prev['total_monthly_property_value'] : $total;
            }, 0);
        }

        return $monthlyDealsPerDeveloper;
    }

    $monthly_deals_per_developer = get_monthly_deals_per_developer($deals, $developers);

    // echo "<pre>";
    // print_r($monthly_deals_per_developer);
    // echo "</pre>";


    // Deals per lead source
    function get_deals_per_lead_source($deals, $deal_fields)
    {
        $lead_sources = $deal_fields['UF_CRM_1727854893657']['items'];
        echo "<pre>";
        // print_r($lead_sources);
        echo "</pre>";
        $deals_per_lead_source = [];
        foreach ($lead_sources as $lead_source) {
            $lead_source_id = $lead_source['ID'];
            $lead_source_name = map_enum($deal_fields, 'UF_CRM_1727854893657',  $lead_source_id) ?? 'Unknown';

            $deals_per_lead_source[$lead_source_name] = array_filter($deals, function ($deal) use ($lead_source_id) {
                return $deal['UF_CRM_1727854893657'] ==  $lead_source_id;
            });
        }

        return $deals_per_lead_source;
    }

    $deals_per_lead_source = get_deals_per_lead_source($deals, $deal_fields) ?? [];

    // echo "<pre>";
    // print_r($deals_per_lead_source);
    // echo "</pre>";
}
// echo "<pre>";
// print_r($deals);
// echo "</pre>";

?>

<div class="w-[85%] bg-gray-100 dark:bg-gray-900">
    <?php include('includes/navbar.php'); ?>
    <div class="px-8 py-6">
        <!-- date picker -->
        <div class="mb-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
                <div class="flex justify-between">
                    <div>
                        <h1 class="text-2xl font-bold dark:text-white">Financial Year : <?= $selected_year ?></h1>
                    </div>
                    <div class="flex flex-end justify-end gap-2">
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-actions" datepicker datepicker-buttons datepicker-autoselect-today type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date" name="year">
                        </div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <?php if (empty($final_deals)): ?>
            <div class="h-[65vh] flex justify-center items-center">
                <h1 class="text-2xl font-bold mb-6 dark:text-white">No data available</h1>
            </div>
        <?php else: ?>
            <div>
                <!-- cards container -->
                <div class="mb-6 max-w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 justify-between gap-4">
                    <a href="#" class="block max-w-sm p-6 bg-white border-l-8 rounded-lg shadow border-green-500 hover:shadow-lg dark:bg-gray-800 dark:border-green-300/60 dark:hover:bg-green-200/10">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Total Deals</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400"><?= count($deals) ?></p>
                    </a>
                    <a href="#" class="block max-w-sm p-6 bg-white border-l-8 rounded-lg shadow border-red-500 hover:shadow-lg dark:bg-gray-800 dark:border-red-300/60 dark:hover:bg-red-200/10">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Closed Deals</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400"><?= count($closed_deals) ?></p>
                    </a>
                    <a href="#" class="block max-w-sm p-6 bg-white border-l-8 rounded-lg shadow border-blue-500 hover:shadow-lg dark:bg-gray-800 dark:border-blue-300/60 dark:hover:bg-blue-200/10">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Gross Commission</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400"><?= $total_deals['gross_commission'] ?> AED</p>
                    </a>
                    <a href="#" class="block max-w-sm p-6 bg-white border-l-8 rounded-lg shadow border-orange-500 hover:shadow-lg dark:bg-gray-800 dark:border-orange-300/60 dark:hover:bg-orange-200/10">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Net Commission</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400"><?= $total_deals['net_commission'] ?></p>
                    </a>
                </div>
                <!-- header -->
                <!-- <div class="w-full p-6 bg-white dark:bg-gray-900 border-l-8 shadow border-gray-200 dark:border-gray-700 rounded-sm">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">WIP</h3>
                </div>
            </div> -->
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
                                    <?php foreach ($final_deals as $month => $details) : ?>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
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
                    <div class="w-full flex flex-col justify-between gap-2 col-span-1 p-6 bg-white dark:bg-gray-800 border-t-8 shadow hover:shadow-xl border-green-500 dark:border-green-300/60 rounded-xl">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Property Type</h3>
                        <div id="property-type-chart" class="flex justify-center items-center">

                        </div>
                    </div>
                </div>

                <!-- monthly deals per developer -->
                <div class="my-4 grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <!-- table -->
                    <div class="w-full flex flex-col justify-between gap-2 col-span-1 p-6 bg-white dark:bg-gray-800 border-t-8 shadow hover:shadow-xl border-green-500 dark:border-green-300/60 rounded-xl">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Top Developers</h3>
                        <div id="" class="flex justify-center items-center">

                        </div>
                    </div>
                    <!-- Developer's table -->
                    <div class="w-full h-[70vh] col-span-2 bg-white dark:bg-gray-800 border shadow-xl border-gray-200 dark:border-gray-700 rounded-xl">

                        <!-- select developer filter -->
                        <div class="flex p-2 justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="text-gray-600 dark:text-gray-400 font-semibold text-lg">Developer: </span>
                                <p class="text-gray-600 dark:text-gray-400 font-semibold text-lg bg-gray-200 dark:bg-gray-700 rounded px-2"><?= $developer_name ?? 'All Developers' ?></p>
                            </div>
                            <!-- buttons div -->
                            <div>
                                <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch" data-dropdown-placement="bottom" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    Select Developers
                                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <a href="management_dashboard.php?year=<?= $_GET['year'] ?? date('m/d/Y') ?>" id="clearFilterButton" class="<?= $developer_name ? '' : 'hidden' ?> text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                    Clear Filter
                                </a>
                            </div>
                            <!-- Dropdown menu -->
                            <div id="dropdownSearch" class="z-10 hidden bg-white rounded-lg shadow w-60 dark:bg-gray-700">
                                <div class="p-3">
                                    <label for="input-group-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="input-group-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Developrs">
                                    </div>
                                </div>
                                <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownSearchButton">
                                    <?php foreach ($developers as $index => $developer): ?>
                                        <li id="<?= $developer ?>">
                                            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                                                <div class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <input type="text" name="developer_name" value="<?= $developer ?>" hidden>
                                                    <input type="text" name="year" value="<?= $_GET['year'] ?? date('m/d/Y') ?>" hidden>
                                                    <button type="submit" class="w-full text-start py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"><?= $developer ?></button>
                                                </div>
                                            </form>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <script>
                            document.getElementById('input-group-search').addEventListener('input', function() {
                                var input = this.value.toLowerCase();
                                let developers = <?= json_encode($developers) ?>;

                                // Loop through options and hide those that don't match the search query
                                developers.forEach(function(developer) {
                                    var option = document.getElementById(developer);
                                    var optionText = developer.toLowerCase();
                                    option.style.display = optionText.includes(input) ? 'block' : 'none';
                                });
                            });
                        </script>

                        <div class="relative h-[85%] overflow-auto sm:rounded-lg">
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
                                    <?php foreach ($developerwise_final_deals as $month => $details) : ?>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
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
                                            <?= $developerwise_total_deals['count_of_closed_deals'] ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?= number_format($developerwise_total_deals['property_price'], 2) ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?= number_format($developerwise_total_deals['gross_commission'], 2) ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?= number_format($developerwise_total_deals['net_commission'], 2) ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?= number_format($developerwise_total_deals['total_payment_received'], 2) ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?= number_format($developerwise_total_deals['amount_receivable'], 2) ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- developer/property value -->
                <div class="my-4 w-full flex flex-col justify-between gap-2 p-6 bg-white dark:bg-gray-800 border-t-8 shadow hover:shadow-xl border-green-500 dark:border-green-300/60 rounded-xl">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Developers vs Property Value</h3>
                    <div class="my-4 grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- table -->
                        <div id="" class="col-span-1 flex justify-center items-center">
                            <div class="w-full h-[70vh] col-span-2 bg-white dark:bg-gray-800 border shadow-xl border-gray-200 dark:border-gray-700 rounded-xl">
                                <div class="relative h-full overflow-auto sm:rounded-lg">
                                    <table class="w-full h-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="sticky top-0 text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Developer
                                                </th>
                                                <!-- <?php foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month) : ?>
                                                    <th scope="col" class="px-6 py-3"><?= $month ?></th>
                                                <?php endforeach; ?> -->
                                                <th scope="col" class="px-6 py-3">Total Property value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($developers as $index => $dev) : ?>
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <?= $dev ?>
                                                    </th>
                                                    <!-- <?php foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month) : ?>
                                                        <td class="px-6 py-4">
                                                            <?= number_format($monthly_deals_per_developer[$dev]['monthly_deals'][$month]['total_monthly_property_value'], 2) ?>
                                                        </td>
                                                    <?php endforeach; ?> -->
                                                    <td class="px-6 py-4">
                                                        <?= number_format($monthly_deals_per_developer[$dev]['total_property_value'], 2) ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- chart -->
                        <div id="developer-property-value-chart" class="col-span-2 flex justify-center items-center">

                        </div>
                    </div>
                </div>

                <!-- Deals per lead source -->
                <div class="w-full flex flex-col justify-between gap-2 p-6 bg-white dark:bg-gray-800 border-t-8 shadow hover:shadow-xl border-green-500 dark:border-green-300/60 rounded-xl">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Transaction Breakdown Per Lead Source</h3>
                    <div id="lead-source-chart" class="flex justify-center items-center">

                    </div>
                </div>

                <!-- Extras -->
                <div class="my-8 grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <!-- top properties -->
                    <div class="w-full flex flex-col gap-6 col-span-1 p-6 bg-white dark:bg-gray-800 border-t-8 shadow hover:shadow-xl border-red-500 dark:border-red-300/60 rounded-xl">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Top Properties</h3>
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-row items-center gap-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md p-2">
                                <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-full"></div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">The Peak</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Hong Kong</span>
                                </div>
                            </div>
                            <div class="flex flex-row items-center gap-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md p-2">
                                <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-full"></div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">The Arch</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Hong Kong</span>
                                </div>
                            </div>
                            <div class="flex flex-row items-center gap-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md p-2">
                                <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-full"></div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">The Grandeur</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Hong Kong</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chart 3 -->
                    <div class="w-full flex flex-col justify-between gap-2 col-span-2 p-6 bg-white dark:bg-gray-800 border-t-8 shadow hover:shadow-xl border-blue-500 dark:border-blue-300/60 rounded-xl">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Chart 3</h3>
                        <div id="chart-3">

                        </div>
                    </div>
                </div>
            </div>
    </div>
<?php endif ?>
</div>

<script>
    // get the system theme
    // function getSystemTheme() {
    //     if (window.matchMedia) {
    //         return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
    //     }
    // }


    function isDarkTheme() {
        return localStorage.getItem('darkMode') === 'true';
    }

    let isdark = isDarkTheme();



    // console.log(dealsPerDealType);

    function display_property_type_chart() {
        var dealsPerDealType = <?php echo json_encode($deals_per_deal_type); ?>;

        var offplanDeals = dealsPerDealType['Offplan'].length;
        var secondaryDeals = Object.keys(dealsPerDealType['Secondary']).length;

        // property type
        var options = {
            series: [offplanDeals, secondaryDeals],
            labels: ["Offplan", "Secondary"],
            chart: {
                width: 380,
                type: 'donut',
            },
            dataLabels: {
                enabled: true,
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        show: false
                    }
                }
            }],
            legend: {
                position: 'top',
                offsetY: 0,
                // height: 230,
                labels: {
                    colors: `${isdark ? '#ffffff' : '#000000'}`
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#property-type-chart"), options);
        chart.render();
    }

    display_property_type_chart();

    function display_developer_property_value_chart() {
        let developersData = <?php echo json_encode($monthly_deals_per_developer); ?>;

        let developers = Object.keys(developersData);
        let property_values = [];
        developersData.forEach(developer => {
            psroperty_values.push(developer['total_property_value']);
        })

        let options = {
            series: [5, 5, 6],
            labels: ['a', 'b', 'c'],
            chart: {
                width: 600,
                type: 'donut',
            },
            plotOptions: {
                pie: {
                    startAngle: -90,
                    endAngle: 270
                }
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'gradient',
            },
            legend: {
                formatter: function(val, opts) {
                    return val + " - " + opts.w.globals.series[opts.seriesIndex]
                },
                labels: {
                    colors: `${isdark ? '#ffffff' : '#000000'}`
                }
            },
            title: {
                // text: 'Developers VS Property Value',
                style: {
                    color: `${isdark ? '#ffffff' : '#000000'}`
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            colors: `${isdark ? '#ffffff' : '#000000'}`
                        }
                    }
                }
            }]
        };

        let chart = new ApexCharts(document.querySelector("#developer-property-value-chart"), options);
        chart.render();
    }

    display_developer_property_value_chart();

    function display_lead_source_chart() {

        let deals_per_lead_source = <?php echo json_encode($deals_per_lead_source); ?>;
        let categories = [];
        let net_commission = {};
        let gross_commission = {};

        for (x in deals_per_lead_source) {
            // console.log(deals_per_lead_source[x]);
            categories.push(x);

            // initialise_commission_array for all types of leads
            if (net_commission[x] == null) {
                net_commission[x] = 0;
            }

            if (gross_commission[x] == null) {
                gross_commission[x] = 0;
            }

            deals_per_lead_source[x].forEach(deal => {
                if (deal['UF_CRM_1727871971926'] != null) {
                    net_commission[x] += parseFloat(deal['UF_CRM_1727871971926'].split('|')[0]);
                }

                if (deal['UF_CRM_1727871887978'] != null) {
                    gross_commission[x] += parseFloat(deal['UF_CRM_1727871887978'].split('|')[0]);
                }
            });
        }

        let net_commission_values = Object.values(net_commission);
        let gross_commission_values = Object.values(gross_commission);

        let options = {
            series: [{
                name: 'Net Commission',
                data: [...net_commission_values]
            }, {
                name: 'Gross Commission',
                data: [...gross_commission_values]
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: [...categories],
                labels: {
                    style: {
                        colors: `${isdark ? '#ffffff' : '#000000'}`
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'AED',
                    style: {
                        color: `${isdark ? '#ffffff' : '#000000'}`
                    }
                },
                labels: {
                    style: {
                        colors: `${isdark ? '#ffffff' : '#000000'}`
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " AED"
                    }
                }
            },
            legend: {
                labels: {
                    colors: `${isdark ? '#ffffff' : '#000000'}`
                }
            }
        };

        let chart = new ApexCharts(document.querySelector("#lead-source-chart"), options);
        chart.render();
    }

    display_lead_source_chart();

    // chart 2
   
    var options = {
          series: [{
          name: "STOCK ABC",
          data: series.monthDataSeries1.prices
        }],
          chart: {
          type: 'area',
          height: 350,
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        
        title: {
          text: 'Fundamental Analysis of Stocks',
          align: 'left'
        },
        subtitle: {
          text: 'Price Movements',
          align: 'left'
        },
        labels: series.monthDataSeries1.dates,
        xaxis: {
          type: 'datetime',
        },
        yaxis: {
          opposite: true
        },
        legend: {
          horizontalAlign: 'left'
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart-3"), options);
        chart.render();
</script>

<?php include('includes/footer.php'); ?>