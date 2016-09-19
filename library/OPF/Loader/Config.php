<?php 
/*
Config - сюда закидуется пермым обший натсроики , а точнее архитекору папок с модулями  базай (ихнии пути)
 потом уже происходит проверка в роутере из основных настроек есть ли такой модуль если есть то берется его путь
 к собстевнному конфигу и забираются уже натсроики данного мудуля (которые могут бфть любыми наиная от базы
 (у каждый модуль может быть подключен к разным базам или источнкам данных(^^ в планах))) 



*/
namespace OPF\Loader;

class Config 
{
	public static $__moduleNames = array();
	private static $__modulePaths = array();
	private static $__paramBaza 	= array();
	private static $__permission 	= array();
	private static $__moduleConfig 	= array();

	public static function run(array $configArchitecture){
		if (!empty($configArchitecture)){
			foreach ($configArchitecture as $key => $value) {				
				switch ($key) {
					case 'module_paths':
						foreach ($value as $key => $value) {
							self::$__modulePaths[$key] = $value;
						}
						break;
					case 'modules':
						foreach ($value as $key => $value) {
							self::$__moduleNames[] = $value;
						}
						break;									
				}
			}
		}
	}


	public static function getParamDb(){
		self::$__paramBaza = include self::$__modulePaths['baza'];
		foreach (self::$__paramBaza as $key => $value) {
			if($key == 'db'){				
				foreach ($value as $key => $value) {
					$paramDb[$key] = $value;					
				}
			}
		}
		return $paramDb;
	}


	public static function getUserPermission(){
		session_start();
		if(!empty($_SESSION['storageUser']) && ($_SESSION['storageUser'] != null) ){
			$role = $_SESSION['storageUser'];
			$role = ( $role['role'] != null) ? $role['role'] : "guest";						
		}else{
			$role = "guest";
		}		
		
		self::$__permission = include self::$__modulePaths['permissions'];
		foreach (self::$__permission as $key => $value) {			
			if($key == $role){				
				foreach ($value as $key => $value) {
					$UserPermission[$key] = $value;
				}
				break;
			}
		}
			//var_dump($UserPermission);
		return $UserPermission;
	}


	public static function getConfigModule($module){
		$path = self::getModulePath();
		$path = $path.DS.$module.DS.'config'.DS.$module.'.config.php';		
		self::$__moduleConfig = include $path;		

	}


	public static function getModuleConfig(){

		return self::$__moduleConfig;

	}

		public static function getModulePath(){

		return self::$__modulePaths['module'];

	}









} 