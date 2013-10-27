<?php

require_once('Model.php');

/**
* 
*/
class Topic extends Model
{
	public static $table_name = 'topics';

	public function before_update(){
	      $this->date = date('Y-m-d', strtotime('now')); 
	}

}
