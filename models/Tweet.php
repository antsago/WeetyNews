<?php

require_once('Model.php');

/**
* 
*/
class Tweet extends Model
{
	static $table_name = 'raw_tweets';

	static $belongs_to = array(
		array('language')
	);
}