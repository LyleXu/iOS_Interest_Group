<?php

//
//	Setup ClassLoader
//

use Json\Data\CCardData;
use Json\Commands\BaseResponse;
use Doctrine\Common\ClassLoader;
require '../../Doctrine/Common/ClassLoader.php';

$cdoclassLoader = new ClassLoader('Doctrine\Common', '../../');
$jsonclassLoader = new ClassLoader('Json', '../../');

$cdoclassLoader->register();
$jsonclassLoader->register();

//
// Generate PHP schema here..
//

// Generate for Game BaseResponse
{
	$baseResponse = new BaseResponse();
	$baseResponse->_returnCode = 0;
	$baseResponse->_returnMessage = "error message";
	
	func_genSchema($baseResponse);
}

// Generate for GameRoom
{
	$gameroom = new \Json\Commands\GameRoom();
	$gameroom->id = uniqid();
	$gameroom->level = 1;
	$gameroom->name = 'Game City Name';
	$gameroom->description = 'Game City Description';
	$gameroom->status = 2;
	
	func_genSchema($gameroom);
}

// Generate for GameRoomListResponse
{
	$gameroom1 = new \Json\Commands\GameRoom();
	$gameroom1->id = uniqid();
	$gameroom1->level = 1;
	$gameroom1->name = 'Game City1 Name';
	$gameroom1->description = 'Game City1 Description';
	$gameroom1->status = 2;
	
	$gameroom2 = new \Json\Commands\GameRoom();
	$gameroom2->id = uniqid();
	$gameroom2->level = 2;
	$gameroom2->name = 'Game City2 Name';
	$gameroom2->description = 'Game City2 Description';
	$gameroom2->status = 2;
	
	$gamerooms = new \Json\Commands\GameRoomListResponse();
	$gamerooms->allRooms = array( 0 => $gameroom1, 1 => $gameroom2);
	
	func_genSchema($gamerooms);
}

// Generate for GameRoomStatusResponse
{
	$gameroomstatus = new \Json\Commands\GameRoomStatusResponse();
	$gameroomstatus->_returnCode = 0;
	$gameroomstatus->_returnMessage = "error message";
	$gameroomstatus->roomstatus = 1;
	$gameroomstatus->roundstatus = 1;
	
	func_genSchema($gameroomstatus);
}

// Generate for LoginResponse
{
	$loginresponse = new \Json\Commands\LoginResponse();
	$loginresponse->_returnCode = 0;
	$loginresponse->_returnMessage = "error message";
	$loginresponse->sessionId = uniqid();
	$loginresponse->userId = uniqid();
	
	func_genSchema($loginresponse);
}

// Generate for NonceResponse
{
	$response = new \Json\Commands\NonceResponse();
	$response->_returnCode = 0;
	$response->_returnMessage = "error message";
	$response->nonce = 'A2yzY4';
	
	func_genSchema($response);
}

// Generate for RegisterResponse
{
	$response = new \Json\Commands\RegisterResponse();
	$response->_returnCode = 0;
	$response->_returnMessage = "error message";
	$response->nonce = 'A2yzY4';
	$response->registerId = uniqid();
	
	func_genSchema($response);
}

// Generate for Data\CBingoCallInfo
{
	$data = new \Json\Data\CBingoCallInfo();
	$data->gameRoundId = uniqid();
	$data->playerName = 'player1';
	$data->rankIndex = 1;
	$data->time = time();
	
	func_genSchema($data);
}

// Generate for Data\CCardData
{
	$card = range(0, 4);
	$card[0] = range(1, 5);
	$card[1] = range(16, 20);
	$card[2] = range(31, 35);
	$card[3] = range(46, 50);
	$card[4] = range(61, 65);
	
	$data = new \Json\Data\CCardData($card, 1, array());
	
	func_genSchema($data);
}

// Generate for Data\CGameRoundInfo
{
	$data = new \Json\Data\CGameRoundInfo();
	$data->bingos = 1;
	$data->cards = 100;
	$data->gameRoundId = uniqid();
	$data->players = 20;
	
	func_genSchema($data);
}

// Generate for Data\CGameRoundResult
{
	$card = range(0, 1);
	$card[0] = range(1, 5);
	$card[1] = range(16, 20);
	
	$data = new \Json\Data\CGameRoundResult();
	$data->result = 1;
	$data->gameRoundId = uniqid();
	
	func_genSchema($data);
}

// Generate for PowerUpsResponse
{
	$PowerupsResponse = new \Json\Commands\PowerUpsResponse();
	$PowerupsResponse->_returnCode = 0;
	$PowerupsResponse->_returnMessage = "error message";
	$PowerupsResponse->_powerUps = array(
			array(
                    "id" => "4e2abf806803fac929000005",
                    "type" => 0,
                    "name" => 'Single Daub',
                    "description" => 'desp1'
                ),
          	array(
                 	"id" => "4e2abf806803fac929000006",
                    "type" => 1,
                    "name" => 'Double Daub',
                    "description" => 'desp2'
                )                              
	);
	
	func_genSchema($PowerupsResponse);
}

// Generate for Achievements
{
	$ach1 = new \Json\Data\CAchievement();
	$ach1->id = "4e1f1ae66803fad407000008";
	$ach1->number = 1;
	$ach1->name ='First Bingo';
	$ach1->description ='Get the first bingo';
	
	$ach2 = new \Json\Data\CAchievement();
	$ach2->id = "4e1f1ae66803fad407000009";
	$ach2->number = 2;
	$ach2->name ='Level 5';
	$ach2->description ='Reach the level 5';
	
	$AchievementsResponse = new \Json\Commands\AchievementsResponse();
	$AchievementsResponse->_returnCode = 0;
	$AchievementsResponse->_returnMessage = "error message";
	$AchievementsResponse->achievements = Array
        ($ach1, $ach2);
	
	func_genSchema($AchievementsResponse);
}

// Generate for ProfileResponse
{
	$ProfileResponse = new \Json\Commands\ProfileResponse();
	$ProfileResponse->_returnCode = 0;
	$ProfileResponse->_returnMessage = "error message";
	$ProfileResponse->xp = 100;
	$ProfileResponse->bingos = 2;
	$ProfileResponse->token = 20;
	$ProfileResponse->coin = 500;
	//$ProfileResponse->nickName = 'Mike';

	func_genSchema($ProfileResponse);
}

// Generate for EvaluateResultResponse
{
	$EvaluateResultResponse = new \Json\Commands\EvaluateResultResponse();
	$EvaluateResultResponse->_returnCode = 0;
	$EvaluateResultResponse->_returnMessage = "error message";
	$EvaluateResultResponse->gameResult = array(
		"xp" => 100,
	    "token" => 20,
	    "coin" => 500,
		"keys" => 15,
		"powerUps" => 3,
		"teamPoints" => 2,
		"treasureChests" => 3
	);
	
	func_genSchema($EvaluateResultResponse);
}

// Generate for CityCollectionResponse
{
	$CityCollectionResponse = new \Json\Commands\CityCollectionResponse();
	$CityCollectionResponse->_returnCode = 0;
	$CityCollectionResponse->_returnMessage = "error message";
	$CityCollectionResponse->cityCollection = array(
		array(
			  'id' => '4e2abf806803fac929000016',
              'gameRoomId' => '4e2abf806803fac929000012',
              'name' => 'Pizza',
              'description' => 'the food',
              'price' => '500'
		),
		array(           
             'id' => '4e2abf806803fac929000017',
              'gameRoomId' => '4e2abf806803fac929000012',
              'name' => 'pigeon',
              'description' => 'the bird',
              'price' => '750'
		)
	);
	
	func_genSchema($CityCollectionResponse);
}

// Generate Special number response
{
	$CityCollectionResponse = new \Json\Commands\SpecialNumberResponse();
	$CityCollectionResponse->_returnCode = 0;
	$CityCollectionResponse->_returnMessage = "error message";
	$CityCollectionResponse->specialNumbers = array(3,15,46,69);
	$CityCollectionResponse->doubleDaubSecondSpecialNumbers = array(5,10,36,59); // only double daub has this additional value
	
	func_genSchema($CityCollectionResponse);
}

// Generate treasure response
{
	$CityCollectionResponse = new \Json\Commands\TreasureResponse();
	$CityCollectionResponse->_returnCode = 0;
	$CityCollectionResponse->_returnMessage = "error message";
	$CityCollectionResponse->treasures = array(
			Array(0,30),
			Array(1,2),
			Array(2,3),
			Array(3,2),
			Array(4,1),
			Array(5,2),
			Array(0,60)
	);
	
	func_genSchema($CityCollectionResponse);
}

function func_genSchema($data)
{
	// get short name for class
	$reflect = new ReflectionClass($data);
	$name = $reflect->getShortName();
	$encodedJson = json_encode($data);
	
	$jsonSchema = new Json\JsonSchema($encodedJson);
	$fp = fopen("../Schema/$name.schema", 'w');
	fwrite($fp, $jsonSchema->getSchema($encodedJson));
	fclose($fp);
	
	$fp = fopen("../Sample/$name.json", 'w');
	fwrite($fp, $encodedJson);
	fclose($fp);
	
	echo "Scuessed to generate json schema for class: $name \r\n";
}
