<?php
require_once 'functions.php';
header('Content-type: application/json');
$team_manager = TeamManager::get();
$teams = $team_manager->getTeams();
$team_array = array();
foreach ($teams as $team) { $team_array[] = $team->toArray(); }
echo json_encode($team_array);
exit;