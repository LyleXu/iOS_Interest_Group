<?php

error_reporting(E_ALL | E_STRICT);

require_once 'gtcclibrary/odmconfig.php';
require_once 'gtcclibrary/dbconfig.php';

use Utility\DoctrineConnect;
use Utility\CommonUtility;
require_once 'gtcclibrary/odmconfig.php';
include_once 'gtcclibrary/Crypt/BingoCrypt.php';
include 'gtcclibrary/InitData.ini.php';
use Doctrine\Common\ClassLoader, Doctrine\Common\Annotations\AnnotationReader, Doctrine\Common\Annotations\IndexedReader, Doctrine\ODM\MongoDB\DocumentManager, Doctrine\MongoDB\Connection, Doctrine\ODM\MongoDB\Configuration, Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

// empty db...
Utility\DoctrineNativeConnect::GetInstance()->ClearAllCollections();
$docConnector = DoctrineConnect::GetInstance(__DIR__ . '/../cache');

// Generate Treasure Rate map file
//GenerateTreasureRateMapFile($TreasureChestRates,$KeysTreasureRate,$VirtualGoodsTreasureRates);

$index = 0;
// Initialize gameroom
foreach ( $AllCityInfo as $cityInfo ) {
	$gameroom = new Models\GameRoom ( $cityInfo ['cityName'], $cityInfo ['levelToUnlock'], $cityInfo ['cityName'] );
	$gameroom->setStatus ( \Constant\GameStatus::Offline );
	
	$gameroom->setAlias($cityInfo['cityAlias']);
	$gameroom->setCityId(++$index);
	$gameroom->setDaubXPBonus($cityInfo ['xpPerDuab']);
	$gameroom->setBingoXPBonus($cityInfo ['xpPerBingo']);
	$gameroom->setBingoTokenBonus($cityInfo ['tokenPerBingo']);
	$gameroom->setBingoCoinBonus($cityInfo ['extraCoinsPerBingo']);
	$gameroom->setCostPerCard($cityInfo ['costPerCard']);
	
	$gameroom->setFirstPlaceExtraCoins($cityInfo ['firstPlaceExtraCoins']);
	$gameroom->setFirstPlaceExtraToken($cityInfo ['firstPlaceExtraToken']);
	$gameroom->setSecondPlaceExtraCoins($cityInfo ['secondPlaceExtraCoins']);
	$gameroom->setSecondPlaceExtraToken($cityInfo ['secondPlaceExtraToken']);
	$gameroom->setThirdPlaceExtraCoins($cityInfo ['thirdPlaceExtraCoins']);
	$gameroom->setThirdPlaceExtraToken($cityInfo ['thirdPlaceExtraToken']);
	
	$gameroom->setCoinSlotPayoutLow($cityInfo ['coinSlotPayoutLow']);
	$gameroom->setCoinSlotPayoutHigh($cityInfo ['coinSlotPayoutHigh']);
	
	$gameroom->setMaxCoin($cityInfo ['maxCoin']);
	$gameroom->setMaxToken($cityInfo ['maxToken']);
	$gameroom->setDailyTokenCollectionCompleted($cityInfo['dailyTokenCollectionCompleted']);	
	
	$docConnector->Doctrinemodel->persist ( $gameroom );
}

$docConnector->Doctrinemodel->flush ();



// Init key package data.
InitPackage ( $KeyPackages, 'Models\KeyPackage', $docConnector->Doctrinemodel );

// Init powerups package data.
InitPackage ( $PowerupsPackages, 'Models\PowerUpsPackage', $docConnector->Doctrinemodel );

// Init powerups type data.
{
	foreach ( $PowerupTypes as $value ) {
		// Initialize keys
		$powerupType = new Models\PowerUpType ();
		$powerupType->setType($value[0]);
		$powerupType->setName($value[1]);
		$powerupType->setCountInitUserHas($value[2]);  // need to do
		$powerupType->setRate($value[3]);
		$docConnector->Doctrinemodel->persist ( $powerupType );
	}
}

$docConnector->Doctrinemodel->flush ();

// Init Achievements
foreach ( $Achievements as $value ) {
	// Initialize Achievements
	$achievemnt = new Models\Achievements ();
	$achievemnt->setNumber($value [0]);
	$achievemnt->setName($value [1]);
	$achievemnt->setDescription($value [2]);
	$achievemnt->setAfterDescription($value [3]);
	$achievemnt->setOpenfeintId($value [4]);
	
	$docConnector->Doctrinemodel->persist ( $achievemnt );
}

// Init Powerup random array
{
	$minBase = 100;

	$randomArray = array();		
	foreach ($PowerupTypes as $value) {
		$rate = $value[3];
		$tmpArray = array_fill(0, $rate * $minBase, $value[0]);
		$randomArray = array_merge($randomArray, $tmpArray);
	}
	
	shuffle($randomArray);
	
	$powerupRandomArray = new \Models\PowerupRandomArray();
	$powerupRandomArray->mergeRandomArray($randomArray);
	$docConnector->Doctrinemodel->persist($powerupRandomArray);
}

// flush
$docConnector->Doctrinemodel->flush ();

// Init CityCollection
{
	$gamerooms = array_values ( $docConnector->Doctrinemodel->createQueryBuilder ( 'Models\GameRoom' )->sort ( 'id', 'asc' )->getQuery ()->execute ()->toArray () );
	$i = 0;
	foreach ( $gamerooms as $gameroom ) {
		
		echo 'Setup collection for city: ' . $gameroom->getName() . PHP_EOL;
		
		$cityCollection = $AllCityCollections [$i];
		
		foreach ( $cityCollection as $key => $item ) {
			$coll = new Models\CityCollectionType ();
			$coll->setRoomId($gameroom->getId());
			$coll->setName($item ['name']);
			$coll->setItemId($key + 1);
			$coll->setPrice($item ['price']);
			$docConnector->Doctrinemodel->persist ( $coll );
		}
		
		$i ++;
	}
}

$docConnector->Doctrinemodel->flush ();

echo "Install finished" . PHP_EOL;

function GetRandomTreasureRateMap($cityTreatureRates) {
	$baseSize = 1000;
	$typeRateMap = array();
	foreach ($cityTreatureRates as $key=> $treasureRate) {
		$tmpArray =  array_fill(0, $treasureRate[2] * $baseSize, $key);
		$typeRateMap = array_merge($typeRateMap,$tmpArray);
	}
	
	shuffle($typeRateMap);
	
	return $typeRateMap;
}

function InitPackage($packages, $className, $dm) {
	foreach ( $packages as $value ) {
		// Initialize keys
		$keyPackage1 = new $className ();
		$keyPackage1->setPackageId($value [0]);
		$keyPackage1->setAmount($value [1]);
		$keyPackage1->setPrice($value [2]);
		
		$dm->persist ( $keyPackage1 );
	}
}

function GenerateTreasureRateMapFile($TreasureChestRates,$KeysTreasureRate,$VirtualGoodsTreasureRates) {
	$filename = __DIR__ . '/TreasureRateMap.php';
	
	$content = '<?php'.PHP_EOL;
	
	
	$treasureChestTypeRateDef = array();
	$treasureChestTypeRandomArray = array();
	foreach ($TreasureChestRates as $key => $value) {	
		$cityTreatureRates = array_merge($value,$KeysTreasureRate,$VirtualGoodsTreasureRates);
		$randarray = GetRandomTreasureRateMap($cityTreatureRates);
		$treasureChestTypeRateDef[$key] = $cityTreatureRates;
		$treasureChestTypeRandomArray[$key] = $randarray;
	}
	
	//var_dump($treasureChestTypeRateDef);
	$content .=  '$treasureChestTypeRateDef = '.WriteArrayToString($treasureChestTypeRateDef).';'.PHP_EOL;
	$content .=  '$treasureChestTypeRandomArray = '.WriteArrayToString($treasureChestTypeRandomArray).';'.PHP_EOL;
	
	file_put_contents($filename, $content);
}

function WriteArrayToString($array)
{
	$content = 'array(';
	foreach ($array as $value) {
		if(is_array($value))
		{
			$content .= WriteArrayToString($value).',' ;
		}else 
		{
			$content .= "$value,";
		}
	}
	
	// remove the last ','
	$content = substr($content, 0,-1);
	$content .= ')';
	return $content;
}

?>
