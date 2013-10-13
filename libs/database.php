<?php 

require_once 'php-activerecord/ActiveRecord.php';

ActiveRecord\Config::initialize(function($cfg)
{
    $cfg->set_model_directory('../models');
    $cfg->set_connections(array(
        'development' => 'mysql://root:@localhost/WheetyNews'));
});

class Database extends ActiveRecord\Model
{
	
	function __construct()
	{
		// parent::__construct('mysql:host=localhost;dbname=WeetyNews', 'root', '');
	}
}
