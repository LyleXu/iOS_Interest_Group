<?php

require_once 'bingo/odmconfig.php';

use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\IndexedReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

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

$username = $argv[1];
if ($username == null)
{
	echo 'you must specify a user name to send message to';
	return;
}

// Check game room
$userfind = $doctrinemodel->createQueryBuilder('Models\User')
	    ->field('name')->equals($username)
	    ->getQuery()
	    ->getSingleResult();
if ($userfind == null)
{
	echo 'invalid user or status is not online';
	return;
}

$client = new \MessageQueue\Client\MongoDatabaseClient();
$client->initialize("queue_".$userfind->id);

$cmsg = new \Message\ChatMessage('player1', 'hi bingo');

$client->send($cmsg);

echo "Done\r\n";
?>