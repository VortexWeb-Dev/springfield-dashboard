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

<div class="w-[85%] bg-gray-100 dark:bg-gray-900">
    <?php include('includes/navbar.php'); ?>
    <div class="px-8 py-6">
        <!-- cards container -->
        <div class="mb-6 max-w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 justify-between gap-4">
            <a href="#" class="block max-w-sm p-6 bg-white border-l-8 rounded-lg shadow border-green-500 hover:shadow-lg dark:bg-gray-800 dark:border-green-300/60 dark:hover:bg-green-200/10">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
            </a>
            <a href="#" class="block max-w-sm p-6 bg-white border-l-8 rounded-lg shadow border-red-500 hover:shadow-lg dark:bg-gray-800 dark:border-red-300/60 dark:hover:bg-red-200/10">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
            </a>
            <a href="#" class="block max-w-sm p-6 bg-white border-l-8 rounded-lg shadow border-blue-500 hover:shadow-lg dark:bg-gray-800 dark:border-blue-300/60 dark:hover:bg-blue-200/10">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
            </a>
            <a href="#" class="block max-w-sm p-6 bg-white border-l-8 rounded-lg shadow border-orange-500 hover:shadow-lg dark:bg-gray-800 dark:border-orange-300/60 dark:hover:bg-orange-200/10">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
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
                            <?php foreach ($final_list as $month => $details) : ?>
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
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Chart</h3>
                <div id="chart-1" class="">

                </div>
            </div>
        </div>

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

<script>
    // get the system theme
    function getSystemTheme() {
        if (window.matchMedia) {
            return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
    }

    let current_theme = getSystemTheme();

    var options1 = {
        series: [44, 55, 13, 33],
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
                colors: `${current_theme == 'dark' ? '#ffffff' : '#000000'}`
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart-1"), options1);
    chart.render();


    // function appendData() {
    //     var arr = chart.w.globals.series.slice()
    //     arr.push(Math.floor(Math.random() * (100 - 1 + 1)) + 1)
    //     return arr;
    // }

    // function removeData() {
    //     var arr = chart.w.globals.series.slice()
    //     arr.pop()
    //     return arr;
    // }

    // function randomize() {
    //     return chart.w.globals.series.map(function() {
    //         return Math.floor(Math.random() * (100 - 1 + 1)) + 1
    //     })
    // }

    // function reset() {
    //     return options.series
    // }

    // document.querySelector("#randomize").addEventListener("click", function() {
    //     chart.updateSeries(randomize())
    // })

    // document.querySelector("#add").addEventListener("click", function() {
    //     chart.updateSeries(appendData())
    // })

    // document.querySelector("#remove").addEventListener("click", function() {
    //     chart.updateSeries(removeData())
    // })

    // document.querySelector("#reset").addEventListener("click", function() {
    //     chart.updateSeries(reset())
    // })

    // chart 2
    var options2 = {
        series: [{
            name: 'series1',
            data: [31, 40, 28, 51, 42, 109, 100],
        }, {
            name: 'series2',
            data: [11, 32, 45, 32, 34, 52, 41]
        }],
        chart: {
            height: 350,
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            type: 'datetime',
            categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"],
            labels: {
                style: {
                    colors: `${current_theme == 'dark' ? '#ffffff' : '#000000'}`
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: `${current_theme == 'dark' ? '#ffffff' : '#000000'}`
                }
            }
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
        legend: {
            labels: {
                colors: `${current_theme == 'dark' ? '#ffffff' : '#000000'}`
            }
        }
    };
    var chart2 = new ApexCharts(document.querySelector("#chart-3"), options2);
    chart2.render();
</script>

<?php include('includes/footer.php'); ?>