<?php
include_once "./crest/crest.php";
include_once "./crest/settings.php";
include('includes/header.php');
include('includes/sidebar.php');

// include the fetch deals page
include_once "./data/fetch_deals.php";
include_once "./data/fetch_users.php";

// utility functions
include_once "./utils/index.php";

$users = getUsers();
$deals = get_all_deals();

$user_fields = get_user_fields();
$deal_fields = get_deal_fileds();

$agents = [];

// fetch details from the users
foreach ($users as $user) {
    $agents[$user['ID']]["id"] = $user['ID'];
    $agents[$user['ID']]["first_name"] = $user['NAME'] ?? '';
    $agents[$user['ID']]["last_name"] = $user['LAST_NAME'] ?? '';
    $agents[$user['ID']]["middle_name"] = $user['SECOND_NAME'] ?? '';
    // map hired_by value
    if (isset($user['UF_USR_1728535335261'])) {
        $hiredBy = map_enum($user_fields, 'UF_USR_1728535335261', $user['UF_USR_1728535335261']);
        $agents[$user['ID']]["hired_by"] = $hiredBy ?? null;
    } else {
        $agents[$user['ID']]["hired_by"] = 'field_not_defined';
    }
    $agents[$user['ID']]["joining_date"] = date('Y-m-d', strtotime($user['UF_USR_1727158528318'])) ?? null;
}

//fetch details from the deals
foreach ($deals as $deal) {
    if (isset($agents[$deal['ASSIGNED_BY_ID']]["last_deal_date"])) {
        // Only update if the current deal is latest one
        if (strtotime($agents[$deal['ASSIGNED_BY_ID']]["last_deal_date"]) < date('Y-m-d', strtotime($deal['BEGINDATE']))) {
            $agents[$deal['ASSIGNED_BY_ID']]["last_deal_date"] = date('Y-m-d', strtotime($deal['BEGINDATE'])) ?? null;

            if (isset($deal['UF_CRM_1727854555607'])) {
                $teamName = map_enum($deal_fields, 'UF_CRM_1727854555607', $deal['UF_CRM_1727854555607']);
                $agents[$deal['ASSIGNED_BY_ID']]["team"] = $teamName ?? null;
            } else {
                $agents[$deal['ASSIGNED_BY_ID']]["team"] = 'field_not_defined';
            }

            $agents[$deal['ASSIGNED_BY_ID']]["project"] = $deal['UF_CRM_1727625779110'] ?? null;
            $agents[$deal['ASSIGNED_BY_ID']]["amount"] = $deal['OPPORTUNITY'] ?? null;
            $agents[$deal['ASSIGNED_BY_ID']]["gross_comms"] = $deal['UF_CRM_1727628135425'] ?? null;
            //get the duration from the current date
            $duration = duration_months($deal['BEGINDATE']);
            $agents[$deal['ASSIGNED_BY_ID']]["deal_current_duration"] = $duration ?? null;
        }
    } else {
        $agents[$deal['ASSIGNED_BY_ID']]["last_deal_date"] = date('Y-m-d', strtotime($deal['BEGINDATE'])) ?? null;

        // map team value
        $team = map_enum($deal_fields, 'UF_CRM_1727854555607', $deal['UF_CRM_1727854555607']);
        $agents[$deal['ASSIGNED_BY_ID']]["team"] = $team ?? null;

        $agents[$deal['ASSIGNED_BY_ID']]["project"] = $deal['UF_CRM_1727625779110'] ?? null;
        $agents[$deal['ASSIGNED_BY_ID']]["amount"] = $deal['OPPORTUNITY'] ?? null;
        $agents[$deal['ASSIGNED_BY_ID']]["gross_comms"] = $deal['UF_CRM_1727871887978'] ?? null;

        $duration = duration_months($deal['BEGINDATE']);
        $agents[$deal['ASSIGNED_BY_ID']]["deal_current_duration"] = $duration ?? null;
    }
}

echo "<pre>";
// print_r($deals);
// print_r($deal_fields);
// print_r($user_fields);
// print_r($users);
// print_r($agents);
echo "</pre>";
?>

<div class="w-[85%] bg-gray-100 dark:bg-gray-900">
    <?php include('includes/navbar.php'); ?>
    <div class="px-8 py-6">
        <p class="text-2xl font-bold dark:text-white mb-4">Agent Last Transaction Details</p>

        <div class="p-4">
            <!-- table -->
            <div class="relative w-full h-full overflow-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Agent</th>
                            <th scope="col" class="px-6 py-3">Team</th>
                            <th scope="col" class="px-6 py-3">Hired by</th>
                            <th scope="col" class="px-6 py-3 w-[150px]">Joining Date</th>
                            <th scope="col" class="px-6 py-3 w-[150px]">Last Deal Date</th>
                            <th scope="col" class="px-6 py-3">Project</th>
                            <th scope="col" class="px-6 py-3">Amount</th>
                            <th scope="col" class="px-6 py-3">Gross Comms</th>
                            <th scope="col" class="px-6 py-3">No. of Months without Closing</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_agents = count($agents);
                        $per_page = 7;
                        $total_pages = ceil($total_agents / $per_page);
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $start = ($page - 1) * $per_page;
                        $paginated_agents = array_slice($agents, $start, $per_page);

                        foreach ($paginated_agents as $agent) : ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= isset($agent['first_name'], $agent['last_name']) ? "{$agent['first_name']} {$agent['last_name']}" : 'Undefined'; ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?= $agent['team'] ?? '--' ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $agent['hired_by'] ?? '--' ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $agent['joining_date'] ?? '--' ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $agent['last_deal_date'] ?? '--' ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $agent['project'] ?? '--' ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $agent['amount'] ?? '--' ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $agent['gross_comms'] ?? '--' ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= isset($agent['deal_current_duration']) ? $agent['deal_current_duration'] . ' months' : '--' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- pagination control -->
            <div class="mt-4 w-full flex justify-center gap-1 py-2">
                <?php if (!empty($agents)): ?>
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