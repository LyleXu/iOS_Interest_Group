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
    
class DoctrineConnect
{
	private static $instance;
	public $Doctrinemodel;
	
	public function __construct($cacheDir)
	{
		$config = new Configuration();
		$config->setProxyDir($cacheDir);
		$config->setProxyNamespace('Proxies');
		
		$config->setHydratorDir($cacheDir);
		$config->setHydratorNamespace('Hydrators');
		
		$config->setDefaultDB(DB_NAME);
		
		$reader = new IndexedReader(new AnnotationReader());
		$config->setMetadataDriverImpl(new AnnotationDriver($reader, __DIR__ . '/../../Models'));
				
		$connection = new \Doctrine\MongoDB\Connection(DoctrineNativeConnect::GetInstance()->mongo, array(), $config);
		$this->Doctrinemodel = DocumentManager::create($connection, $config);
	}
	
	// The singleton method
    public static function GetInstance($cacheDir) 
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c($cacheDir);
        }

        return self::$instance;
    }
}
?>
