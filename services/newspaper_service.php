<?php

require(__DIR__."/../models/NewsPaper.php");


/**
* 
*/
class NewsPaperService
{
	public function get_all_news_papers(){
		return NewsPaper::find('all');
	}
}