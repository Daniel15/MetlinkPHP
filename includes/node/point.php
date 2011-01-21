<?php
class Node_Point extends Node
{
	public $name;
	public $time;
	
	public function __construct($data)
	{
		$this->name = (string) $data['name'];
		$this->time = mktime((int)$data->itdDateTime->itdTime['hour'], (int)$data->itdDateTime->itdTime['minute'], 0, (int)$data->itdDateTime->itdDate['month'], (int)$data->itdDateTime->itdDate['day'], (int)$data->itdDateTime->itdDate['year']);
	}
}
?>