<?php

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

// Json result..
$result = new \Json\Commands\BaseResponse();

// check parameter..
$userid = $_GET["userid"];
$gameid = $_GET["gameid"];
if ($userid == null || $gameid == null)
{
	$result->_returnCode = ErrorCode::InvalidUser;
	$result->_returnMessage = "user: $userid game:$gameid";
	echo json_encode($result);
	flush();
	return;
}

// Ok, every thing is ready, queue will be running
$queue = new \Stream\BingoStreamAMQPQueue($gameid, $userid);

$result->_returnCode = $queue->CheckParameter();
if ($result->_returnCode != \Constant\ErrorCode::OK)
{
	echo json_encode($result);
	flush();
}
else 
{	
	// return this result firstly..
	$result->_returnCode = ErrorCode::OK;
	echo json_encode($result);
	flush();

	try {
		$queue->runConsumer();
	}
	catch (Exception $e)
	{
		$result->_returnCode = \Constant\ErrorCode::StreamClosed;
		$result->_returnMessage = $e->__toString();
		echo json_encode($result);
		flush();
		return;
	}
	
	$result->_returnCode = ErrorCode::StreamClosed;
	$result->_returnMessage = 'bye:' . $queue->getExitCode();
	echo json_encode($result);
	flush();
}
// End