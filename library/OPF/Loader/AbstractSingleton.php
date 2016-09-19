<?php
namespace OPF\Loader;
abstract class AbstractSingleton
{
    /**
     * @return Singleton
     */
    protected static $_paramConnection = array();

    final public static function getInstance(array $configConnection = null)
    {
        self::$_paramConnection = $configConnection;
        static $instance = null;
        
        if (null === $instance)
        {
            $instance = new static();
        }

        return $instance;
    }

    final protected function __clone() {}
    protected function __construct() {}
}