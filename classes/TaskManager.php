<?php

class TaskManager
{
	private static $instance = null;
	private $tasks = array();
	private $keywords = array();
	private $last_task = 0;
	private function __construct()
	{
		$tasks_file = $_SERVER['DOCUMENT_ROOT'] . '/tasks/tasks.php';
		require_once $tasks_file;
		$this->last_task = count($TASKS) - 1;
		foreach ($TASKS as $task)
		{
			$cur_task = new Task($task);
			$this->tasks[] = $cur_task;
		}
		foreach ($KEYWORDS as $KEY)
		{
			$this->keywords[] = $KEY;
		}
	}
	public static function get()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new TaskManager();
		}
		return self::$instance;
	}
}