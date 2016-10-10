<?php

require_once '../functions.php';

$team_manager = TeamManager::get();

$team_test = new Team('test_team');

// $team_manager->setTeamPoints('test_team', 10);

// $team_manager->addTeamPoints('test_team', 10);

// $team_manager->removeTeamPoints('test_team', 10);


var_dump($team_manager);