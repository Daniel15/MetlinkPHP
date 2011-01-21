<?php
class Node_Place extends Node
{
	public $valid;
	public $input;
	public $options = null;
	
	public function __construct($data)
	{		
		switch ($data['state'])
		{
			case 'notidentified':
				$this->valid = false;
				$this->input = (string)$data->odvNameInput;
				$this->options = null;
				break;
				
			case 'identified':
				$this->valid = true;
				$this->input = (string)$data->odvNameInput;
				$this->value = (string)$data->odvNameElem;
				break;
				
			case 'list':
				$this->valid = false;
				$this->input = (string)$data->odvNameInput;
				$this->options = array();
				
				foreach ($data->odvNameElem as $item)
					$this->options[] = (string)$item;
				
				break;
		}
	}
}
?>