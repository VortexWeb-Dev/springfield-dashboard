<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar bg-gray-800 text-white min-h-screen flex flex-col justify-between w-[15%]">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-8 text-white text-center hover:text-gray-300">
            <a href="index.php">SpringField</a>
        </h1>
        <ul class="flex flex-col gap-2">
            <li class="text-sm">
                <a href="management_dashboard.php" class="block py-2 px-2 rounded transition duration-200 hover:bg-gray-700 <?php echo $current_page === 'management_dashboard.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-tachometer-alt mr-2"></i> Management Dashboard
                </a>
            </li>
            <li class="text-sm">
                <a href="overall_deals.php" class="block p-2 rounded transition duration-200 hover:bg-gray-700 <?php echo $current_page === 'overall_deals.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-handshake mr-2"></i> Overall Deals
                </a>
            </li>
            <li class="text-sm">
                <a href="deal_source.php" class="block p-2 rounded transition duration-200 hover:bg-gray-700 <?php echo $current_page === 'deal_source.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-chart-line mr-2"></i> Deal Source
                </a>
            </li>
            <li class="text-sm">
                <a href="agent_last_transaction.php" class="block p-2 rounded transition duration-200 hover:bg-gray-700 <?php echo $current_page === 'agent_last_transaction.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-clock mr-2"></i> Agent Last Transaction
                </a>
            </li>
            <li class="text-sm">
                <a href="team.php" class="block p-2 rounded transition duration-200 hover:bg-gray-700 <?php echo $current_page === 'team.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-users mr-2"></i> Team
                </a>
            </li>
            <li class="text-sm">
                <a href="agent_commission_splits.php" class="block p-2 rounded transition duration-200 hover:bg-gray-700 <?php echo $current_page === 'agent_commission_splits.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-percentage mr-2"></i> Agent Commission Splits
                </a>
            </li>
            <li class="text-sm">
                <a href="my_deals_agents.php" class="block p-2 rounded transition duration-200 hover:bg-gray-700 <?php echo $current_page === 'my_deals_agents.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-briefcase mr-2"></i> My Deals - Agents
                </a>
            </li>
            <li class="text-sm">
                <a href="agent_ranking.php" class="block p-2 rounded transition duration-200 hover:bg-gray-700 <?php echo $current_page === 'agent_ranking.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-trophy mr-2"></i> Agent Ranking
                </a>
            </li>
            <!-- <li class="text-sm">
                <a href="commission_receiving.php" class="block p-2 rounded transition duration-200 hover:bg-gray-700 <?php echo $current_page === 'commission_receiving.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-money-bill-wave mr-2"></i> Commission Receiving
                </a>
            </li> -->
            <!-- <li class="text-sm">
                <a href="performance_report.php" class="block p-2 rounded transition duration-200 hover:bg-gray-700 <?php echo $current_page === 'performance_report.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-chart-bar mr-2"></i> Performance Report
                </a>
            </li> -->
            <!-- <li class="text-sm">
                <a href="soa_agents.php" class="block p-2 rounded transition duration-200 hover:bg-gray-700 <?php echo $current_page === 'soa_agents.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-file-invoice mr-2"></i> SOA for Agents
                </a>
            </li> -->
            <li class="text-sm">
                <a href="monthly_expenses.php" class="block p-2 rounded transition duration-200 hover:bg-gray-700 <?php echo $current_page === 'monthly_expenses.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-file-invoice-dollar mr-2"></i> Monthly Expenses
                </a>
            </li>
        </ul>
    </div>
    <div class="p-6 text-sm text-gray-400 text-center">
        © <?= date('Y') ?> SpringField.
    </div>
</div>
