<?php

error_reporting(E_ALL);

require_once 'gtcclibrary/odmconfig.php';
require_once 'gtcclibrary/dbconfig.php';

use Utility\DoctrineConnect;
use Utility\CommonUtility;
require_once 'gtcclibrary/odmconfig.php';
include_once 'gtcclibrary/Crypt/BingoCrypt.php';
include 'gtcclibrary/InitData.ini.php';
use Doctrine\Common\ClassLoader, Doctrine\Common\Annotations\AnnotationReader, Doctrine\Common\Annotations\IndexedReader, Doctrine\ODM\MongoDB\DocumentManager, Doctrine\MongoDB\Connection, Doctrine\ODM\MongoDB\Configuration, Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

$docConnector = DoctrineConnect::GetInstance(__DIR__ . '/../cache');

$sfcity = $docConnector->Doctrinemodel->getRepository ( 'Models\GameRoom' )->findOneBy ( array ('cityId'=>1 ) );

echo 'Loading city: ' . $sfcity->getName() . PHP_EOL;

$bc = new BingoCrypt ();
// add another 3 users for test city level...
for ($i = 1; $i < 11; $i++) {
	
	echo 'Setup power test user: ' . 'player' . $i . PHP_EOL;
	$newUser = new Models\User ( 'player'.$i, base64_encode ( $bc->encrypt ( 'player'.$i ) ) );
	$newUser->plusXp(10000);
	$newUser->plusCoin(10000);
	$newUser->plusToken(10000);
	$newUser->plusKeys(10000);

	$docConnector->Doctrinemodel->persist ( $newUser );
}

$docConnector->Doctrinemodel->flush();

// Add Powerup

$users = $docConnector->Doctrinemodel->createQueryBuilder('Models\User')->getQuery()->execute()->toArray();
foreach ($users as $user) {
	$docConnector->Doctrinemodel->refresh($user);
	addPowerUpToUser($docConnector->Doctrinemodel, $PowerupTypes, $user, 100);
}

// add another 7 users for test
for ($i = 1; $i < 9; $i++) {
	echo 'Setup city collection test user: ' . 'col' . $i . PHP_EOL;
	$newUser = new Models\User ( 'col'.$i, base64_encode ( $bc->encrypt ( 'col'.$i ) ) );
	buyCollections($docConnector->Doctrinemodel, $newUser, $sfcity, $i);
	$docConnector->Doctrinemodel->persist ( $newUser );
}

// flush
$docConnector->Doctrinemodel->flush ();

echo "Install finished" . PHP_EOL;

function buyCollections($dm, $user, $city, $count)
{
	for ($i = 1; $i <= $count; $i++)
	{
		buyCollection($dm, $user, $city, $i);
	}
}

function buyCollection($dm, $user, $city, $index)
{
	$collection = $dm->getRepository ( 'Models\CityCollectionType' )->findOneBy ( array ('gameRoomId'=>$city->getId(), 'itemId' => $index ) );
	
	// append the collectionId into the user's cityCollection
	$instance = new \Models\CityCollection ();
	$instance->setType($collection);
	$user->getPlayerInfo()->AddCityCollection($instance);
}

function addPowerUpToUser($dm, $PowerupTypes, $user, $count)
{
	$types = $dm->getRepository ( 'Models\PowerUpType' )->findAll ();
	foreach ( $types as $value )
	{
		for($i = 0; $i < $count; $i ++) 
		{
			$powerup = new \Models\PowerUp ( $value->getType(), $user->getId());
			$playerinfo = $user->getPlayerInfo();
			$playerinfo->AddPowerUp ( $powerup );
		}
	}
	$dm->flush ();
}

?>
