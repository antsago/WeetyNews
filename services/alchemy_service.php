<?php 

require_once(__DIR__.'/../Libraries/AlchemyAPI/alchemyapi.php');

/**
* 
*/
class AlchemyService
{		
	public $alchemyapi;

	function __construct()
	{
		$this->alchemyapi = new AlchemyAPI();
	}

	public function extract_keywords($text)
	{
		$response = $this->alchemyapi->keywords('text',$text, array('sentiment'=>1));
		return $response;
	}

	public function extract_entities($text)
	{
		$response = $this->alchemyapi->entities('text',$text, array('sentiment'=>1));
		return $response;
	}
}
