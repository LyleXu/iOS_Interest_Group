<?php

use Utility\AMQPConnect;
error_reporting(E_ALL | E_STRICT);

require_once 'bingo/odmconfig.php';
require_once __DIR__ . '/BingoStreamAMQPQueue.php';

use \Constant\ErrorCode,
    Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\IndexedReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

// Initialize
set_time_limit(0);

// Create a new queue
$amqpcon = AMQPConnect::getInstance();
$cnn = $amqpcon->getConnection();

$q1 = new AMQPQueue($cnn);
$q1->declare('queue1');

$options = array(
    'min' => 1,
    'max' => 20
);

// Bind it on the exchange to routing.key
//$q1->bind(\Constant\AMQPChannelConstant::AMF, \Constant\AMQPCommand::BingoBroadcast);
//$q1->bind(\Constant\AMQPChannelConstant::AMF, '4ebe6492aeac033931000000');

//$q1->bind(\Constant\AMQPChannelConstant::AMF, '#');
$q1->bind('4ebe6492aeac033931000000', 'bingo.#');
$logger = new \Utility\KLogger ('/var/log/bingo/teststream.log', 
	\Utility\GlobalConfiguration::GetInstance()->Config[\Constant\SectionType::Logging][\Constant\ConfigKey::LoggingLevel] );

do 
{
	// Read from the queue
	$messages = $q1->consume($options);
	
	if ($messages != NULL)
    {
        foreach ($messages as $msg)
        {
			echo $msg['message_body'];
			$logger->LogDebug($msg['message_body'] . PHP_EOL);
        }
    }	
} while (1)
;


