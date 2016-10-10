<?php

session_start();

// Change this key before pushing live
$_KEY_ = 'cajogosplacar';

spl_autoload_register(function ($class_name)
{
	include 'classes/' . $class_name . '.php';
});

function auth_manager()
{
	global $_KEY_;
	$authorised = true;
	if (!isset($_SESSION['keylock']))
	{
		$authorised = false;
	}
	$keylock = $_SESSION['keylock'];
	if ($keylock != $_KEY_)
	{
		// Delete the erroneous session keylock
		unset($_SESSION['keylock']);
		$authorised = false;
	}
	if (!$authorised)
	{
		header('Location: login.php');
		exit;
	}
}

function api_auth_manager()
{
	global $_KEY_;
	$authorised = true;
	if (!isset($_SESSION['keylock']))
	{
		$authorised = false;
	}
	$keylock = $_SESSION['keylock'];
	if ($keylock != $_KEY_)
	{
		// Delete the erroneous session keylock
		unset($_SESSION['keylock']);
		$authorised = false;
	}
	return $authorised;
}