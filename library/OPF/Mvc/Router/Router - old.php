<?php
/*
Router - роутер запускается после конфига(после 1 части конфига который получают основные настроики 
потом роутер получает модуль) и передает его опять в конфиг  где конфиг получает конфигурации модуля и передает
 их опять роутеру но уже не базовые а конкретного модуля который вызывает пользователь ) дальше парсится
  конфиг и сверяется с путями выбитыми пользователям если находит
   то забирает имя контроллера и экшена и создает  все это )))



*/
namespace OPF\Mvc\Router; 
use OPF\Loader\Config;
use OPF\Permissions\Acl\Acl;
class Router
{
	private static $__module;
	private static $__moduleConfig = array();
	public static  $__controller;
	public static  $__controller2;
	private static $__action;
	public static  $__action2;
	private static $__route;
	private static $__params = array();
	public static  $_view_manager = array();
	public static  $_template_map = array();
	private function __construct(){}

	public static function getRoute(){
		$request = $_SERVER['REQUEST_URI'];
		//user/get/id/1 - так выгледит строка запроса
		$splits = explode('/',trim($request,'/'));		
		//Выбор модуля
		if(!empty($splits[0])){
		self::$__module = ($key_exists = array_search(ucfirst($splits[0]),Config::$__moduleNames)) ? Config::$__moduleNames[$key_exists] : "Front" ;
		self::$__route = (self::$__module != "Front") ? $splits[1] : $splits[0];
		self::$__route = ((self::$__module != "Front") && (empty($splits[1]))) ? "index" :self::$__route ;
		//$params_id = 3;	
		}else{
		self::$__module = "Front";
		self::$__route = "index";
	}

		//выбор параметров
	if(self::$__module == "Front"){
		if(!empty($splits[1])){
			$keys = $values = array();
			for($i=1,$cnt = count($splits); $i<$cnt;$i++){
				if($i%2!=0)
					$keys[] = $splits[$i];
				else
					$values[]= $splits[$i];
			}
		if($keys and $values)
			self::$__params = array_combine($keys,$values);
		//var_dump(self::$__params);
		}
	}else{
			//выбор параметров
		if(!empty($splits[2])){
			$keys = $values = array();
			for($i=2,$cnt = count($splits); $i<$cnt;$i++){
				if($i%2==0)
					$keys[] = $splits[$i];
				else{
					//$values[] = (!empty($splits[$i])) ? $splits[$i] : null ;
					$values[]= $splits[$i];
				}
			}
		if($keys and $values)
			self::$__params = array_combine($keys,$values);
		//var_dump(self::$__params);
	}}

}

	public static function getModule(){

		return self::$__module;

	}


	public static function getController(){

		self::$__controller = explode('\\',self::$__controller2);		
		if (!empty(self::$__controller[2])){
			self::$__controller = self::$__controller[2];
			return self::$__controller ;
		}
			
	}

	public static function getAction(){

		return self::$__action2;
		
	}


	public function getParams(){

		return self::$__params;
		
	}
//Если понадобится  чтобі  1 шаблон применять на всех модулях без копирования в папку
// то доделать + изменить в конфиге название масива с путем к вью или шаблона
	public function getPathView(){

		self::$_template_map['view/module/controller'];
		self::$_template_map['layout/layout'];
	}


	private static function parseModuleConfig(){		 
		foreach (Config::getModuleConfig() as $key => $value){		
		 	switch ($key){
		 		case 'router':
		 		//Тут value = Routes из конфига мдуля которого получены настоики
		 			foreach ($value as $key => $value){ 
		 				//Тут value = route по какому урлу будет вызыватся контроллер 
		 				//(проверяется есть ли такой урл  в конфиге) 
		 				foreach ($value as $key => $value){
		 					if($key == self::$__route){
		 						foreach ($value as $key => $value) {
		 							if ($key == 'options')
		 								foreach ($value as $key => $value){
		 									if ($key == 'defaults')
		 										foreach ($value as $key => $value) {
		 											switch ($key) {
		 												case 'controller':
		 													self::$__controller2 = $value;
		 													break;
		 												case 'action':
		 													self::$__action2 = $value;
		 													break;
		 													
		 											}				 												
		 										}	
		 									}
		 								}			
		 							}			
		 						}
		 					}
		 			break;		 			
		 		case 'view_manager':
		 			foreach ($value as $key => $value) {
		 				if ($key != 'template_map') {
		 					self::$_view_manager[$key] = $value;
		 				}else{
		 					foreach($value as $key => $value){
		 					self::$_template_map[$key] = $value;
		 					}
		 				}		 				
		 			}
		 			break;
		 		case 'controllers':
		 				# code...
		 				break;	
		 	}		
		}
	}



	public static  function run(){		
		self::getRoute();		
		Config::getConfigModule(self::$__module);			
		self::parseModuleConfig();
		$acl = new Acl(Config::getUserPermission());
		 $access = $acl->getAccess();	
		 //var_dump($access);	
		 //echo $access[self::$__controller];
		  //var_dump($acl->checkModule());	
		if((!empty(self::$__controller2)	&&
			 ($access[self::$__module] != 'denyAll') &&
			  ($access[self::$__controller] != 'denyAll'))){

			$controller = self::$__controller2."Controller";
			$controller = new $controller;
			$action = self::$__action2."Action";
			$controller->$action();
		}else{
		 	return include (self::$_template_map['error/404']);
		 						
		}



}











}

