<?php

require_once '../functions.php';

auth_manager();

require_once 'header.php';

$team_manager = TeamManager::get();
$teams = $team_manager->getTeams();
$task_manager = TaskManager::get();

?>

<div class="row">
	<div class="col-md-6">
		<h3>Team</h3>
		<div class="row">
			<div class="col-md-8">
				<input type="text" class="form-control" id="team-add-input" placeholder="Team Name" />
			</div>
			<div class="col-md-4">
				<button class="btn btn-success" style="width:60%" id="team-create">Create</button>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-8">
				<?php
				print '<select class="form-control" id="team-remove-select">';
				foreach ($teams as $team)
				{
					print '<option value="' . $team->getName() . '">';
					print $team->getName();
					print '</option>';
				}
				print '</select>';
				?>
			</div>
			<div class="col-md-4">
				<button class="btn btn-warning" style="width:60%" id="team-remove">Remove</button>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<h3>Points</h3>
		<div class="row">
			<div class="col-xs-4">
				<?php
				print '<select class="form-control" id="team-selector">';
				foreach ($teams as $team)
				{
					print '<option value="' . $team->getName() . '">';
					print $team->getName();
					print '</option>';
				}
				print '</select>';
				?>
			</div>
			<div class="col-xs-4">
				<select class="form-control" id="points-action-select">
					<option value="add">Add</option>
					<option value="set">Set</option>
					<option value="remove">Remove</option>
				</select>
			</div>
			<div class="col-xs-4">
				<input class="form-control" type="number" id="points-amount-input" min="0" value="10" />
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-xs-12" style="text-align:center">
				<button class="btn btn-primary" style="width:60%" id="points-button">Run</button>
			</div>
		</div>
	</div>
</div>
<hr />
<div style="display:none" class="alert alert-danger" id="alert-message"></div>
<?php

print '<table class="table table-striped table-hover">';
print '<thead><tr>';
print '<th>Name</th>';
print '<th>Points</th>';
print '<th>Last Used Code</th>';
print '<th>Current Task</th>';
print '<th>Task Completed</th>';
print '</tr></thead>';
print '<tbody>';
foreach ($teams as $team)
{
	print '<tr>';
	print '<td>' . $team->getName() . '</td>';
	print '<td>' . $team->getPoints() . '</td>';
	print '<td>' . $team->getLastUsedCode() . '</td>';
	print '<td>' . $team->getCurrentTask() . '</td>';
	print '<td>' . ($team->isTaskCompleted() ? 'yes' : 'no') . '</td>';
	print '</tr>';
}
print '</tbody>';
print '</table>';

// Valid keywords
print '<hr />';
print '<h4>Valid Keywords</h4>';
$keywords = $task_manager->getKeywords();
foreach ($keywords as $keyword)
{
	print '<span class="label label-primary" style="margin:0 5px">' . $keyword . '</span>';
}

// Task Manager Stuff
print '<hr />';
print '<h4>Task Manager</h4>';
$tasks = $task_manager->getTasks();
print '<table class="table table-striped table-hover">';
print '<thead><tr>';
print '<th>ID</th>';
print '<th>View</th>';
print '</tr></thead>';
print '<tbody>';
foreach ($tasks as $task)
{
	print '<tr>';
	print '<td>' . $task->getId() . '</td>';
	print '<td>' . $task->getView() . '</td>';
	print '</tr>';
}
print '</tbody>';
print '</table>';

require_once 'footer.php';