<?php

require_once 'bingo/odmconfig.php';
require_once 'BingoStreamQueue.php';

date_default_timezone_set('UTC');

use Doctrine\Common\ClassLoader,
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

// Initialize Doctrine
$config = new Configuration();
$config->setProxyDir(__DIR__ . '/../cache');
$config->setProxyNamespace('Proxies');
$config->setHydratorDir(__DIR__ . '/../cache');
$config->setHydratorNamespace('Hydrators');
$config->setDefaultDB('bingo');
$reader = new IndexedReader(new AnnotationReader());
$config->setMetadataDriverImpl(new AnnotationDriver($reader, __DIR__ . '/../Models'));
$doctrinemodel = DocumentManager::create(new Connection(), $config);

// Check user available...
// TODO..
// Check user&game...
$username = $argv[1];
$gamename = $argv[2];
if ($username == null || $gamename == null)
{
	echo 'you must specify a user name and game name';
	return;
}

// Check game room
$userfind = $doctrinemodel->createQueryBuilder('Models\User')
	    ->field('name')->equals($username)
	    ->getQuery()
	    ->getSingleResult();
// Check game room
$gamefind = $doctrinemodel->createQueryBuilder('Models\GameRoom')
	    ->field('name')->equals($gamename)
	    ->getQuery()
	    ->getSingleResult();
	    
if ($userfind == null && $gamefind == null)
{
	echo 'invalid user or game room';
	return;
}

// return this result firstly..
$result->_returnCode = \Constant\ErrorCode::OK;
echo json_encode($result);

// Ok, every thing is ready, queue will running
$queue = new \Stream\BingoStreamQueue($userfind->id, $gamefind->id);
$queue->CheckParameter();
$queue->run();

// End