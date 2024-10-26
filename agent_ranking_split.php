<?php
include_once "./crest/crest.php";
include_once "./crest/settings.php";
include('includes/header.php');
include('includes/sidebar.php');

// include the fetch deals page
include_once "./data/fetch_deals.php";
include_once "./data/fetch_users.php";

include_once "./controllers/calculate_agent_rank.php";

//get the filter data from get request
$selected_year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$selected_agent_id = isset($_GET['agent_id']) ? $_GET['agent_id'] : 263;

function getMothwiseFilteredRankings($monthwise_rank_data, $selected_agent_id)
{
    $ranking = [
        // 'id' => [
        //     'name' => 'Name',
        //     'rankings' => [
        //         'Jan' => [
        //             'gross_comms' => 0,
        //             'rank' => 0
        //         ],
        //     ]
        // ]
    ];

    foreach ($monthwise_rank_data as $month => $agents) {
        foreach ($agents as $agent_id => $agent) {
            if ($agent_id == $selected_agent_id) {
                //set the name only once
                if(!isset($ranking[$agent_id]['name'])) {
                    $ranking[$agent_id]['name'] = $agent['name'];
                }
                $ranking[$agent_id]['rankings'][$month]['gross_comms'] = $agent['gross_comms'];
                $ranking[$agent_id]['rankings'][$month]['rank'] = $agent['rank'];
            }
        }
    }

    return $ranking;
}
function getQuaterlyFilteredRankings($quarterly_rank_data, $selected_agent_id)
{
    $ranking = [
        // 'id' => [
        //     'name' => 'Name',
        //     'rankings' => [
        //         'Q1' => [
        //             'gross_comms' => 0,
        //             'rank' => 0
        //         ],
        //     ]
        // ]
    ];

    foreach ($quarterly_rank_data as $quater => $agents) {
        foreach ($agents as $agent_id => $agent) {
            if ($agent_id == $selected_agent_id) {
                //set the name only once
                if(!isset($ranking[$agent_id]['name'])) {
                    $ranking[$agent_id]['name'] = $agent['name'];
                }
                $ranking[$agent_id]['rankings'][$quater]['gross_comms'] = $agent['gross_comms'];
                $ranking[$agent_id]['rankings'][$quater]['rank'] = $agent['rank'];
            }
        }
    }

    return $ranking;
}
function getyearlyFilteredRankings($global_ranking, $selected_agent_id)
{
    $ranking = [
        // 'id' => [
        //     'name' => 'Name',
        //     'rankings' => [
        //         '2024' => [
        //             'gross_comms' => 0,
        //             'rank' => 0
        //         ],
        //     ]
        // ]
    ];

    foreach ($global_ranking as $year => $year_data) {
        foreach ($agents as $agent_id => $agent) {
            if ($agent_id == $selected_agent_id) {
                //set the name only once
                if(!isset($ranking[$agent_id]['name'])) {
                    $ranking[$agent_id]['name'] = $agent['name'];
                }
                $ranking[$agent_id]['rankings'][$month]['gross_comms'] = $agent['gross_comms'];
                $ranking[$agent_id]['rankings'][$month]['rank'] = $agent['rank'];
            }
        }
    }

    return $ranking;
}


if (isset($global_ranking[$selected_year])) {
    // get the sorted agents for the selected year and month
    $monthwise_filtered_ranked_agents = getMothwiseFilteredRankings($global_ranking[$selected_year]['monthwise_rank'], $selected_agent_id);
    $quaterly_filtered_ranked_agents = getQuaterlyFilteredRankings($global_ranking[$selected_year]['quaterly_rank'], $selected_agent_id);
    $quaterly_filtered_ranked_agents = getQuaterlyFilteredRankings($global_ranking, $selected_agent_id);
} else {
    $monthwise_filtered_ranked_agents = [];
}

echo "<pre>";
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
                            <?php
                            $all_agents = getUsers()
                            ?>

                            <?php foreach ($all_agents as $agent): ?>
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