<?php
/*
	
Точка входа всего
	

*/
// Смена дерикотрии на ./ ROOT
ini_set("display_errors",0);
//ini_set("error_reporting", E_ALL);

chdir(dirname(__DIR__));

// Подключение init фаила
if (file_exists('init_autoloader.php')) {
   require_once 'init_autoloader.php';
}


use OPF\Test\Test;
use OPF\Mvc\Router\Router;
use OPF\Mvc\Application;


Application::run(include ('./config/application.config.php'));


	//$bd2 = PdoDbConnection::getInstance();
	//var_dump($bd2);

//while($row = $res_pdo->fetch()) {  
   // echo  $row['id']."-->".$row['content']."-->".$row['title']."<br>";

//$qq = new Test();
//$qq->text();





