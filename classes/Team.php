<?php

class Team
{
	private $name;
	private $points = 0;
	private $current_task = 0;
	private $used_keywords = array();
	private $task_completed = false;
	public function __construct($name)
	{
		$this->name = $name;
	}
	// Name
	public function getName()
	{
		return $this->name;
	}
	public function setName($name)
	{
		$this->name = $name;
	}
	// Points
	public function getPoints()
	{
		return $this->points;
	}
	public function setPoints($points)
	{
		$this->points = $points;
	}
	// Current Task
	public function getCurrentTask()
	{
		return $this->current_task;
	}
	public function setCurrentTask($task)
	{
		if (is_null($task))
		{
			$task = 0;
		}
		$this->current_task = $task;
	}
	// Used Keywords
	public function getUsedKeywords()
	{
		return $this->used_keywords;
	}
	public function addUsedKeywords($used_keyword)
	{
		if (!in_array($used_keyword, $this->used_keywords))
		{
			$this->used_keywords[] = $used_keyword;
		}
	}
	// Task Completed
	public function isTaskCompleted()
	{
		return $this->task_completed;
	}
	public function setTaskCompleted($is_completed)
	{
		$this->task_completed = (bool) $is_completed;
	}
	public function toArray()
	{
		$array = array();
		$array['name'] = $this->name;
		$array['points'] = $this->points;
		$array['current_task'] = $this->current_task;
		$array['used_keywords'] = $this->used_keywords;
		$array['task_completed'] = $this->task_completed;
		return $array;
	}
}