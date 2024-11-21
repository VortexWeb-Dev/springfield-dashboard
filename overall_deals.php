<?php
include_once "./crest/crest.php";
include_once "./crest/settings.php";
include_once "./utils/index.php";
include('includes/header.php');

// include the fetch deals page
include_once "./data/fetch_deals.php";
include_once "./data/fetch_users.php";

$selected_year = isset($_GET['year']) ? explode('/', $_GET['year'])[2] : date('Y');
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;


$filter = [
    'CATEGORY_ID' => 0,
    '>=BEGINDATE' => "$selected_year-01-01",
    '<=BEGINDATE' => "$selected_year-12-31",
];

$dealsData = get_paginated_deals($page, $filter) ?? [];
$deals = $dealsData['deals'] ?? [];

// pagination
$total_deals = $dealsData['total'] ?? 0;
$total_pages = ceil($total_deals / 50);


$fields = get_deal_fileds();

$overall_deals = [];

if (!empty($deals)) {
    foreach ($deals as $index => $deal) {
        $overall_deals[$index]['Date'] = date('Y-m-d', strtotime($deal['BEGINDATE'] ?? ''));
        //get the transaction type value
        $transactionType = map_enum($fields, 'UF_CRM_1727625723908', $deal['UF_CRM_1727625723908']);
        $overall_deals[$index]['Transaction Type'] = $transactionType ?? null;

        // debug: deal type not defined in custom fields its named as pipeline instade, and also the pipleline field is missing for overall deal type
        if (isset($deal['UF_CRM_1727625752721'])) {
            $dealType = map_enum($fields, 'UF_CRM_1727625752721', $deal['UF_CRM_1727625752721']);
            $overall_deals[$index]['Deal Type'] = $dealType ?? null;
        } else {
            $overall_deals[$index]['Deal Type'] = "deal_type_not_defined";
        }

        $overall_deals[$index]['Project Name'] = $deal['UF_CRM_1727625779110'] ?? null;
        $overall_deals[$index]['Unit No'] = $deal['UF_CRM_1727625804043'] ?? null;
        $overall_deals[$index]['Developer Name'] = $deal['UF_CRM_1727625822094'] ?? null;

        // map property type
        if (isset($deal['UF_CRM_66E3D8D1A13F7'])) {
            $propertyType = map_enum($fields, 'UF_CRM_66E3D8D1A13F7', $deal['UF_CRM_66E3D8D1A13F7']);
            $overall_deals[$index]['Property Type'] = $propertyType ?? null;
        } else {
            $overall_deals[$index]['Property Type'] = 'filed_not_defined';
        }

        // map no of br
        if (isset($deal['UF_CRM_1727854068559'])) {
            $noOfBr = map_enum($fields, 'UF_CRM_1727854068559', $deal['UF_CRM_1727854068559']);
            $overall_deals[$index]['No Of Br'] = $noOfBr ?? null;
        } else {
            $overall_deals[$index]['No Of Br'] = 'filed_not_defined';
        }

        $overall_deals[$index]['Client Name'] = $deal['UF_CRM_1727854143005'] ?? null;

        // get agent name by id
        if (isset($deal['ASSIGNED_BY_ID'])) {
            $agent = getUser($deal['ASSIGNED_BY_ID']);
            // Debug: agent second and last name not showing
            $overall_deals[$index]['Agent Name'] = $agent['NAME'] ?? '' . ' ' . $agent['SECOND_NAME'] ?? '' . ' ' . $agent['LAST_NAME'] ?? '' ?? null;
        } else {
            $overall_deals[$index]['Agent Name'] = "agent_not_found";
        }
        // map the team value
        if (isset($deal['UF_CRM_1727854555607'])) {
            $teamName = map_enum($fields, 'UF_CRM_1727854555607', $deal['UF_CRM_1727854555607']);
            $overall_deals[$index]['Team'] = $teamName ?? null;
        } else {
            $overall_deals[$index]['Team Name'] = "field_not_defined";
        }

        $overall_deals[$index]['Property Price'] = $deal['OPPORTUNITY'] ?? null;
        $overall_deals[$index]['Gross Commission (Incl. VAT)'] = $deal['UF_CRM_1727628122686'] ?? null;
        $overall_deals[$index]['Gross Commission'] = $deal['UF_CRM_1727871887978'] ?? null;
        $overall_deals[$index]['VAT'] = $deal['UF_CRM_1727871911878'] ?? null;
        $overall_deals[$index]['Agent Net Commission'] = $deal['UF_CRM_1727871937052'] ?? null;
        $overall_deals[$index]['Managers Commission'] = $deal['UF_CRM_1727871954322'] ?? null;
        $overall_deals[$index]['Sales Support Commission'] = $deal['UF_CRM_1728534773938'] ?? null;
        $overall_deals[$index]['Springfield Commission'] = $deal['UF_CRM_1727871971926'] ?? null;
        $overall_deals[$index]['Commission Slab (%)'] = $deal['UF_CRM_1727626089404'] ?? null;

        if (isset($deal['UF_CRM_1727626033205'])) {
            $has_referral = map_enum($fields, 'UF_CRM_1727626033205', $deal['UF_CRM_1727626033205']);
            $overall_deals[$index]['Referral'] = $has_referral ?? null;
        } else {
            $overall_deals[$index]['Referral'] = "field_not_defined";
        }

        $overall_deals[$index]['Referral Fee'] = $deal['UF_CRM_1727626055823'] ?? null;

        if (isset($deal['UF_CRM_1727854893657'])) {
            $leadSource = map_enum($fields, 'UF_CRM_1727854893657', $deal['UF_CRM_1727854893657']);
            $overall_deals[$index]['Lead Source'] = $leadSource ?? null;
        } else {
            $overall_deals[$index]['Lead Source'] = "field_not_defined";
        }

        if (isset($deal['UF_CRM_1727872815184'])) {
            $invoiceStatus = map_enum($fields, 'UF_CRM_1727872815184', $deal['UF_CRM_1727872815184']);
            $overall_deals[$index]['Invoice Status'] = $invoiceStatus ?? null;
        } else {
            $overall_deals[$index]['Invoice Status'] = "field_not_defined";
        }

        $overall_deals[$index]['Notification'] = null;

        if (isset($deal['UF_CRM_1727627289760'])) {
            $paymentReceived = map_enum($fields, 'UF_CRM_1727627289760', $deal['UF_CRM_1727627289760']);
            $overall_deals[$index]['Payment Received'] = $paymentReceived ?? null;
        } else {
            $overall_deals[$index]['Payment Received'] = "field_not_defined";
        }

        $overall_deals[$index]['Follow-up Notification'] = null;

        $overall_deals[$index]['1st Payment Received'] = $deal['UF_CRM_1727874909907'] ?? null;
        $overall_deals[$index]['2nd Payment Received'] = $deal['UF_CRM_1727874935109'] ?? null;
        $overall_deals[$index]['3rd Payment Received'] = $deal['UF_CRM_1727874959670'] ?? null;
        $overall_deals[$index]['Total Payment Received'] = $deal['UF_CRM_1727628185464'] ?? null;
        $overall_deals[$index]['Amount Receivable'] = $deal['UF_CRM_1727628203466'] ?? null;
    }
}
// echo "<pre>";
// print_r($overall_deals);
// echo "</pre>";

// echo "<pre>";
// print_r($fields);
// echo "</pre>";
?>


<div class="flex w-full h-screen">
    <?php include('includes/sidebar.php'); ?>
    <div class="main-content-area flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900">
        <?php include('includes/navbar.php'); ?>
        <div class="px-8 py-6">
            <!-- date picker -->
            <?php include('./includes/datepicker.php'); ?>

            <?php if (empty($deals)): ?>
                <div class="h-[65vh] flex justify-center items-center">
                    <h1 class="text-2xl font-bold mb-6 dark:text-white">No data available</h1>
                </div>
            <?php else: ?>
                <div class="p-4 shadow-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                    <div class="pb-4 rounded-lg border-0 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg">
                        <!-- Overall deals -->
                        <div class="relative rounded-lg border-b border-gray-200 dark:border-gray-700 w-full overflow-auto">
                            <table class="w-full h-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Date</th>
                                        <th scope="col" class="px-6 py-3">Transaction Type</th>
                                        <th scope="col" class="px-6 py-3">Deal Type</th>
                                        <th scope="col" class="px-6 py-3">Project Name</th>
                                        <th scope="col" class="px-6 py-3">Unit No</th>
                                        <th scope="col" class="px-6 py-3">Developer Name</th>
                                        <th scope="col" class="px-6 py-3">Property Type</th>
                                        <th scope="col" class="px-6 py-3">No Of Br</th>
                                        <th scope="col" class="px-6 py-3">Client Name</th>
                                        <th scope="col" class="px-6 py-3">Agent Name</th>
                                        <th scope="col" class="px-6 py-3">Team</th>
                                        <th scope="col" class="px-6 py-3">Property Price</th>
                                        <th scope="col" class="px-6 py-3">Gross Commission (Incl. VAT)</th>
                                        <th scope="col" class="px-6 py-3">Gross Commission</th>
                                        <th scope="col" class="px-6 py-3">VAT</th>
                                        <th scope="col" class="px-6 py-3">Agent Net Commission</th>
                                        <th scope="col" class="px-6 py-3">Managers Commission</th>
                                        <th scope="col" class="px-6 py-3">Sales Support Commission</th>
                                        <th scope="col" class="px-6 py-3">Springfield Commission</th>
                                        <th scope="col" class="px-6 py-3">Commission Slab (%)</th>
                                        <th scope="col" class="px-6 py-3">Referral</th>
                                        <th scope="col" class="px-6 py-3">Referral Fee</th>
                                        <th scope="col" class="px-6 py-3">Lead Source</th>
                                        <th scope="col" class="px-6 py-3">Invoice Status</th>
                                        <th scope="col" class="px-6 py-3">Notification</th>
                                        <th scope="col" class="px-6 py-3">Payment Received</th>
                                        <th scope="col" class="px-6 py-3">Follow-up Notification</th>
                                        <th scope="col" class="px-6 py-3">1st Payment Received</th>
                                        <th scope="col" class="px-6 py-3">2nd Payment Received</th>
                                        <th scope="col" class="px-6 py-3">3rd Payment Received</th>
                                        <th scope="col" class="px-6 py-3">Total Payment Received</th>
                                        <th scope="col" class="px-6 py-3">Amount Receivable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($overall_deals as $deal) :
                                    ?>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?php echo $deal['Date'] ?? "--"; ?>
                                            </th>
                                            <!-- transaction type -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Transaction Type'] ?? "--"; ?>
                                            </td>
                                            <!-- deal type -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Deal Type'] ?? "--"; ?>
                                            </td>
                                            <!-- project name -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Project Name'] ?? "--"; ?>
                                            </td>
                                            <!-- unit no -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Unit No'] ?? "--"; ?>
                                            </td>
                                            <!-- developer name -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Developer Name'] ?? "--"; ?>
                                            </td>
                                            <!-- type -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Property Type'] ?? "--"; ?>
                                            </td>
                                            <!-- no of br -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['No Of Br'] ?? "--"; ?>
                                            </td>
                                            <!-- client name -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Client Name'] ?? "--"; ?>
                                            </td>
                                            <!-- agent name -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Agent Name'] ?? "--"; ?>
                                            </td>
                                            <!-- team -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Team'] ?? "--"; ?>
                                            </td>
                                            <!-- property price -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Property Price'] ?? "--"; ?>
                                            </td>
                                            <!-- gross commission (incl. vat) -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Gross Commission (Incl. VAT)'] ?? "--"; ?>
                                            </td>
                                            <!-- gross commission -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Gross Commission'] ?? "--"; ?>
                                            </td>
                                            <!-- vat -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['VAT'] ?? "--"; ?>
                                            </td>
                                            <!-- agent net commission -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Agent Net Commission'] ?? "--"; ?>
                                            </td>
                                            <!-- managers commission -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Managers Commission'] ?? "--"; ?>
                                            </td>
                                            <!-- sales support commission -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Sales Support Commission'] ?? "--"; ?>
                                            </td>
                                            <!-- springfield commission -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Springfield Commission'] ?? "--"; ?>
                                            </td>
                                            <!-- commission slab -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Commission Slab (%)'] ?? "--"; ?>
                                            </td>
                                            <!-- referral -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Referral'] ?? "--"; ?>
                                            </td>
                                            <!-- referral fee -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Referral Fee'] ?? "--"; ?>
                                            </td>
                                            <!-- lead source -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Lead Source'] ?? "--"; ?>
                                            </td>
                                            <!-- invoice status -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Invoice Status'] ?? "--"; ?>
                                            </td>
                                            <!-- notification -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Notification'] ?? "--"; ?>
                                            </td>
                                            <!-- payment received -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Payment Received'] ?? "--"; ?>
                                            </td>
                                            <!-- follow-up notification -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Follow-up Notification'] ?? "--"; ?>
                                            </td>
                                            <!-- 1st payment received -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['1st Payment Received'] ?? "--"; ?>
                                            </td>
                                            <!-- 2nd payment received -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['2nd Payment Received'] ?? "--"; ?>
                                            </td>
                                            <!-- 3rd payment received -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['3rd Payment Received'] ?? "--"; ?>
                                            </td>
                                            <!-- total payment received -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Total Payment Received'] ?? "--"; ?>
                                            </td>
                                            <!-- amount receivable -->
                                            <td class="px-6 py-4">
                                                <?php echo $deal['Amount Receivable'] ?? "--"; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- pagination control -->
                        <?php if (!empty($overall_deals)): ?>
                            <?php include('includes/pagination_control.php'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>