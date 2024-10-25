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

$cache_file = 'cache/global_ranking_cache.json';
$global_ranking = [];

if (file_exists($cache_file)) {
    $global_ranking = json_decode(file_get_contents($cache_file), true);
} else {
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

    // create directory if not exists
    $cacheDir = 'cache/';
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0777, true);
    }
    $cacheFile = $cacheDir . 'global_ranking_cache.json';

    // Cache the global ranking data
    $bytesWritten = file_put_contents($cacheFile, json_encode($global_ranking));
    if ($bytesWritten === false) {
        // handle the error
    }
}

//get the filter data from get request
$selected_year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$selected_month = isset($_GET['month']) ? $_GET['month'] : date('M');

function getFilteredRankings($global_ranking, $selected_year, $selected_month)
{
    $ranking = [];

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
        <p class="text-2xl font-bold dark:text-white mb-4">Agent Ranking</p>

        <div class="p-4">
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
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Apply
                    </button>
                </div>
            </form>

            <!-- table container -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Agent Name</th>
                            <?php foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month): ?>
                                <th scope="col" class="px-4 py-3 w-[150px]">
                                    <form action="" method="get" class="">
                                        <input type="hidden" name="month" value="<?= $month ?>">
                                        <input type="hidden" name="year" value="<?= $selected_year ?>">
                                        <div class="w-full flex gap-1 justify-between items-center">
                                            <p class=""><?= $month ?></p>
                                            <button type="submit" class="">
                                                <?php
                                                if (isset($selected_month) && $month == $selected_month) {
                                                    echo '<i class="fa-solid fa-sort text-indigo-600"></i>';
                                                } else {
                                                    echo '<i class="fa-solid fa-sort"></i>';
                                                }
                                                ?>
                                            </button>
                                        </div>
                                    </form>
                                </th>
                            <?php endforeach; ?>
                            <th scope="col" class="px-6 py-3">Total gross Comm</th>
                            <!-- <th scope="col" class="px-6 py-3">Grand Total</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($filtered_ranked_agents)): ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td colspan="13" class="px-6 py-4 text-center">Data unavailable</td>
                                <td colspan="13" class="px-6 py-4 text-center"></td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $total_agents = count($filtered_ranked_agents);
                            $per_page = 10;
                            $total_pages = ceil($total_agents / $per_page);
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $start = ($page - 1) * $per_page;
                            $filtered_ranked_agents = array_slice($filtered_ranked_agents, $start, $per_page);

                            foreach ($filtered_ranked_agents as $agent): ?>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= $agent['Jan']['name'] ?? '' ?></th>
                                    <?php foreach ($agent as $month => $data): ?>
                                        <?php if (in_array($month, ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])): ?>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col gap-2 flex-nowrap">
                                                    <div class="bg-indigo-500/40 w-[7rem] border border-indigo-800 rounded-md px-2 py-1 text-gray-800 dark:text-indigo-100 text-xs font-medium">Rank: <?= $data['rank'] ?? '' ?></div>
                                                    <div class="bg-green-500/40 border border-green-800 rounded-md px-2 py-1 text-gray-800 dark:text-green-100 text-xs font-medium">GC: <?= number_format($data['gross_comms'] ?? 0, 2) ?> AED</div>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <td class="px-6 py-4">
                                        <p class="w-[7rem]"><?= array_sum(array_column($agent, 'gross_comms')) ?? '' ?> AED</p>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
            <!-- pagination control -->
            <div class="mt-4 w-full flex justify-center gap-1 py-2">
                <?php if (!empty($filtered_ranked_agents)): ?>
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>" class="bg-gray-500/40 border border-gray-800 rounded-md px-2 py-1 text-gray-800 dark:text-gray-100 text-xs font-medium hover:bg-gray-600 hover:text-gray-100">Prev</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($page == $i): ?>
                            <button type="button" class="bg-indigo-500 border border-indigo-800 rounded-md px-2 py-1 text-gray-800 dark:text-indigo-100 text-xs font-medium hover:bg-indigo-600 hover:text-white" disabled><?= $i ?></button>
                        <?php else: ?>
                            <a href="?page=<?= $i ?>" class="bg-indigo-500/40 border border-indigo-800 rounded-md px-2 py-1 text-gray-800 dark:text-indigo-100 text-xs font-medium hover:bg-indigo-600 hover:text-white"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page + 1 ?>" class="bg-indigo-500/40 border border-indigo-800 rounded-md px-2 py-1 text-gray-800 dark:text-indigo-100 text-xs font-medium hover:bg-indigo-600 hover:text-white">Next</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>