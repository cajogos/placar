<?php

class TeamManager
{
	private static $instance = null;
	private $file_location = null;
	private $json_contents = null;
	private $teams = array();
	private function __construct()
	{
		$this->file_location = $_SERVER['DOCUMENT_ROOT'] . '/teams.json';
		$this->load();
	}
	public static function get()
	{
		if (empty(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	public static function getTeamByName($team_name)
	{
		$instance = self::get();
		$teams = $instance->getTeams();
		return $teams[$team_name];
	}
	public static function teamExists($team_name)
	{
		if (is_null($team_name))
		{
			return false;
		}
		$instance = self::get();
		$teams = $instance->getTeams();
		return (isset($teams[$team_name]));
	}
	// Team management
	public function getTeams()
	{
		return $this->teams;
	}
	public function addTeam(Team $team)
	{
		$team_name = $team->getName();
		if (trim($team_name) === '')
		{
			return false;
		}
		$this->teams[$team_name] = $team;
		return $this->save();
	}
	public function removeTeam($team_name)
	{
		unset($this->teams[$team_name]);
		return $this->save();
	}
	// Points management
	public function addTeamPoints($team_name, $points = 0)
	{
		if (!isset($this->teams[$team_name]))
		{
			return false;
		}
		$cur_points = $this->teams[$team_name]->getPoints();
		$cur_points += $points;
		return $this->setTeamPoints($team_name, $cur_points);
	}
	public function removeTeamPoints($team_name, $points = 0)
	{
		if (!isset($this->teams[$team_name]))
		{
			return false;
		}
		$cur_points = $this->teams[$team_name]->getPoints();
		$cur_points -= $points;
		return $this->setTeamPoints($team_name, $cur_points);
	}
	public function setTeamPoints($team_name, $points = 0)
	{
		if (!isset($this->teams[$team_name]))
		{
			return false;
		}
		if ($points < 0)
		{
			$points = 0;
		}
		$this->teams[$team_name]->setPoints($points);
		return $this->save();
	}
	public function setTeamTask($team_name, $task_number)
	{
		if (!isset($this->teams[$team_name]))
		{
			return false;
		}
		$this->teams[$team_name]->setCurrentTask($task_number);
		return $this->save();
	}
	public function setTaskCompleted($team_name, $task_completed)
	{
		if (!isset($this->teams[$team_name]))
		{
			return false;
		}
		$this->teams[$team_name]->setTaskCompleted($task_completed);
		return $this->save();
	}
	public function addKeywordUsed($team_name, $keyword_used)
	{
		if (!isset($this->teams[$team_name]))
		{
			return false;
		}
		$this->teams[$team_name]->addUsedKeywords($keyword_used);
		return $this->save();
	}
	public static function isUsedKeyword($team_name, $keyword)
	{
		$instance = self::get();
		$teams = $instance->getTeams();
		if (!isset($teams[$team_name]))
		{
			throw new Exception('Team does not exist!');
		}
		if (!TaskManager::isValidKeyword($keyword))
		{
			throw new Exception('Invalid keyword');
		}
		$team = $teams[$team_name];
		$used_keywords = $team->getUsedKeywords();
		return in_array($keyword, $used_keywords);
	}
	private function load()
	{
		$this->teams = array();
		$file = file_get_contents($this->file_location);
		$this->json_contents = json_decode($file);
		foreach ($this->json_contents as $json)
		{
			$json = (array) $json;
			$cur_team = new Team($json['name']);
			$cur_team->setPoints($json['points']);
			$cur_team->setCurrentTask($json['current_task']);
			if (!isset($json['used_keywords']))
			{
				$json['used_keywords'] = array();
			}
			foreach ($json['used_keywords'] as $keyword)
			{
				$cur_team->addUsedKeywords($keyword);
			}
			$cur_team->setTaskCompleted($json['task_completed']);
			$this->teams[$json['name']] = $cur_team;
		}
	}
	private function save()
	{
		$data = array();
		foreach ($this->teams as $team)
		{
			$data[$team->getName()] = $team->toArray();
		}
		$data_json = json_encode($data, JSON_PRETTY_PRINT);
		if (file_put_contents($this->file_location, $data_json) === false)
		{
			return false;
		}
		return true;
	}
}