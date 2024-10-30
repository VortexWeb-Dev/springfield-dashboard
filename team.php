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

$deal_fields = get_deal_fileds();

$teams = [];

$teamLeaders = $deal_fields['UF_CRM_1727854555607']['items'] ?? [];

foreach ($teamLeaders as $leader) {
    $id = $leader['ID'] ?? null;
    $value = $leader['VALUE'] ?? null;

    // add them in teams array
    $teams[$id]['team_leader_id'] = $id;
    $teams[$id]['team_leader'] = $value;
}

$deals = get_all_deals();

foreach ($deals as $deal) {
    $teamLeaderId = $deal['UF_CRM_1727854555607'] ?? null;
    if ($teamLeaderId && isset($deal['ASSIGNED_BY_ID'])) {
        $agent = getUser($deal['ASSIGNED_BY_ID']);
        $agentId = $agent['ID'] ?? null;
        $agentfullName = $agent['NAME'] ?? '' . ' ' . $agent['SECOND_NAME'] ?? '' . ' ' . $agent['LAST_NAME'] ?? '';
        $member = ['member_id' => $agentId ?? null, 'name' => $agentfullName ?? null];
        $teams[$teamLeaderId]['members'][] = $member;
    }
}

// echo "<pre>";
// print_r($teams);
// echo "</pre>";

?>

<div class="w-[85%] bg-gray-100 dark:bg-gray-900">
    <?php include('includes/navbar.php'); ?>
    <div class="px-8 py-6">
        <div class="container mx-auto">
            <header class="flex flex-col md:flex-row justify-between items-center mb-8 space-y-4 md:space-y-0">
                <h1 class="text-3xl font-bold dark:text-white">Teams</h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Search team leaders or members"
                            class="pl-10 pr-4 py-2 rounded-full bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                </div>
            </header>
            <div id="teamStructure" class="space-y-8">
                <?php foreach ($teams as $team): ?>
                    <div class="team-leader bg-white dark:bg-gray-800 rounded-lg shadow-md p-6" data-leader-id="<?php echo $team['team_leader_id']; ?>" data-leader-name="<?php echo $team['team_leader']; ?>">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-semibold dark:text-white"><?php echo $team['team_leader']; ?></h2>
                            <span class="text-gray-600 dark:text-gray-400">Team Leader ID: <?php echo $team['team_leader_id']; ?></span>
                        </div>
                        <?php if (isset($team['members']) && !empty($team['members'])): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                                <?php foreach ($team['members'] as $member): ?>
                                    <div class="team-member flex flex-col space-y-1" data-member-name="<?php echo $member['name']; ?>">
                                        <span class="font-medium dark:text-gray-300"><?php echo $member['name']; ?></span>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Member ID: <?php echo $member['member_id']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-600 dark:text-gray-400 mt-4">No team members assigned.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const teamLeaders = document.querySelectorAll('.team-leader');

        teamLeaders.forEach(leader => {
            const leaderName = leader.dataset.leaderName.toLowerCase();
            const teamMembers = leader.querySelectorAll('.team-member');
            let leaderVisible = false;

            if (leaderName.includes(searchTerm)) {
                leaderVisible = true;
                teamMembers.forEach(member => {
                    member.style.display = 'flex';
                });
            } else {
                teamMembers.forEach(member => {
                    const memberName = member.dataset.memberName.toLowerCase();
                    if (memberName.includes(searchTerm)) {
                        leaderVisible = true;
                        member.style.display = 'flex';
                    } else {
                        member.style.display = 'none';
                    }
                });
            }

            leader.style.display = leaderVisible ? 'block' : 'none';
        });
    });
</script>

<?php include('includes/footer.php'); ?>