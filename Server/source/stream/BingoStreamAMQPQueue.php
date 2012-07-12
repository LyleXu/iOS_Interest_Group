<?php

namespace Stream;

use Constant\ErrorCode;

require_once 'bingo/odmconfig.php';

use \Constant\ConfigKey,
 	\Constant\SectionType,
 	Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\IndexedReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

class BingoStreamAMQPQueue extends \MessageQueue\Queue
{
	protected $userid;
	protected $gameid;
	
	public function __construct($gameid, $userid)
	{
		$this->userid = $userid;
		$this->gameid = $gameid;
		$client = new \MessageQueue\Client\AMQPQueueClient($gameid, $userid);	
			
		parent::__construct($client);
		
		$this->logger =  new \Utility\KLogger ('/var/log/bingo/' . $userid . '.log', \Utility\GlobalConfiguration::GetInstance()->Config[\Constant\SectionType::Logging][\Constant\ConfigKey::LoggingLevel] );
	}
	
	public function CheckParameter()
	{
		return \Constant\ErrorCode::OK;
	}
	
    public function Initialize()
	{
		parent::Initialize();
	}
	
	public function Uninitialize()
	{
		parent::Uninitialize();
	}
}