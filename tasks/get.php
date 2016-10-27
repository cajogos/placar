<?php

include '../functions.php';

function showErrorMessage($message)
{
	echo '<div style="color:red;font-family:sans-serif;text-align:center;font-size:20px;margin:50px;">';
	echo $message;
	echo '<a style="margin-left:15px" href="">Try Again!</a>';
	echo '</div>';
	exit;
}

if ($_POST)
{
	$team_name = null;
	if (isset($_POST['team-name']))
	{
		$team_name = $_POST['team-name'];
	}
	if (!TeamManager::teamExists($team_name))
	{
		showErrorMessage('This team does not exist!');
	}
	$team_manager = TeamManager::get();
	$team = TeamManager::getTeamByName($team_name);
	$current_task = $team->getCurrentTask();
	$code = null;
	if (isset($_POST['code']))
	{
		$code = $_POST['code'];
	}
	if (!TaskManager::isValidKeyword($code))
	{
		showErrorMessage('Code is not valid!');
	}
	if (TeamManager::isUsedKeyword($team_name, $code))
	{
		$task_to_fetch = TaskManager::getTeamNextTask($team_name, true);
	}
	else
	{
		$task_to_fetch = TaskManager::getTeamNextTask($team_name);
	}
	if ($current_task === 0)
	{
		if (count($team->getUsedKeywords()) === 0)
		{
			$team_manager->addKeywordUsed($team_name, $code);			
		}
	}
	else if (($current_task != $task_to_fetch))
	{
		$team_manager->addKeywordUsed($team_name, $code);
	}
	require_once '_header.php';
	echo TaskManager::getViewContentsByNumber($task_to_fetch);
	require_once '_footer.php';
}
else { ?>
<!DOCTYPE html>
<html>
<head>
	<title>Get Your Task!</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css" />
</head>
<body>
	<div class="task-container" style="text-align: center;max-width: 500px">
		<form method="post" class="form">
			<div class="form-group">
				<label>Team Name</label>
				<input type="text" placeholder="Team Name" name="team-name" class="form-control" />
			</div>
			<div class="form-group">
				<label>Code Found</label>
				<input type="text" placeholder="Code" name="code" class="form-control" />
			</div>
			<button class="btn btn-lg btn-primary" type="submit">Get My Task</button>
		</form>
	</div>
</body>
</html>
<?php }