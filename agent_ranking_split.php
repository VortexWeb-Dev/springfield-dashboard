<?php
include_once "./crest/crest.php";
include_once "./crest/settings.php";
include('includes/header.php');
include('includes/sidebar.php');

// include the fetch deals page
include_once "./data/fetch_deals.php";
include_once "./data/fetch_users.php";

include_once "./controllers/calculate_agent_rank.php";

$global_ranking = calculateAgentRank();

//get the filter data from get request
$selected_year = isset($_GET['year']) ? explode('/', $_GET['year'])[2] : date('Y');

$selected_agent_id = isset($_GET['agent_id']) ? $_GET['agent_id'] : 1;

$current_agent = getUser($selected_agent_id);
$current_agent_name = $current_agent['NAME'] ?? '' . ' ' . $current_agent['LAST_NAME'] ?? '' . ' ( ID: ' . $current_agent['ID'] . ')';

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
                if (!isset($ranking[$agent_id]['name'])) {
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
                if (!isset($ranking[$agent_id]['name'])) {
                    $ranking[$agent_id]['name'] = $agent['name'];
                }
                $ranking[$agent_id]['rankings'][$quater]['gross_comms'] = $agent['gross_comms'];
                $ranking[$agent_id]['rankings'][$quater]['rank'] = $agent['rank'];
            }
        }
    }

    return $ranking;
}
function getYearlyFilteredRankings($global_ranking, $selected_agent_id)
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
        foreach ($year_data['yearly_rank'] as $agent_id => $agent) {
            if ($agent_id == $selected_agent_id) {
                //set the name only once
                if (!isset($ranking[$agent_id]['name'])) {
                    $ranking[$agent_id]['name'] = $agent['name'];
                }
                $ranking[$agent_id]['rankings'][$year]['gross_comms'] = $agent['gross_comms'];
                $ranking[$agent_id]['rankings'][$year]['rank'] = $agent['rank'];
            }
        }
    }

    return $ranking;
}

$monthwise_ranked_agents = [];
$quarterly_ranked_agents = [];
$yearly_ranked_agents = [];

if (isset($global_ranking[$selected_year]['monthwise_rank'])) {
    $monthwise_ranked_agents = getMothwiseFilteredRankings($global_ranking[$selected_year]['monthwise_rank'], $selected_agent_id) ?? [];
}

if (isset($global_ranking[$selected_year]['quarterly_rank'])) {
    $quarterly_ranked_agents = getQuaterlyFilteredRankings($global_ranking[$selected_year]['quarterly_rank'], $selected_agent_id) ?? [];
}

$yearly_ranked_agents = getYearlyFilteredRankings($global_ranking, $selected_agent_id) ?? [];

echo "<pre>";
// print_r($monthwise_ranked_agents);
// print_r($quarterly_ranked_agents);
// print_r($yearly_ranked_agents);
echo "</pre>";
?>

<div class="w-[85%] bg-gray-100 dark:bg-gray-900">
    <?php include('includes/navbar.php'); ?>

    <div class="px-8 py-6">
        <?php include('./includes/datepicker.php'); ?>

        <h1 class="text-xl text-center font-bold mb-4 dark:text-gray-200"><?= $current_agent_name ?>'s Rankings</h1>
        <div class="max-w-7xl mx-auto">
            <!-- agent filter -->

            <div class="flex p-2 justify-between items-center">
                <!-- buttons div -->
                <div class="flex items-center gap-2">
                    <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch" data-dropdown-placement="bottom" class="white-gary-800 dark:text-white border border-blue-800 hover:bg-blue-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        Select Agents
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
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
                        <?php
                        $all_agents = getUsers();
                        $current_agent = getUser($selected_agent_id);
                        $agent_name = $current_agent['NAME'] ?? '' . ' ' . $current_agent['LAST_NAME'] ?? '' . ' ( ID: ' . $current_agent['ID'] . ')';
                        ?>

                        <?php foreach ($all_agents as $agent): ?>
                            <li id="<?= $agent['ID'] ?>" class="mb-1 <?= isset($_GET['agent_id']) && $agent['ID'] == $_GET['agent_id'] ? 'bg-gray-600 text-white' : 'text-gray-900' ?>">
                                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                                    <div class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <input type="text" name="year" value="<?= $_GET['year'] ?? date('m/d/Y') ?>" hidden>
                                        <input type="text" id="agent_id" name="agent_id" value="<?= $agent['ID'] ?>" hidden>
                                        <button type="submit" <?= isset($_GET['agent_id']) && $agent['ID'] == $_GET['agent_id'] ? 'disabled' : '' ?> class="w-full text-start py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"><?= $agent['NAME'] ?? '' . ' ' . $agent['LAST_NAME'] ?? '' . ' ( ID: ' . $agent['ID'] . ')' ?></button>
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
                    let agents = <?= json_encode($all_agents) ?>;
                    console.log(agents);

                    // Loop through options and hide those that don't match the search query
                    agents.forEach(function(agent) {
                        let agentName = `${agent['NAME'] ?? ''} ${agent['SECOND_NAME'] ?? ''} ${agent['LAST_NAME'] ?? ''}`;
                        var option = document.getElementById(agent['ID']);
                        var optionText = agentName.toLowerCase();
                        option.style.display = optionText.includes(input) ? 'block' : 'none';
                    });
                });
            </script>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Monthly Ranking -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm h-[400px] flex flex-col gap-1">
                    <h2 class="text-xl font-semibold mb-6 dark:text-white">Monthly Ranking</h2>
                    <div class="mb-2">
                        <label for="monthly-agent" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white"><?= $agent_name ?></label>
                        <input type="text" id="monthly-agent" name="monthly-agent" class="mt-1 block w-full border-b border-gray-600 dark:bg-gray-800">
                    </div>
                    <?php if (empty($monthwise_ranked_agents)): ?>
                        <p class="text-gray-600 dark:text-gray-400">No data available.</p>
                    <?php else: ?>
                        <div class="overflow-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Month</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rank</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Gross Comm</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                                    <?php foreach ($monthwise_ranked_agents[$selected_agent_id]['rankings'] as  $month_name => $month): ?>
                                        <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-200"><?= $month_name ?></td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-200"><?= $month['rank'] ?></td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-200"><?= $month['gross_comms'] ?> AED</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Quaterly Ranking -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm h-[400px] flex flex-col gap-1">
                    <h2 class="text-xl font-semibold mb-6 dark:text-white">Quaterly Ranking</h2>
                    <div class="mb-2">
                        <label for="monthly-agent" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white"><?= $agent_name ?></label>
                        <input type="text" id="quaterly-agent" name="quaterly-agent" class="mt-1 block w-full border-b border-gray-600 dark:bg-gray-800">
                    </div>
                    <!-- Add more content for quaterly ranking here -->
                    <?php if (empty($quarterly_ranked_agents)): ?>
                        <p class="text-gray-600 dark:text-gray-400">No data available.</p>
                    <?php else: ?>
                        <div class="overflow-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quarter</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rank</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Gross Comm</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                                    <?php foreach ($quarterly_ranked_agents[$selected_agent_id]['rankings'] as $quarter_name => $quarter): ?>
                                        <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-200 font-medium"><?= $quarter_name ?></td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-200"><?= $quarter['rank'] ?></td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-200"><?= $quarter['gross_comms'] ?> AED</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Yearly Ranking -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm h-[400px] flex flex-col gap-1">
                    <h2 class="text-xl font-semibold mb-6 dark:text-white">Yearly Ranking</h2>
                    <div class="mb-2">
                        <label for="monthly-agent" class="block text-sm font-medium text-gray-700 mb-2 dark:text-white"><?= $agent_name ?></label>
                        <input type="text" id="yearly-agent" name="yearly-agent" class="mt-1 block w-full border-b border-gray-600 dark:bg-gray-800">
                    </div>
                    <!-- Add more content for yearly ranking here -->
                    <?php if (empty($yearly_ranked_agents)): ?>
                        <p class="text-gray-600 dark:text-gray-400">No data available.</p>
                    <?php else: ?>
                        <div class="overflow-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Year</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rank</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sales</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                                    <?php foreach ($yearly_ranked_agents[$selected_agent_id]['rankings'] as $year_name => $year): ?>
                                        <tr class="whitespace-nowrap text-sm font-medium hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-200 font-medium"><?= $year_name ?></td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-200"><?= $year['rank'] ?></td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-gray-200"><?= $year['gross_comms'] ?> AED</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include('includes/footer.php'); ?>