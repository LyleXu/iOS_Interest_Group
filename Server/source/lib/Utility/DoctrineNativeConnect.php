<?php
namespace Utility;

require_once 'gtcclibrary/odmconfig.php';
require_once 'gtcclibrary/dbconfig.php';

use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\IndexedReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
    
class DoctrineNativeConnect
{
	private static $instance;
	public $mongo;
	public $mongodb;
	
	public function __construct()
	{
		$this->mongo = new \Mongo("mongodb://" . DB_USER . ':' . DB_PASSWORD . '@' . DB_HOST);
		$this->mongodb = $this->mongo->selectDB(DB_NAME);
	}
	
	// The singleton method
    public static function GetInstance() 
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c();
        }

        return self::$instance;
    }
    
    public function ClearAllCollections()
    {
    	$list = $this->mongodb->listCollections();
		foreach ($list as $collection) {
		    $collection->drop();
		}
    }
}
?>
