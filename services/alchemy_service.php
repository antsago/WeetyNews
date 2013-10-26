<?php 

require_once(__DIR__.'/../Libraries/AlchemyApi/alchemyapi.php');

/**
* 
*/
class AlchemyService
{		
	public $alchemyapi;

	function __construct(){
		$this->alchemyapi = new AlchemyAPI();
	}

	public function extract_keywords($text){
		$response = $this->alchemyapi->keywords('text',$text, array('sentiment'=>1));

		if ($response['status'] == 'OK') {
			echo '## Response Object ##', PHP_EOL;

			echo PHP_EOL;
			echo '## Keywords ##', PHP_EOL;
			foreach ($response['keywords'] as $keyword) {
				echo 'keyword: ', $keyword['text'], PHP_EOL;
				echo 'relevance: ', $keyword['relevance'], PHP_EOL;
				echo 'sentiment: ', $keyword['sentiment']['type']; 			
				if (array_key_exists('score', $keyword['sentiment'])) {
					echo ' (' . $keyword['sentiment']['score'] . ')', PHP_EOL;
				} else {
					echo PHP_EOL;
				}
				echo PHP_EOL;
			}
		} else {
			echo 'Error in the keyword extraction call: ', $response['statusInfo'];
		}
	}

	public function extract_entities($text){
		$response = $this->alchemyapi->entities('text',$text, array('sentiment'=>1));

		if ($response['status'] == 'OK') {
			echo '## Response Object ##', PHP_EOL;

			echo PHP_EOL;
			echo '## Entities ##', PHP_EOL;
			foreach ($response['entities'] as $entity) {
				echo 'entity: ', $entity['text'], PHP_EOL;
				echo 'type: ', $entity['type'], PHP_EOL;
				echo 'relevance: ', $entity['relevance'], PHP_EOL;
				echo 'sentiment: ', $entity['sentiment']['type']; 			
				if (array_key_exists('score', $entity['sentiment'])) {
					echo ' (' . $entity['sentiment']['score'] . ')', PHP_EOL;
				} else {
					echo PHP_EOL;
				}
				
				echo PHP_EOL;
			}
		} else {
			echo 'Error in the entity extraction call: ', $response['statusInfo'];
		}
	}
}