<?php 
namespace OPF\Db\Adapter\Driver\PDO;

use PDO;

class PdoDbConnection
{
	private static $driver; 
	private static $dsn;
	private static $username;
	private static $dbname;
	private static $password;
	private static $driver_options = array(); 
	public static  $connect = null;

	final protected function __clone() {}
    protected function __construct() {}

	final public static function getInstance(){		
		if (self::$connect === null){		
			self::$connect = new PDO(self::$dsn,self::$username,self::$password,self::$driver_options);
			 //self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				 self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		}
		return self::$connect;
	}

	public static function parse_paramConnection(array $paramConnection){        
					self::$driver   = $paramConnection['driver'];
					self::$dsn      = $paramConnection['dsn'];
					self::$username = $paramConnection['username'];
					self::$password = $paramConnection['password'];
					self::$driver_options = $paramConnection['driver_options']; 			   
	}   
}