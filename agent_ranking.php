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

$selected_month = isset($_GET['month']) ? $_GET['month'] : date('M');

function getFilteredRankings($monthwise_rank_data, $selected_month)
{
    $ranking = [];

    foreach ($monthwise_rank_data as $month => $agents) {
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

if (isset($global_ranking[$selected_year]['monthwise_rank'])) {
    // get the sorted agents for the selected year and month
    $filtered_ranked_agents = getFilteredRankings($global_ranking[$selected_year]['monthwise_rank'], $selected_month);
} else {
    $filtered_ranked_agents = [];
}

echo "<pre>";
// print_r($filtered_ranked_agents);
echo "</pre>";
?>

<div class="w-[85%] bg-gray-100 dark:bg-gray-900">
    <?php include('includes/navbar.php'); ?>
    <div class="px-8 py-6">
        <?php include('./includes/datepicker.php'); ?>

        <div class="p-4">
            <!-- old date picker -->
            <!-- <form action="" method="get">
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
            </form> -->
            <div class="p-4 shadow-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                <div class="pb-4 rounded-lg border-0 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg">
                    <!-- table container -->
                    <div class="relative rounded-lg border-b border-gray-200 dark:border-gray-700 w-full overflow-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Agent Name</th>
                                    <?php foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month): ?>
                                        <th scope="col" class="px-4 py-3 w-[150px] <?= $month == $selected_month ? 'bg-gray-100 dark:bg-gray-700 dark:text-white text-bold' : '' ?>">
                                            <form action="" method="get" class="">
                                                <input type="hidden" name="month" value="<?= $month ?>">
                                                <input type="hidden" name="year" value="<?= isset($_GET['year']) ? $_GET['year'] : date('d/m/Y') ?>">
                                                <div class="w-full flex gap-1 justify-between items-center">
                                                    <p class=""><?= $month ?></p>
                                                    <button type="submit" class="" <?= $month == $selected_month ? 'disabled' : '' ?>>
                                                        <?php
                                                        if (isset($selected_month) && $month == $selected_month) {
                                                            echo '<i class="fa-solid fa-sort-desc text-indigo-600"></i>';
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
                                    $per_page = 6;
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
                                <a href="?page=<?= $page - 1 ?>&month=<?= isset($_GET['month']) ? $_GET['month'] : date('M') ?>&year=<?= isset($_GET['year']) ? $_GET['year'] : date('d/m/Y') ?>" class="bg-gray-500/40 border border-gray-800 rounded-md px-2 py-1 text-gray-800 dark:text-gray-100 text-xs font-medium hover:bg-gray-600 hover:text-gray-100">Prev</a>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <?php if ($page == $i): ?>
                                    <button type="button" class="bg-indigo-500 border border-indigo-800 rounded-md px-2 py-1 text-gray-800 dark:text-indigo-100 text-xs font-medium hover:bg-indigo-600 hover:text-white" disabled><?= $i ?></button>
                                <?php else: ?>
                                    <a href="?page=<?= $i ?>&month=<?= isset($_GET['month']) ? $_GET['month'] : date('M') ?>&year=<?= isset($_GET['year']) ? $_GET['year'] : date('d/m/Y') ?>" class="bg-indigo-500/40 border border-indigo-800 rounded-md px-2 py-1 text-gray-800 dark:text-indigo-100 text-xs font-medium hover:bg-indigo-600 hover:text-white"><?= $i ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?= $page + 1 ?>&month=<?= isset($_GET['month']) ? $_GET['month'] : date('M') ?>&year=<?= isset($_GET['year']) ? $_GET['year'] : date('d/m/Y') ?>" class="bg-indigo-500/40 border border-indigo-800 rounded-md px-2 py-1 text-gray-800 dark:text-indigo-100 text-xs font-medium hover:bg-indigo-600 hover:text-white">Next</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>