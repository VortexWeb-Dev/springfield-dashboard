<?php
include_once './crest/crest.php';
include_once './crest/settings.php';

include_once '/utils/index.php';
include_once '../controllers/calculate_agent_rank.php';

clearCache('global_ranking_cache.json');

calculateAgentRank();


