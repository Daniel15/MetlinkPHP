<?php
class Node_TransportMethod extends Node
{
	public $type;
	public $route;
	public $destination;
	
	public function __construct($data)
	{
		$this->type = $this->getProperType((string) $data['productName']);
		$this->route = (string) $data['shortname'];
		$this->destination = (string) $data['destination'];
	}
	
	protected static function getProperType($type)
	{
		switch ($type)
		{
			case 'Fussweg':
				return 'Walk';
				
			case 'Metropolitan Bus':
				return 'Bus';
				
			case 'Metropolitan Train':
				return 'Train';
				
			case 'Metropolitan Tram':
				return 'Tram';
				
			default:
				return $type;
		}
	}
}
?>