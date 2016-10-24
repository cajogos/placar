<?php

class Task
{
	private $id;
	private $view;
	private $view_contents;
	public function __construct($arr)
	{
		$this->id = $arr['id'];
		$this->view = $arr['view'];
		$this->load();
	}
	private function load()
	{
		$file = $_SERVER['DOCUMENT_ROOT'] . '/tasks/views/' . $this->view;
		$this->view_contents = file_get_contents($file);
	}
	public function getId()
	{
		return $this->id;
	}
	public function getView()
	{
		return $this->view;
	}
}