<?php
include_once "./crest/crest.php";
include_once "./crest/settings.php";
include('includes/header.php');
include('includes/sidebar.php');

// include the fetch deals page
include_once "./data/fetch_deals.php";
include_once "./data/fetch_users.php";

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
    $agents[$user['ID']]["hired_by"] = $user['UF_USR_1728535335261'] ?? null;
    $agents[$user['ID']]["joining_date"] = date('Y-m-d', strtotime($user['UF_USR_1727158528318'])) ?? null;
}

//fetch details from the deals
foreach ($deals as $deal) {
    if (isset($agents[$deal['ASSIGNED_BY_ID']]["last_deal_date"])) {
        // Only update if the current deal is latest one
        if (strtotime($agents[$deal['ASSIGNED_BY_ID']]["last_deal_date"]) < date('Y-m-d', strtotime($deal['BEGINDATE']))) {
            $agents[$deal['ASSIGNED_BY_ID']]["last_deal_date"] = date('Y-m-d', strtotime($deal['BEGINDATE'])) ?? null;

            $agents[$deal['ASSIGNED_BY_ID']]["team"] = $deal['UF_CRM_1727854555607'] ?? null;
            $agents[$deal['ASSIGNED_BY_ID']]["project"] = $deal['UF_CRM_1727625779110'] ?? null;
            $agents[$deal['ASSIGNED_BY_ID']]["amount"] = $deal['OPPORTUNITY'] ?? null;
            $agents[$deal['ASSIGNED_BY_ID']]["gross_comms"] = $deal['UF_CRM_1727628135425'] ?? null;
            //get the duration from the current date
            $duration = duration_months($deal['BEGINDATE']);
            $agents[$deal['ASSIGNED_BY_ID']]["deal_current_duration"] = $duration ?? null;
        }
    } else {
        $agents[$deal['ASSIGNED_BY_ID']]["last_deal_date"] = date('Y-m-d', strtotime($deal['BEGINDATE'])) ?? null;

        $agents[$deal['ASSIGNED_BY_ID']]["team"] = $deal['UF_CRM_1727854555607'] ?? null;
        $agents[$deal['ASSIGNED_BY_ID']]["project"] = $deal['UF_CRM_1727625779110'] ?? null;
        $agents[$deal['ASSIGNED_BY_ID']]["amount"] = $deal['OPPORTUNITY'] ?? null;
        $agents[$deal['ASSIGNED_BY_ID']]["gross_comms"] = $deal['UF_CRM_1727871887978'] ?? null;

        $duration = duration_months($deal['BEGINDATE']);
        $agents[$deal['ASSIGNED_BY_ID']]["deal_current_duration"] = $duration ?? null;
    }
}
// calculate duration in months
function duration_months($date)
{
    $date1 = new DateTime($date);
    $date2 = new DateTime();
    $interval = $date1->diff($date2);
    return $interval->m + ($interval->y * 12);
}

echo "<pre>";
// print_r($deals);
// print_r($deal_fields);
// print_r($user_fields);
// print_r($agents);
echo "</pre>";
?>

<div class="p-10 w-[80%]">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Agent</th>
                    <th scope="col" class="px-6 py-3">Team</th>
                    <th scope="col" class="px-6 py-3">Hired by</th>
                    <th scope="col" class="px-6 py-3">Joining Date</th>
                    <th scope="col" class="px-6 py-3">Last Deal Date</th>
                    <th scope="col" class="px-6 py-3">Project</th>
                    <th scope="col" class="px-6 py-3">Amount</th>
                    <th scope="col" class="px-6 py-3">Gross Comms</th>
                    <th scope="col" class="px-6 py-3">No. of Months without Closing</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agents as $agent) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                            <?= isset($agent['first_name'], $agent['last_name']) ? "{$agent['first_name']} {$agent['last_name']}" : 'Missing Name'; ?>
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
</div>

<?php include('includes/footer.php'); ?>