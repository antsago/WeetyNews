<?php

require_once('Model.php');

/**
* 
*/
class NewsPaper extends Model
{
	static $table_name = 'news_papers';

	static $belongs_to = array(
		array('language')
	);
}