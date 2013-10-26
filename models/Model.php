<?php

require(__DIR__."/../Libraries/php-activerecord/ActiveRecord.php");  

ActiveRecord\Config::initialize(function($cfg)
{
    $cfg->set_model_directory(__DIR__.'/../models');
    $cfg->set_connections(array(
        'development' => 'mysql://root:@localhost/WeetyNews'));
});

class Model extends ActiveRecord\Model
{
	
}
