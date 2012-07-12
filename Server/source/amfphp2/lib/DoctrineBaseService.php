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
	
	protected function CheckTokenWithUserId($userid) {
		
		if (\Utility\GlobalConfiguration::GetInstance()->Config[\Constant\SectionType::General][\Constant\ConfigKey::AMFCheckUserSession] == 0)
			return ErrorCode::OK;
			
		try {
			$headers = getallheaders ();
			if (isset ( $headers ['Token'] )) {
				// get user token
				$result = $this->doctrinemodel->getRepository ( 'Models\User' )->findOneBy ( array ('_id' => $userid, 'sessiontoken' => $headers ['Token'] ) );
				if ($result == null) {
					return ErrorCode::UserOffline;					
				} else {
					return ErrorCode::OK;
				}
			} else {
				return ErrorCode::EmptyToken;
			}
		} catch ( Exception $e ) {
				return ErrorCode::Failed;
		}
	}
	
	protected function CheckTokenWithUserName($userName) {
		if (\Utility\GlobalConfiguration::GetInstance()->Config[\Constant\SectionType::General][\Constant\ConfigKey::AMFCheckUserSession] == 0)
			return ErrorCode::OK;
			
		try {
			$headers = getallheaders ();
			if (isset ( $headers ['Token'] )) {
				// get user token
				$result = $this->doctrinemodel->getRepository ( 'Models\User' )->findOneBy ( array ('name' => $userName, 'session' => $headers ['Token'] ) );
				if ($result == null) {
					return ErrorCode::UserOffline;					
				} else {
					return ErrorCode::OK;
				}
			} else {
				return ErrorCode::EmptyToken;
			}
		} catch ( Exception $e ) {
				return ErrorCode::Failed;
		}
	}	

	protected function broadcastEvent($gameid, \MessageQueue\Message $message) {
		
		try {
			$channel = new \Utility\AMQPChannel($gameid, FALSE);
			$channel->broadCastGameMessage($message);
		}
		catch (Exception $e)
		{
			throw  $e;
		}
		
		/* 		
		$event = \Utility\EventFactory::buildBingoEvent($message);
		$workload = new GearmanWorkload($gameid, json_encode($event));
		// post a task...
		# create our client object
		$gmclient= new \GearmanClient();
		# add the default server (localhost)
		$gmclient->addServer();
		
		# run reverse client in the background
		$job_handle = $gmclient->doBackground(\Constant\GearmanCommand::Broadcast, serialize($workload));
		*/
	}
	
	protected function sendEventToUser($gameid, $userid, \MessageQueue\Message $message) {
		try {
			$channel = new \Utility\AMQPChannel($gameid, FALSE);
			$channel->sendGameMessage($userid, $message, 'amf');
		}
		catch (Exception $e)
		{
			throw  $e;
		}
		
		/*
		// build gtcclibrary event here...
		$event = \Utility\EventFactory::buildBingoEvent($message);
		$workload = new GearmanWorkload($gameid, json_encode($event), $userid);
		// post a task...
		# create our client object
		$gmclient= new \GearmanClient();
		# add the default server (localhost)
		$gmclient->addServer();
		
		# run reverse client in the background
		$job_handle = $gmclient->doBackground(\Constant\GearmanCommand::SendToUser, serialize($workload));
		*/
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
