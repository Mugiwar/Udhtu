<?php
return array(
	'db' => array(
		'driver' 		 => 'Pdo',
		'dsn' 	 		 => 'mysql:dbname=;hostname=127.0.0.1',
		'username' => '',
		'password' => '',
		'driver_options' => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
		),
	),

);
