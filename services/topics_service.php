<?php
require_once(__DIR__."/../models/Model.php");

/**
 * Class to manipulate topics
 */
class TopicService
{

  public function __construct()
  {
  }

  
  public function sum_entities($entities_per_newspaper)
  {

    $summed_entities = array();

    foreach($entities_per_newspaper as $alchemyEntities)
      foreach($alchemyEntities['entities'] as $entity)
      {
	$text = $entity['text'];
	if (!isset($summed_entities[$text])) $summed_entities[$text] = 0;
	$summed_entities[$text] += $entity['relevance'];
      }
    arsort($summed_entities);
    return $summed_entities;

  }
  
  public function store_topics($listOfTopics)
  {
    $rank = 1;
    foreach($listOfTopics as $index => $topic)
    {
      Topic::create(array(
	  'text' => $index,
	  'rank' => $rank
	));

      $rank++;
    }
  }


}

?>
