<?php
/*
Application - запускает все инициализирует




*/
namespace OPF\Mvc;
use OPF\Loader\Config;
use OPF\Mvc\Router\Router;
use OPF\Db\Adapter\Driver\PDO\PdoDbConnection;

class Application
{
	protected $mainConfig = array();	
    final protected function __clone() {}
    protected function __construct() {}

	public static function run(array $configArchitecture){		
		Config::run($configArchitecture);
		PdoDbConnection::parse_paramConnection(Config::getParamDb());
		Router::run();		
				
		
		 
	}



	
}
