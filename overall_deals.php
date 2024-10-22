<?php
include_once "./crest/crest.php";
include_once "./crest/settings.php";
include('includes/header.php');
include('includes/sidebar.php');

// include the fetch deals page
include_once "./data/fetch_deals.php";

$fields = get_deal_fileds();

$deals = get_all_deals();

$overall_deals = [];

foreach ($deals as $index => $deal) {
    $overall_deals[$index]['Date'] = date('Y-m-d', strtotime($deal['BEGINDATE'] ?? ''));
    $overall_deals[$index]['Transaction Type'] = $deal['UF_CRM_1727625723908'] ?? null;
    $overall_deals[$index]['Deal Type'] = $deal['TYPE_ID'] ?? null;
    $overall_deals[$index]['Project Name'] = $deal['UF_CRM_1727625779110'] ?? null;
    $overall_deals[$index]['Unit No'] = $deal['UF_CRM_1727625804043'] ?? null;
    $overall_deals[$index]['Developer Name'] = $deal['UF_CRM_1727625822094'] ?? null;
    $overall_deals[$index]['Property Type'] = $deal['UF_CRM_66E3D8D1A13F7'] ?? null;
    $overall_deals[$index]['No Of Br'] = $deal['UF_CRM_1727854068559'] ?? null;
    $overall_deals[$index]['Client Name'] = $deal['UF_CRM_1727854143005'] ?? null;
    $overall_deals[$index]['Agent Name'] = $deal['UF_CRM_1727854195911'] ?? null;
    $overall_deals[$index]['Team'] = $deal['UF_CRM_1727854555607'] ?? null;
    $overall_deals[$index]['Property Price'] = $deal['OPPORTUNITY'] ?? null;
    $overall_deals[$index]['Gross Commission (Incl. VAT)'] = $deal['UF_CRM_1727628122686'] ?? null;
    $overall_deals[$index]['Gross Commission'] = $deal['UF_CRM_1727871887978'] ?? null;
    $overall_deals[$index]['VAT'] = $deal['UF_CRM_1727871911878'] ?? null;
    $overall_deals[$index]['Agent Net Commission'] = $deal['UF_CRM_1727871937052'] ?? null;
    $overall_deals[$index]['Managers Commission'] = $deal['UF_CRM_1727871954322'] ?? null;
    $overall_deals[$index]['Sales Support Commission'] = $deal['UF_CRM_1728534773938'] ?? null;
    $overall_deals[$index]['Springfield Commission'] = $deal['UF_CRM_1727871971926'] ?? null;
    $overall_deals[$index]['Commission Slab (%)'] = $deal['UF_CRM_1727626089404'] ?? null;
    $overall_deals[$index]['Referral'] = $deal['UF_CRM_1728042953037'] ?? null;
    $overall_deals[$index]['Referral Fee'] = $deal['UF_CRM_1727626055823'] ?? null;
    $overall_deals[$index]['Lead Source'] = $deal['UF_CRM_1727854893657'] ?? null;
    $overall_deals[$index]['Invoice Status'] = $deal['UF_CRM_1727872815184'] ?? null;
    $overall_deals[$index]['Notification'] = null;
    $overall_deals[$index]['Payment Received'] = $deal['UF_CRM_1727627289760'] ?? null;
    $overall_deals[$index]['Follow-up Notification'] = null;
    $overall_deals[$index]['1st Payment Received'] = $deal['UF_CRM_1727874909907'] ?? null;
    $overall_deals[$index]['2nd Payment Received'] = $deal['UF_CRM_1727874935109'] ?? null;
    $overall_deals[$index]['3rd Payment Received'] = $deal['UF_CRM_1727874959670'] ?? null;
    $overall_deals[$index]['Total Payment Received'] = $deal['UF_CRM_1727628185464'] ?? null;
    $overall_deals[$index]['Amount Receivable'] = $deal['UF_CRM_1727628203466'] ?? null;
}

// echo "<pre>";
// print_r($overall_deals);
// echo "</pre>";

// echo "<pre>";
// print_r($fields);
// echo "</pre>";
?>


<div class="p-10 w-[80%]">
    <?php
    // echo "<pre>";
    // print_r($fields);
    // echo "</pre>";
    ?>
    <!-- Overall deals -->
    <div class="my-2">
        <h2 class="text-xl font-semibold mb-4">Overall Deals</h2>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                    <?php foreach ($overall_deals as $deal) : ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <?php echo $deal['Date'] ?? ""; ?>
                            </th>
                            <!-- transaction type -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Transaction Type'] ?? ""; ?>
                            </td>
                            <!-- deal type -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Deal Type'] ?? ""; ?>
                            </td>
                            <!-- project name -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Project Name'] ?? ""; ?>
                            </td>
                            <!-- unit no -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Unit No'] ?? ""; ?>
                            </td>
                            <!-- developer name -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Developer Name'] ?? ""; ?>
                            </td>
                            <!-- type -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Property Type'] ?? ""; ?>
                            </td>
                            <!-- no of br -->
                            <td class="px-6 py-4">
                                <?php echo $deal['No Of Br'] ?? ""; ?>
                            </td>
                            <!-- client name -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Client Name'] ?? ""; ?>
                            </td>
                            <!-- agent name -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Agent Name'] ?? ""; ?>
                            </td>
                            <!-- team -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Team'] ?? ""; ?>
                            </td>
                            <!-- property price -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Property Price'] ?? ""; ?>
                            </td>
                            <!-- gross commission (incl. vat) -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Gross Commission (Incl. VAT)'] ?? ""; ?>
                            </td>
                            <!-- gross commission -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Gross Commission'] ?? ""; ?>
                            </td>
                            <!-- vat -->
                            <td class="px-6 py-4">
                                <?php echo $deal['VAT'] ?? ""; ?>
                            </td>
                            <!-- agent net commission -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Agent Net Commission'] ?? ""; ?>
                            </td>
                            <!-- managers commission -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Managers Commission'] ?? ""; ?>
                            </td>
                            <!-- sales support commission -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Sales Support Commission'] ?? ""; ?>
                            </td>
                            <!-- springfield commission -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Springfield Commission'] ?? ""; ?>
                            </td>
                            <!-- commission slab -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Commission Slab (%)'] ?? ""; ?>
                            </td>
                            <!-- referral -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Referral'] ?? ""; ?>
                            </td>
                            <!-- referral fee -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Referral Fee'] ?? ""; ?>
                            </td>
                            <!-- lead source -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Lead Source'] ?? ""; ?>
                            </td>
                            <!-- invoice status -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Invoice Status'] ?? ""; ?>
                            </td>
                            <!-- notification -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Notification'] ?? ""; ?>
                            </td>
                            <!-- payment received -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Payment Received'] ?? ""; ?>
                            </td>
                            <!-- follow-up notification -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Follow-up Notification'] ?? ""; ?>
                            </td>
                            <!-- 1st payment received -->
                            <td class="px-6 py-4">
                                <?php echo $deal['1st Payment Received'] ?? ""; ?>
                            </td>
                            <!-- 2nd payment received -->
                            <td class="px-6 py-4">
                                <?php echo $deal['2nd Payment Received'] ?? ""; ?>
                            </td>
                            <!-- 3rd payment received -->
                            <td class="px-6 py-4">
                                <?php echo $deal['3rd Payment Received'] ?? ""; ?>
                            </td>
                            <!-- total payment received -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Total Payment Received'] ?? ""; ?>
                            </td>
                            <!-- amount receivable -->
                            <td class="px-6 py-4">
                                <?php echo $deal['Amount Receivable'] ?? ""; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </table>
        </div>
    </div>

    <!-- Note : Not needed for now -->
    <!-- deals monitoring -->
    <div class="mt-4">
        <h2 class="text-xl font-semibold mb-4">Deals Monitoring</h2>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Booking Form</th>
                        <th scope="col" class="px-6 py-3">PP Copy</th>
                        <th scope="col" class="px-6 py-3">KYC</th>
                        <th scope="col" class="px-6 py-3">Screening</th>
                        <th scope="col" class="px-6 py-3">Client ID</th>
                        <th scope="col" class="px-6 py-3">Contact Number</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Client Type</th>
                        <th scope="col" class="px-6 py-3">Passport No/Company Registration No</th>
                        <th scope="col" class="px-6 py-3">Emirates ID (If applicable)</th>
                        <th scope="col" class="px-6 py-3">Birthday</th>
                        <th scope="col" class="px-6 py-3">Country</th>
                        <th scope="col" class="px-6 py-3">Nationality</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <!-- Booking from    -->
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            Yes/No
                        </th>
                        <!-- PP copy -->
                        <td class="px-6 py-4">
                            Yes/No
                        </td>
                        <!-- KYC -->
                        <td class="px-6 py-4">
                            Yes/No
                        </td>
                        <!-- Screening -->
                        <td class="px-6 py-4">
                            Yes/No
                        </td>
                        <!-- Client ID -->
                        <td class="px-6 py-4">
                            2024-00001
                        </td>
                        <!-- Contact Number -->
                        <td class="px-6 py-4">

                        </td>
                        <!-- Email -->
                        <td class="px-6 py-4">

                        </td>
                        <!-- Client Type -->
                        <td class="px-6 py-4">
                            Resident
                        </td>
                        <!-- Passport No/Company Registration No -->
                        <td class="px-6 py-4">

                        </td>
                        <!-- Emirates ID (If applicable) -->
                        <td class="px-6 py-4">

                        </td>
                        <!-- Birthday -->
                        <td class="px-6 py-4">

                        </td>
                        <!-- Country -->
                        <td class="px-6 py-4">

                        </td>
                        <!-- Nationality -->
                        <td class="px-6 py-4">

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>