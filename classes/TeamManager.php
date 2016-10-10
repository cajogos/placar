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

	public function addTeamPoints($team_name, $points = 0)
	{
		if (!isset($this->teams[$team_name]))
		{
			return false;
		}
		$cur_points = $this->teams[$team_name]->getPoints();
		$cur_points += $points;
		$this->setTeamPoints($team_name, $cur_points);
	}

	public function removeTeamPoints($team_name, $points = 0)
	{
		if (!isset($this->teams[$team_name]))
		{
			return false;
		}
		$cur_points = $this->teams[$team_name]->getPoints();
		$cur_points -= $points;
		$this->setTeamPoints($team_name, $cur_points);
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

	// Team management
	public function addTeam(Team $team)
	{
		$this->teams[$team->getName()] = $team;
		$this->save();
	}

	public function removeTeam($team_name)
	{
		unset($this->teams[$team_name]);
		$this->save();
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