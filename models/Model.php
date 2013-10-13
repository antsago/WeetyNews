<?php

require(__DIR__."/../libs/database.php");  

class Model
{
	
	function __construct()
	{
		$this->db = new Database();
	}
}
