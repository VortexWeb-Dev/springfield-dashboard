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


$rankings = [
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
function store_agents($sorted_deals, &$rankings)
{
    foreach ($sorted_deals as $deal) {
        $date = date('Y-m-d', strtotime($deal['BEGINDATE']));
        $year = date('Y', strtotime($deal['BEGINDATE']));
        $month = date('M', strtotime($deal['BEGINDATE']));

        $gross_comms = isset($deal['UF_CRM_1727871887978']) ? (int)explode('|', $deal['UF_CRM_1727871887978'])[0] : 0;

        // get agent name
        $agent = getUser($deal['ASSIGNED_BY_ID']);
        $agent_full_name = $agent['NAME'] ?? '' . $agent['SECOND_NAME'] ?? '' . ' ' . $agent['LAST_NAME'] ?? '';

        // if (!isset($rankings[$year][$month]['counter'])) {
        //     $rankings[$year][$month]['counter'] = 1; // initialise the counter for the first time
        // }

        // if($rankings[$year][$month][$deal['ASSIGNED_BY_ID']] == $deal['ASSIGNED_BY_ID']){

        // }
        // $rankings[$year][$month][$deal['ASSIGNED_BY_ID']]['rank'] = $rankings[$year][$month]['counter']++ ?? null;

        $rankings[$year][$month][$deal['ASSIGNED_BY_ID']]['name'] = $agent_full_name ?? null;

        // initialise gross_comms for first time
        if (!isset($rankings[$year][$month][$deal['ASSIGNED_BY_ID']]['gross_comms'])) {
            $rankings[$year][$month][$deal['ASSIGNED_BY_ID']]['gross_comms'] = $gross_comms;
        } else {
            $rankings[$year][$month][$deal['ASSIGNED_BY_ID']]['gross_comms'] += $gross_comms;
        }
    }
}

store_agents($sorted_deals, $rankings);


$agents = getUsers();

// store the remaining agents details from the users
function store_remaining_agents($agents, &$rankings)
{
    foreach ($rankings as $year => $months) {
        foreach ($months as $month_name => $month_data) {
            foreach ($agents as $agent) {
                $agent_id = $agent['ID'] ?? 0;
                if (!isset($rankings[$year][$month_name][$agent_id])) {
                    $agent_full_name = $agent['NAME'] ?? '';
                    $rankings[$year][$month_name][$agent_id]['name'] = $agent_full_name ?? null;
                    $rankings[$year][$month_name][$agent_id]['gross_comms'] = 0;
                }
            }
        }
    }
}

store_remaining_agents($agents, $rankings);

//assign rank to each agent in each month of each year
function assign_rank(&$rankings)
{
    foreach ($rankings as $year => &$months) {
        foreach ($months as &$agents) {
            uasort($agents, function($a, $b) {
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
assign_rank($rankings);


echo "<pre>";
print_r($rankings);
// print_r($sorted_deals);
echo "</pre>";
?>

<div class="w-[85%] bg-gray-100 dark:bg-gray-900">
    <?php include('includes/navbar.php'); ?>
    <div class="px-8 py-6">
        <p class="text-2xl font-bold dark:text-white mb-4">Agent Ranking</p>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Agent</th>
                        <th scope="col" class="px-6 py-3">Jan 2024</th>
                        <th scope="col" class="px-6 py-3">Feb 2024</th>
                        <th scope="col" class="px-6 py-3">Mar 2024</th>
                        <th scope="col" class="px-6 py-3">Apr 2024</th>
                        <th scope="col" class="px-6 py-3">May 2024</th>
                        <th scope="col" class="px-6 py-3">Jun 2024</th>
                        <th scope="col" class="px-6 py-3">Jul 2024</th>
                        <th scope="col" class="px-6 py-3">Aug 2024</th>
                        <th scope="col" class="px-6 py-3">Sep 2024</th>
                        <th scope="col" class="px-6 py-3">Grand Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Agent 1</th>
                        <td class="px-6 py-4">10</td>
                        <td class="px-6 py-4">20</td>
                        <td class="px-6 py-4">30</td>
                        <td class="px-6 py-4">40</td>
                        <td class="px-6 py-4">50</td>
                        <td class="px-6 py-4">60</td>
                        <td class="px-6 py-4">70</td>
                        <td class="px-6 py-4">80</td>
                        <td class="px-6 py-4">90</td>
                        <td class="px-6 py-4">100</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>