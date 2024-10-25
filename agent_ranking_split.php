<?php
include_once "./crest/crest.php";
include_once "./crest/settings.php";
include('includes/header.php');
include('includes/sidebar.php');

// include the fetch deals page
include_once "./data/fetch_deals.php";
include_once "./data/fetch_users.php";

// import utility functions
include_once "./utils/index.php";


$global_ranking = [
    2024 => [
        'Jan' => [],
        'Feb' => [],
        'Mar' => [],
        'Apr' => [],
        'May' => [],
        'Jun' => [],
        'Jul' => [],
        'Aug' => [],
        'Sep' => [],
        'Oct' => [],
        'Nov' => [],
        'Dec' => []
    ]
];

$deal_filters = [];
$deal_selects = ['BEGINDATE', 'ASSIGNED_BY_ID', 'UF_CRM_1727871887978'];
$deal_orders = ['UF_CRM_1727871887978' => 'DESC', 'BEGINDATE' => 'DESC'];
// sorted deals
$sorted_deals = get_filtered_deals($deal_filters, $deal_selects, $deal_orders);

// store the sorted agent details from the deals to the ranking array
function store_agents($sorted_deals, &$global_ranking)
{
    foreach ($sorted_deals as $deal) {
        $date = date('Y-m-d', strtotime($deal['BEGINDATE']));
        $year = date('Y', strtotime($deal['BEGINDATE']));
        $month = date('M', strtotime($deal['BEGINDATE']));

        $gross_comms = isset($deal['UF_CRM_1727871887978']) ? (int)explode('|', $deal['UF_CRM_1727871887978'])[0] : 0;

        // get agent name
        $agent = getUser($deal['ASSIGNED_BY_ID']);
        $agent_full_name = $agent['NAME'] ?? '' . $agent['SECOND_NAME'] ?? '' . ' ' . $agent['LAST_NAME'] ?? '';

        $global_ranking[$year][$month][$deal['ASSIGNED_BY_ID']]['name'] = $agent_full_name ?? null;

        // initialise gross_comms for first time
        if (!isset($global_ranking[$year][$month][$deal['ASSIGNED_BY_ID']]['gross_comms'])) {
            $global_ranking[$year][$month][$deal['ASSIGNED_BY_ID']]['gross_comms'] = $gross_comms;
        } else {
            $global_ranking[$year][$month][$deal['ASSIGNED_BY_ID']]['gross_comms'] += $gross_comms;
        }
    }
}

store_agents($sorted_deals, $global_ranking);


$agents = getUsers();

// store the remaining agents details from the users
function store_remaining_agents($agents, &$global_ranking)
{
    foreach ($global_ranking as $year => $months) {
        foreach ($months as $month_name => $month_data) {
            foreach ($agents as $id => $agent) {
                $agent_id = $id ?? 0;
                if (!isset($global_ranking[$year][$month_name][$agent_id])) {
                    $agent_full_name = $agent['NAME'] ?? '';
                    $global_ranking[$year][$month_name][$agent_id]['name'] = $agent_full_name ?? null;
                    $global_ranking[$year][$month_name][$agent_id]['gross_comms'] = 0;
                }
            }
        }
    }
}

store_remaining_agents($agents, $global_ranking);

// put id = 263 as it is missing in the agents list
foreach ($global_ranking as $year => $months) {
    foreach ($months as $month_name => $month_data) {
        $agent_id = 263;
        $agent = getUser($agent_id);
        $agent_full_name = $agent['NAME'] ?? '';
        if (!isset($global_ranking[$year][$month_name][$agent_id])) {
            $global_ranking[$year][$month_name][$agent_id]['name'] = $agent_full_name ?? null;
            $global_ranking[$year][$month_name][$agent_id]['gross_comms'] = 0;
        }
    }
}

//assign rank to each agent in each month of each year
function assign_rank(&$global_ranking)
{
    foreach ($global_ranking as $year => &$months) {
        foreach ($months as &$agents) {
            uasort($agents, function ($a, $b) {
                return $b['gross_comms'] <=> $a['gross_comms'];
            });

            $rank = 1;
            $previous_gross_comms = null;
            foreach ($agents as &$agent) {
                if ($previous_gross_comms !== null && $agent['gross_comms'] == $previous_gross_comms) {
                    $agent['rank'] = $rank;
                } else {
                    $agent['rank'] = $rank;
                    $previous_gross_comms = $agent['gross_comms'];
                    $rank++;
                }
            }
        }
    }
}

assign_rank($global_ranking);


//get the filter data from get request
$selected_year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$selected_month = isset($_GET['month']) ? $_GET['month'] : date('M');


function getFilteredRankings($global_ranking, $selected_year, $selected_month)
{

    // sorted agents based on year and month
    $ranking =  [
        // 'agent_id' =>[
        //     'jan' => [
        //         'name' => 'name',
        //         'gross_comms' => 0,
        //         'rank' => 0
        //     ],
        //     'feb' => [
        //         'name' => 'name',
        //         'gross_comms' => 0,
        //         'rank' => 0
        //     ],
        // ]
    ];

    // $ids = array_keys($global_ranking[$selected_year][$selected_month]);

    foreach ($global_ranking[$selected_year] as $month => $agents) {
        foreach ($agents as $agent_id => $agent) {
            $ranking[$agent_id][$month]['name'] = $agent['name'];
            $ranking[$agent_id][$month]['gross_comms'] = $agent['gross_comms'];
            $ranking[$agent_id][$month]['rank'] = $agent['rank'];
        }
    }

    uasort($ranking, function ($a, $b) use ($selected_month) {
        return $a[$selected_month]['rank'] <=> $b[$selected_month]['rank'];
    });

    return $ranking;
}

if (isset($global_ranking[$selected_year])) {
    // get the sorted agents for the selected year and month
    $filtered_ranked_agents = getFilteredRankings($global_ranking, $selected_year, $selected_month);
} else {
    $filtered_ranked_agents = [];
}

$selected_agent  = $filtered_ranked_agents[0] ?? 1;

echo "<pre>";
// print_r($agents);
// print_r($global_ranking);
// print_r($sorted_deals);
// print_r($filtered_ranked_agents);
echo "</pre>";
?>

<div class="w-[85%] bg-gray-100 dark:bg-gray-900">
    <?php include('includes/navbar.php'); ?>
    <div class="px-8 py-6">
        <p class="text-2xl font-bold dark:text-white mb-4">Agent Ranking Split</p>
        <div class="max-w-7xl mx-auto">
            <!-- agent filter -->
            <form action="" method="get">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Year:</label>
                        <select id="year" name="year" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <?php for ($i = 2020; $i <= date('Y'); $i++): ?>
                                <option value="<?= $i ?>" <?= $i == $selected_year ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label for="agent" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Agent:</label>
                        <select id="agent" name="agent" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <?php foreach ($agents as $agent): ?>
                                <option value="<?= $agent['ID'] ?>" <?= $agent['ID'] == $selected_agent ? 'selected' : '' ?>><?= $agent['NAME'] ?? '' . ' ' . $agent['LAST_NAME'] ?? '' . ' ( ID: ' . $agent['ID'] . ')' ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Apply
                    </button>
                </div>
            </form>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Monthly Ranking -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm h-[400px] flex flex-col gap-1">
                    <h2 class="text-xl font-semibold mb-6 dark:text-white">Monthly Ranking</h2>
                    <div class="mb-2">
                        <label for="monthly-agent" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Agent Name</label>
                        <input type="text" id="monthly-agent" name="monthly-agent" class="mt-1 block w-full border-b border-gray-400 dark:bg-gray-700">
                    </div>
                    <!-- Add more content for monthly ranking here -->
                    <div class="overflow-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Month</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rank</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sales</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">January</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">3</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">$50,000</td>
                                </tr>
                                <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">January</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">3</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">$50,000</td>
                                </tr>
                                <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">January</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">3</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">$50,000</td>
                                </tr>
                                <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">January</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">3</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">$50,000</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quaterly Ranking -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm h-[400px] flex flex-col gap-1">
                    <h2 class="text-xl font-semibold mb-6 dark:text-white">Quaterly Ranking</h2>
                    <div class="mb-2">
                        <label for="quaterly-agent" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Agent Name</label>
                        <input type="text" id="quaterly-agent" name="quaterly-agent" class="mt-1 block w-full border-b border-gray-400 dark:bg-gray-700">
                    </div>
                    <!-- Add more content for quaterly ranking here -->
                    <div class="overflow-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quarter</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rank</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sales</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200 font-medium">Q1</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">2</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">$165,000</td>
                                </tr>
                                <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200 font-medium">Q2</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">1</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">$180,000</td>
                                </tr>
                                <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200 font-medium">Q3</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">3</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">$155,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Yearly Ranking -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm h-[400px] flex flex-col gap-1">
                    <h2 class="text-xl font-semibold mb-6 dark:text-white">Yearly Ranking</h2>
                    <div class="mb-2">
                        <label for="yearly-agent" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Agent Name</label>
                        <input type="text" id="yearly-agent" name="yearly-agent" class="mt-1 block w-full border-b border-gray-400 dark:bg-gray-700">
                    </div>
                    <!-- Add more content for yearly ranking here -->
                    <div class="overflow-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Year</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rank</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sales</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-500">
                                <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200 font-medium">2021</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">3</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">$500,000</td>
                                </tr>
                                <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200 font-medium">2022</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">1</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">$650,000</td>
                                </tr>
                                <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200 font-medium">2023</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">2</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">$600,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include('includes/footer.php'); ?>