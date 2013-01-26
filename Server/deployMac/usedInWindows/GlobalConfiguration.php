<?php
namespace Utility;

class GlobalConfiguration
{
	private static $instance;
	public $Config = array();
	
	public function __construct()
	{
		$this->Config = parse_ini_file('D:\wamp\bin\php\php5.3.13\config.ini', TRUE);
	}
	
	// The singleton method
    public static function GetInstance() 
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }
}
?>