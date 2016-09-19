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
	private static $__route1;
	private static $__params = array();
	public static  $_view_manager = array();
	public static  $_template_map = array();
	private function __construct(){}

	public static function getRoute(){
		$request = $_SERVER['REQUEST_URI'];
		//user/get/id/1 - так выгледит строка запроса
		$splits = explode('/',trim($request,'/'));		
		//Выбор модуля
		//var_dump($splits);
		if(!empty($splits[0])){
		self::$__module = ($key_exists = array_search(ucfirst($splits[0]),Config::$__moduleNames)) ? Config::$__moduleNames[$key_exists] : "Front" ;
		self::$__route = (self::$__module != "Front") ? $splits[1] : $splits[0];
			self::$__route1 = (self::$__module != "Front") ? $splits : NULL;
		self::$__route = ((self::$__module != "Front") && (empty($splits[1]))) ? "index" :self::$__route ;
		self::$__route = (self::$__module == "Front") ? "index" : self::$__route;
		self::$__route = (self::$__module == "Front" && $splits[0]=="login" ) ? "login" : self::$__route;
		self::$__route = (self::$__module == "Front" && $splits[0]=="logout" ) ? "logout" : self::$__route;
		self::$__route = (self::$__module == "Front" && $splits[0]=="fakultet" ) ? "fakultet" : self::$__route;
		self::$__route = (self::$__module == "Front" && $splits[0]=="kafedra" ) ? "kafedra" : self::$__route;
		self::$__route = (self::$__module == "Front" && $splits[0]=="opros" ) ? "opros" : self::$__route;
		self::$__route = (self::$__module == "Front" && $splits[0]=="napryam" ) ? "napryam" : self::$__route;
		self::$__route = (self::$__module == "Front" && $splits[0]=="reset" ) ? "reset" : self::$__route;
		self::$__route = (self::$__module == "Front" && $splits[0]=="registration" ) ? "registration" : self::$__route;
		self::$__route = (self::$__module == "Front" && $splits[0]=="activation" ) ? "activation" : self::$__route;
		//$params_id = 3;	
		}else{
		self::$__module = "Front";
		self::$__route = "index";
	}

		//выбор параметров
	if(self::$__module == "Front"){
		if(!empty($splits[0])){
			if(empty($splits[1]))
				$splits[1] = "1";
			$keys = $values = array();	
			//var_dump($splits);			
			$splits[count($splits)] = (count($splits)%2 == 0) ? $splits[count($splits)] : $splits[count($splits)] = "endo";
						
			for($i=0,$cnt = count($splits); $i<$cnt;$i++){

				if(($i%2 == 0) and ($splits[$i] != null))
					$keys[] = $splits[$i];
				if(($i%2 != 0) and ($splits[$i] != null))
					$values[]= $splits[$i];
				
			}			
		if($keys and $values)
			self::$__params = array_combine($keys,$values);
		//var_dump(self::$__params);
		}
	}else{
			//выбор параметров
		if(!empty($splits[3])){
			$keys = $values = array();
			for($i=3,$cnt = count($splits); $i<$cnt;$i++){
				if($i%2!=0)
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


	public static function getParams(){

		$ttt = array();
				foreach (self::$__params as $key => $value) {
					$ttt[urldecode(trim((htmlspecialchars(strip_tags($key)))))]=urldecode(trim((htmlspecialchars(strip_tags($value)))));
					}

									
			
		return self::$__params = $ttt;
		
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
			 			if(empty(self::$__route1)){
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
			 				}else{
			 					//print_r(self::$__params);
			 					self::$__route1[1] = (empty(self::$__route1[1])) ? 'index' : self::$__route1[1];
			 					self::$__route1[2] = (empty(self::$__route1[2])) ? 'index' : self::$__route1[2];
			 					
								foreach ($value as $key => $value){ 		 				
					 				//Тут value = route по какому урлу будет вызыватся контроллер 
					 				//(проверяется есть ли такой урл  в конфиге)
					 				
					 				if($key == self::$__route1[1])		 			
					 				foreach ($value as $key => $value){	
					 					 					 		 					 			
					 					if($key == self::$__route1[2]){
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
		 //$retVal = ((!empty($access[key(self::$__params)]))) ? 'index' : b ;
		 //var_dump($access);	
		 //self::$__controller2 = (empty(self::$__controller2)) ? self::$__module.'\\Controller\\'.self::$__route1[1] : self::$__controller2;
		//self::$__action2 = (empty(self::$__action2)) ? 'index' : self::$__action2;
		 //echo self::$__controller2;
		 // var_dump( $access);			
		if($access['access'] != 'denyAll' ){

			$controller = self::$__controller2."Controller";
			$controller = new $controller;
			$action = self::$__action2."Action";
			$controller->$action();
		}else{
		 	return include (self::$_template_map['error/404']);
		 						
		}



}











}

