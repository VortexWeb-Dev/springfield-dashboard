<?php
include_once "./crest/crest.php";
include_once "./crest/settings.php";

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
            // Monthly ranking
            'monthwise_rank' => [
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
                'Dec' => [],
            ],

            // Quaterly ranking
            'quarterly_rank' => [
                'Q1' => [],
                'Q2' => [],
                'Q3' => [],
            ],

            // Yearly ranking
            'yearly_rank' => []
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
            $quarter = get_quarter($month); // get the quarter based on the month, Q1, Q2, Q3, Q4

            $gross_comms = isset($deal['UF_CRM_1727871887978']) ? (int)explode('|', $deal['UF_CRM_1727871887978'])[0] : 0;

            // get agent name
            $agent = getUser($deal['ASSIGNED_BY_ID']);
            $agent_full_name = $agent['NAME'] ?? '' . $agent['SECOND_NAME'] ?? '' . ' ' . $agent['LAST_NAME'] ?? '';

            $global_ranking[$year]['monthwise_rank'][$month][$deal['ASSIGNED_BY_ID']]['name'] = $agent_full_name ?? null;

            // initialise gross_comms for first time
            if (!isset($global_ranking[$year]['monthwise_rank'][$month][$deal['ASSIGNED_BY_ID']]['gross_comms'])) {
                $global_ranking[$year]['monthwise_rank'][$month][$deal['ASSIGNED_BY_ID']]['gross_comms'] = $gross_comms;
            } else {
                $global_ranking[$year]['monthwise_rank'][$month][$deal['ASSIGNED_BY_ID']]['gross_comms'] += $gross_comms;
            }

            // add to quarterly
            if (!isset($global_ranking[$year]['quarterly_rank'][$quarter][$deal['ASSIGNED_BY_ID']]['name'])) {
                $global_ranking[$year]['quarterly_rank'][$quarter][$deal['ASSIGNED_BY_ID']]['name'] = $agent_full_name ?? null;
            }

            if (!isset($global_ranking[$year]['quarterly_rank'][$quarter][$deal['ASSIGNED_BY_ID']]['gross_comms'])) {
                $global_ranking[$year]['quarterly_rank'][$quarter][$deal['ASSIGNED_BY_ID']]['gross_comms'] = $gross_comms;
            } else {
                $global_ranking[$year]['quarterly_rank'][$quarter][$deal['ASSIGNED_BY_ID']]['gross_comms'] += $gross_comms;
            }

            //add to yearly
            if (!isset($global_ranking[$year]['yearly_rank'][$deal['ASSIGNED_BY_ID']]['name'])) {
                $global_ranking[$year]['yearly_rank'][$deal['ASSIGNED_BY_ID']]['name'] = $agent_full_name ?? null;
            }

            if (!isset($global_ranking[$year]['yearly_rank'][$deal['ASSIGNED_BY_ID']]['gross_comms'])) {
                $global_ranking[$year]['yearly_rank'][$deal['ASSIGNED_BY_ID']]['gross_comms'] = $gross_comms;
            } else {
                $global_ranking[$year]['yearly_rank'][$deal['ASSIGNED_BY_ID']]['gross_comms'] += $gross_comms;
            }
        }
    }

    store_agents($sorted_deals, $global_ranking);

    $agents = getUsers();

    // store the remaining agents details from the users
    function store_remaining_agents($agents, &$global_ranking)
    {
        foreach ($global_ranking as $year => $months) {
            foreach ($months as $rank_type => $rank_data) {
                if ($rank_type == 'monthwise_rank') {
                    foreach ($rank_data as $month => $agents_data) {
                        foreach ($agents as $id => $agent) {
                            $agent_id = $id ?? 0;
                            if (!isset($global_ranking[$year][$rank_type][$month][$agent_id])) {
                                $agent_full_name = $agent['NAME'] ?? '';
                                $global_ranking[$year][$rank_type][$month][$agent_id]['name'] = $agent_full_name ?? null;
                                $global_ranking[$year][$rank_type][$month][$agent_id]['gross_comms'] = 0;
                            }
                        }
                    }
                } else if ($rank_type == 'quarterly_rank') {
                    foreach ($rank_data as $quarter => $agents_data) {
                        foreach ($agents as $id => $agent) {
                            $agent_id = $id ?? 0;
                            if (!isset($global_ranking[$year][$rank_type][$quarter][$agent_id])) {
                                $agent_full_name = $agent['NAME'] ?? '';
                                $global_ranking[$year][$rank_type][$quarter][$agent_id]['name'] = $agent_full_name ?? null;
                                $global_ranking[$year][$rank_type][$quarter][$agent_id]['gross_comms'] = 0;
                            }
                        }
                    }
                } else if ($rank_type == 'yearly_rank') {
                    foreach ($agents as $id => $agent) {
                        $agent_id = $id ?? 0;
                        if (!isset($global_ranking[$year][$rank_type][$agent_id])) {
                            $agent_full_name = $agent['NAME'] ?? '';
                            $global_ranking[$year][$rank_type][$agent_id]['name'] = $agent_full_name ?? null;
                            $global_ranking[$year][$rank_type][$agent_id]['gross_comms'] = 0;
                        }
                    }
                }
            }
        }
    }

    store_remaining_agents($agents, $global_ranking);

    // put id = 263 as it is missing in the agents list
    foreach ($global_ranking as $year => &$months) {
        foreach ($months as $rank_type => &$rank_data) {
            if ($rank_type == 'monthwise_rank') {
                foreach ($rank_data as $month => &$agents_data) {
                    $agent_id = 263;
                    $agent = getUser($agent_id);
                    $agent_full_name = $agent['NAME'] ?? '';
                    if (!isset($global_ranking[$year][$rank_type][$month][$agent_id])) {
                        $global_ranking[$year][$rank_type][$month][$agent_id]['name'] = $agent_full_name ?? null;
                        $global_ranking[$year][$rank_type][$month][$agent_id]['gross_comms'] = 0;
                    }
                }
            } else if ($rank_type == 'quarterly_rank') {
                foreach ($rank_data as $quarter => &$agents_data) {
                    $agent_id = 263;
                    $agent = getUser($agent_id);
                    $agent_full_name = $agent['NAME'] ?? '';
                    if (!isset($global_ranking[$year][$rank_type][$quarter][$agent_id])) {
                        $global_ranking[$year][$rank_type][$quarter][$agent_id]['name'] = $agent_full_name ?? null;
                        $global_ranking[$year][$rank_type][$quarter][$agent_id]['gross_comms'] = 0;
                    }
                }
            } else if ($rank_type == 'yearly_rank') {
                $agent_id = 263;
                $agent = getUser($agent_id);
                $agent_full_name = $agent['NAME'] ?? '';
                if (!isset($global_ranking[$year][$rank_type][$agent_id])) {
                    $global_ranking[$year][$rank_type][$agent_id]['name'] = $agent_full_name ?? null;
                    $global_ranking[$year][$rank_type][$agent_id]['gross_comms'] = 0;
                }
            }
        }
    }

    //assign rank to each agent in each month of each year
    function assign_monthly_rank(&$global_ranking)
    {
        foreach ($global_ranking as $year => &$months) {
            foreach ($months['monthwise_rank'] as $month => &$agents) {
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
    assign_monthly_rank($global_ranking);

    //assign rank to each agent in each quarter of each year
    function assign_quarterly_rank(&$global_ranking)
    {
        foreach ($global_ranking as $year => &$data) {
            foreach ($data['quarterly_rank'] as $quarter => &$agents) {
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

    assign_quarterly_rank($global_ranking);

    //assign rank to each agent in each year
    function assign_yearly_rank(&$global_ranking)
    {
        foreach ($global_ranking as $year => &$data) {
            if (isset($data['yearly_rank'])) {
                uasort($data['yearly_rank'], function ($a, $b) {
                    return $b['gross_comms'] <=> $a['gross_comms'];
                });

                $rank = 1;
                $previous_gross_comms = null;
                foreach ($data['yearly_rank'] as &$agent) {
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

    assign_yearly_rank($global_ranking);

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

echo "<pre>";
// print_r($agents);
// print_r($global_ranking);
// print_r($sorted_deals);
echo "</pre>";
