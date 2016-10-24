<?php

class TaskManager
{
	const FINISHED_TASK = 'FINISHED';
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
			$this->keywords[] = strtolower($KEY);
		}
	}
	public function getTasks()
	{
		return $this->tasks;
	}
	public function getLastTask()
	{
		return $this->last_task;
	}
	public function getKeywords()
	{
		return $this->keywords;
	}
	public static function get()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	public static function isValidKeyword($try)
	{
		$try = strtolower(trim($try));
		$manager = self::get();
		$keywords = $manager->getKeywords();
		return in_array($try, $keywords);
	}
	public static function getTeamNextTask($team_name)
	{
		$team_manager = TeamManager::get();
		$team = TeamManager::getTeamByName($team_name);
		$current_task = $team->getCurrentTask();
		if (!$team->isTaskCompleted())
		{
			$task_number = $current_task;
		}
		else
		{
			$task_number = self::getNext($current_task);
		}
		if ($team_manager->setTeamTask($team->getName(), $task_number))
		{
			$team_manager->setTaskCompleted($team->getName(), false);
			return $task_number;
		}
		throw new Exception('Failed to get team task!');
	}
	public static function getNext($current)
	{
		$instance = self::get();
		if ($current === $instance->getLastTask())
		{
			return self::FINISHED_TASK;
		}
		else
		{
			return ++$current;
		}
	}
}