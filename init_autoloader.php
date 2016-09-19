<?php
/*
	Подклчючения класса автолоадера

*/
	define("__ROOT__", __DIR__);
	define("DS", DIRECTORY_SEPARATOR);

if (is_dir('./library/OPF/Loader')){
	require_once('./library/OPF/Loader/Autoloader.php');
	Autoloader::basePath('./library','./module');	 
}

	

