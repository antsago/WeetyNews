<?php

require_once('Model.php');

/**
* 
*/
class TweetText extends Model
{
	static $table_name = 'tweet_texts';

	static $belongs_to = array(
		array('tweet')
	);
}