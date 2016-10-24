<?php

class Team
{
	private $name;
	private $points = 0;
	private $current_task = 0;
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
	public function toArray()
	{
		$array = array();
		$array['name'] = $this->name;
		$array['points'] = $this->points;
		$array['current_task'] = $this->current_task;
		return $array;
	}
}