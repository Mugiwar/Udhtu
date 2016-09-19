<?php
namespace OPF\Permissions\Acl;

use OPF\Mvc\Router\Router;

class Acl
{
	const deny = "deny";
	const allow = "allow";
	const allowAll = "allowAll";
	const denyAll = "denyAll";
	private static $__module;
	private static $__checkRoute = array();
	public static  $__controller;
	private static $__userPermission = array();
	private static $__action; 

	public function __construct(array $userPermission){

		self::$__userPermission = $userPermission;

		self::$__checkRoute = array(
			Router::getModule()		=> self::denyAll,
			Router::getController() => self::denyAll,
			Router::getAction()		=> self::denyAll,
			Router::getParams()		=> self::denyAll,
			'access'				=> self::denyAll,
		);

	}

	private static function checkAccess(){

		foreach (self::$__userPermission as $key => $value) {				
				
			
						if($key == Router::getModule()){							
							foreach ($value['controller'] as $key => $value) {															
								if($key == Router::getController()){															
									foreach ($value['action'] as $key => $value) {
										//var_dump($value);	
										if($key == Router::getAction() and $value == 'allowAll'){											
											self::$__checkRoute['access'] = 'allow';
										}

									}

								}
							}				
						}
					



		}
		

	}

		public function getAccess(){
			self::checkAccess();
			return self::$__checkRoute;

	}

	public function resourceAdd(){


		
	}




	public function privilegeAdd(){


		
	}







}