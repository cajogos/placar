<?php

require_once '../functions.php';

if (isset($_SESSION['keylock']))
{
	header('Location: index.php');
	exit;
}

if (isset($_POST['keylock']))
{
	$keylock = $_POST['keylock'];

	if ($keylock === $_KEY_)
	{
		$_SESSION['keylock'] = $keylock;
		header('Location: index.php');
		exit;
	}
	else
	{
		echo 'Failed to login... <a href="login.php">try again</a>';
		exit;
	}
}

require_once 'header.php'; ?>

<div style="max-width: 400px;" class="container">
	<h2>Login to use the Manager</h2>
	<form action="login.php" method="post">
		<div class="form-group">
			<input type="password" class="form-control" name="keylock" />
		</div>
		<button type="submit" class="btn btn-success">Login</button>
	</form>
</div>

<?php require_once 'footer.php'; ?>