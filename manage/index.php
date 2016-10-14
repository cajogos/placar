<?php

require_once '../functions.php';

auth_manager();

require_once 'header.php';

$team_manager = TeamManager::get();
$teams = $team_manager->getTeams();

?>



<?php

print '<table class="table table-striped table-hover">';
print '<thead><tr>';
print '<th>Name</th>';
print '<th>Points</th>';
print '<th>Current Task</th>';
print '</tr></thead>';
print '<tbody>';
foreach ($teams as $team)
{
	print '<tr>';
	print '<td>' . $team->getName() . '</td>';
	print '<td>' . $team->getPoints() . '</td>';
	print '<td>' . $team->getCurrentTask() . '</td>';
	print '</tr>';
}
print '</tbody>';
print '</table>';

?>

<?php require_once 'footer.php';