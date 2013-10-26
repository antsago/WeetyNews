<?php

require_once('Model.php');

/**
* 
*/
class Tweet extends Model
{
	static $table_name = 'tweets';

	static $belongs_to = array(
		array('news_paper')
	);

	static $has_many = array(
		array('tweet_texts', 'conditions' => array('void = ?' => array(0)))
	);
}