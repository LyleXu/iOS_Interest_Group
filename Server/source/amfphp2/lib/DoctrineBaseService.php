<?php
use Json\Data\GearmanWorkload;
use Constant\GearmanCommand;
use Utility\AMQPConnect;
use Constant\ErrorCode;
use Json\Commands\BaseResponse;

include_once 'gtcclibrary/odmconfig.php';

use Doctrine\Common\ClassLoader, Doctrine\Common\Annotations\AnnotationReader, Doctrine\Common\Annotations\IndexedReader, Doctrine\ODM\MongoDB\DocumentManager, Doctrine\MongoDB\Connection, Doctrine\ODM\MongoDB\Configuration, Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

abstract class DoctrineBaseService {
	protected $doctrinemodel = null;
	protected $Logger;
	 
	public function __construct() {	

		$this->doctrinemodel = \Utility\DoctrineConnect::GetInstance(__DIR__ . '/../../cache')->Doctrinemodel;
		
		$this->Logger = new \Utility\KLogger ('/var/log/gtcclibrary/amfservice.log', 
			\Utility\GlobalConfiguration::GetInstance()->Config[\Constant\SectionType::Logging][\Constant\ConfigKey::LoggingLevel] );
	}
	
	protected function GetVistorIpAddress() {
		return $_SERVER['REMOTE_ADDR'];
	}
	
	
	

	
	
	
	
	protected static function object_to_array(stdClass $Class){
	    $Class = get_object_vars($Class);
	    
	    # Iterate through the former properties looking for any stdClass properties.
	    # Recursively apply (array).
	    if (is_array($Class))
	    {    
			foreach($Class as $key => $value){
		        	if(is_object($value)&&get_class($value)==='stdClass')
					$Class[$key] = self::object_to_array($value);
			}
	    }
    	return $Class;
	}
}
?>
