<?php

class Team
{
	private $name;
	private $points = 0;
	private $current_task = 0;
	private $last_used_code = null;
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
		$this->current_task = $task;
	}
	// Last Used Task
	public function getLastUsedCode()
	{
		return $this->last_used_code;
	}
	public function setLastUsedCode($last_used_code)
	{
		$this->last_used_code = $last_used_code;
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
		$array['last_used_code'] = $this->last_used_code;
		$array['task_completed'] = $this->task_completed;
		return $array;
	}
}