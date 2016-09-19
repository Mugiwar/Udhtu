<?php

//Класс для подключения других классов к которым обращаются
class Autoloader 
{
	static protected $__pathLib;
	static protected $__pathModule;
	static public function loader($className) {			
		$filename = self::path($className).DS. str_replace('\\', '/', $className) . ".php";
		if (file_exists($filename)) {			
			include($filename);
			if (class_exists($className)) {
				return TRUE;
			}
		}
			return FALSE;
	}
//Получения пути к папки с библиатекаи\классами в которой будет проводится поиск нужного
	static public function basePath($pathLib,$pathModule){

		self::$__pathLib = $pathLib;
		self::$__pathModule = $pathModule;
	}


	private static function path($class){		
		$splits = explode('\\',$class);			
		if($splits[0] != "OPF"){			
			$path = self::$__pathModule.DS.$splits[0].DS.'src';					
		}else{
			$path = self::$__pathLib;
		}
		return $path;
	} 


}
spl_autoload_register('Autoloader::loader');