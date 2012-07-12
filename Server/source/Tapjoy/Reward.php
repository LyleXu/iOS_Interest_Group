<?php

require_once 'bingo/odmconfig.php';

use \Constant\ErrorCode,
    Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\IndexedReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

/*
Note: Callback requests from Tapjoy will be in the following format:
http://www.yourserver.com?snuid=001234&currency=2850&id=9876&verifier=5c5eea6d0118a2202aa60743200241bb&affl=55121
*/

// check parameter..
$userid = $_GET["snuid"];
$currencyCount = $_GET["currency"];
$key = "TcH4cJZBzYUSFDh65skH";

/* This script is a starter - template for the Offerpal Callback URL. It will require updating to interact with your Databases
       For more details on the Callback URL go to: http://docs.offerpalmedia.com/integration/callback
       For additional Security information please go to: http://docs.offerpalmedia.com/integration/callback/offerpalSECURE
*/       
$str = $_REQUEST["id"] . ":" . $_REQUEST["snuid"] . ":" . $_REQUEST["currency"] . ":" . $key;

if ($userid == null || $currencyCount == null)
{
	__reportError();
}

if ($_REQUEST["verifier"] == md5($str))
{
	// Process, accept callback
	$doctrinemodel = \Utility\DoctrineConnect::GetInstance(__DIR__ . '/../cache')->Doctrinemodel;
	$user = $doctrinemodel->createQueryBuilder ( 'Models\User' )->field ( '_id' )->equals ( $userid )->getQuery ()->getSingleResult ();
	
	if ($user == null)
	{
		__reportError();
		return;
	}
	
	$user->AddToken($currencyCount);
	$doctrinemodel->flush();
	__reportOK();
}
else
{
	// Not match, reject.
	__reportError();
}

function __reportError()
{
	header('HTTP/1.0 403 Forbidden');
}

function  __reportOK()
{
	header('HTTP/1.0 200 OK');
}
