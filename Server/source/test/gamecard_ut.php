<?php

use Models\GameCard;
require_once '../odmconfig.php';
include_once './framework/doctrinetestcase.php';

class GameCardStaticTest extends DoctrineTestCase
{
	public function Run()
	{
		// arrayInArray test
		{
			$callNumber = range(1, 75);
			$bingo1 = range(1, 5);
			$bingo2 = range(5, 10);
			$bingo3 = array(0 => 1, 5, 2, 74, 15);
			$bingo4 = array(0 => 30, 10, 5, 20, 16);
			$bingo5 = array(0 => 1, 5, 2, 74, 15);
			
			$this->AssertEquals(GameCard::arrayInArray($callNumber, $bingo1), true, "Check Bingo1");
			$this->AssertEquals(GameCard::arrayInArray($callNumber, $bingo2), true, "Check Bingo2");
			$this->AssertEquals(GameCard::arrayInArray($callNumber, $bingo3), true, "Check Bingo3");
			$this->AssertEquals(GameCard::arrayInArray($callNumber, $bingo4), true, "Check Bingo4");
			$this->AssertEquals(GameCard::arrayInArray($callNumber, $bingo5), true, "Check Bingo5");
			
			$callNumber2 = range(1, 20);
			$bingo6 = array(0 => 1, 5, 2, 74, 15);
			$this->AssertEquals(GameCard::arrayInArray($callNumber2, $bingo6), false, "Check CallNumber out of range.");
		}
		
		// hitBingo test
		{
			$callNumber = range(1, 75);
			$daubs1 = range(1, 5);
			$daubs2 = array(0 => 1, 16, 31, 46, 61);
			$daubs3 = array(0 => 1, 17, 49, 65);
			$daubs4 = array(0 => 5, 19, 47, 61);
			$daubsFailed1 = array(0 => 17, 19, 2, 3);
			$cardBoard1 = array();
		    for ($i = 0; $i < 5; $i++)
		    {
	    		$cardBoard1[$i] = range( $i * 15 + 1, $i * 15 + 6);
		    }
		    $cardBoard1[2][2] = \Constant\SpecialCard::FreeNumber;
		    
		    // Check bingo
		    $this->AssertEquals(GameCard::hitBingo($cardBoard1, $callNumber, $daubs1, 5), true, 'hitbingo daub1 failed');
		    $this->AssertEquals(GameCard::hitBingo($cardBoard1, $callNumber, $daubs2, 5), true, 'hitbingo daub2 failed');
		    $this->AssertEquals(GameCard::hitBingo($cardBoard1, $callNumber, $daubs3, 5), true, 'hitbingo daub3 failed');
		    $this->AssertEquals(GameCard::hitBingo($cardBoard1, $callNumber, $daubs4, 5), true, 'hitbingo daub4 failed');
		    $this->AssertEquals(GameCard::hitBingo($cardBoard1, $callNumber, $daubsFailed1, 5), false, 'hitbingo daub4 failed');
		    
		    // check instant win
		    
		    
		    // check single daub/ double daub
		    
		}
	}
}

class GameCardGeneraterTest extends DoctrineTestCase
{
	public function Run()
	{
		$user = new \Models\User('winston', 'winston');
		$newGameRoom = new \Models\GameRoom('test', 1, 'des');
		$newGameRound = new \Models\GameRound($newGameRoom);
		
		$this->doctrinemodel->persist($newGameRoom);
		$this->doctrinemodel->persist($newGameRound);
		$this->doctrinemodel->persist($user);		
		$newGameRound->Initialize();		
		$this->doctrinemodel->flush();
		
		$newGameRound->status = \Constant\RoundStatus::Ready;
		
		$buyCardResult = $newGameRound->buyCard($user, 3);
		
		$this->doctrinemodel->flush();
		
		
		$gamecards = $this->doctrinemodel->createQueryBuilder('Models\GameCard')
		    ->getQuery()
		    ->execute();
		
		$gamecardsArray = array_values($gamecards->toArray());		
		
		$this->AssertEquals(count($gamecardsArray), 3, 'Game card number is incorrect');
		
		$newCard = $gamecardsArray[0];
		$newUserCard = $newCard->getUserCard();
		
		$this->AssertEquals(count($newUserCard), 5, 'User card size is not correct');
		$this->AssertEquals(count($newUserCard[0]), 5, 'User card size is not correct');
		$this->AssertEquals($newUserCard[2][2], \Constant\SpecialCard::FreeNumber, 'Free number is incorrect');
				
		$gamecardFromRound1 = $newGameRound->getCardForUser($user, 0);
		$newUserCard = $gamecardFromRound1->getUserCard();
		$this->AssertEquals($newUserCard != NULL, TRUE, 'getCardForUser return null 1');
		$this->AssertEquals(count($newUserCard), 5, 'User card size is not correct 1');
						
		// daub.
		$this->doctrinemodel->refresh($gamecardFromRound1->gameRound);
		$newGameRound->currentCallNumberIndex = 75;
		
		$this->AssertEquals($gamecardFromRound1->daubAll($newUserCard[0]), \Constant\ErrorCode::OK, 'Daub all failed');
		$this->doctrinemodel->flush();
		$this->AssertEquals($gamecardFromRound1->evaluateResult(range(1, 75)), \Constant\GameResult::Win, 'evaluateResult not win');
				
		$gamecardFromRound2 = $newGameRound->getCardForUser($user, 1);
		$newUserCard = $gamecardFromRound2->getUserCard();
		$this->AssertEquals($newUserCard != NULL, TRUE, 'getCardForUser return null 2');
		$this->AssertEquals(count($newUserCard), 5, 'User card size is not correct 2');
		
		// daub.
		$failedDaub = $newUserCard[0];
		for ($i = 1; $i < 16; $i++)
		{
			if (in_array($i, $failedDaub) == FALSE)
			{
				$failedDaub[0] = $i;
				break;
			}
		}
		$this->AssertEquals($gamecardFromRound2->daubAll($failedDaub), \Constant\ErrorCode::OK, 'Daub all failed');
		$this->doctrinemodel->flush();
		$this->AssertEquals($gamecardFromRound2->evaluateResult(range(1, 75)), \Constant\GameResult::Failed, 'evaluateResult not win');		
		
		$gamecardFromRound3 = $newGameRound->getCardForUser($user, 4);
		$this->AssertEquals($gamecardFromRound3 == NULL, TRUE, 'getCardForUser return unexpected instance');
	}
}

class GameCardInstantWinTest extends DoctrineTestCase
{
	public function Run()
	{
		$user = new \Models\User('winston', 'winston');
		$newGameRoom = new \Models\GameRoom('test', 1, 'des');
		$newGameRound = new \Models\GameRound($newGameRoom);
		
		$this->doctrinemodel->persist($newGameRoom);
		$this->doctrinemodel->persist($newGameRound);
		$this->doctrinemodel->persist($user);		
		$newGameRound->Initialize();		
		$this->doctrinemodel->flush();
		
		$newGameRound->status = \Constant\RoundStatus::Ready;
		
		$buyCardResult = $newGameRound->buyCard($user, 1);
		
		$this->doctrinemodel->flush();
		
		
		$gamecards = $this->doctrinemodel->createQueryBuilder('Models\GameCard')
		    ->getQuery()
		    ->execute();
		
		$gamecardsArray = array_values($gamecards->toArray());		
		
		$this->AssertEquals(count($gamecardsArray), 1, 'Game card number is incorrect');
				
		$gamecard = $newGameRound->getCardForUser($user, 0);
		$newUserCard = $gamecard->getUserCard();
		$newGameRound->currentCallNumberIndex = 75;
		
		$userDaubNumbers = $newUserCard[0];
		
		array_pop($userDaubNumbers); // remove the last number 
		$instantWinNumber = $newUserCard[1][0];
		array_push($userDaubNumbers, $instantWinNumber);
		
		$this->AssertEquals($gamecard->daubAll($userDaubNumbers), \Constant\ErrorCode::OK, 'Daub all failed');
		$this->doctrinemodel->flush();
		$this->AssertEquals($gamecard->evaluateResult(range(1, 75)), \Constant\GameResult::Failed, 'evaluateResult not win');
				
		// add the instant win number
		array_push($gamecard->instantWinNumberList, $instantWinNumber);
		$this->AssertEquals($gamecard->evaluateResult(range(1, 75)), \Constant\GameResult::Win, 'evaluateResult not win');

	}
}

class GameCardSinagleDauborDoubleDaubTest extends DoctrineTestCase
{
	public function Run()
	{
		$user = new \Models\User('winston', 'winston');
		$newGameRoom = new \Models\GameRoom('test', 1, 'des');
		$newGameRound = new \Models\GameRound($newGameRoom);
		
		$this->doctrinemodel->persist($newGameRoom);
		$this->doctrinemodel->persist($newGameRound);
		$this->doctrinemodel->persist($user);		
		$newGameRound->Initialize();		
		$this->doctrinemodel->flush();
		
		$newGameRound->status = \Constant\RoundStatus::Ready;
		
		$buyCardResult = $newGameRound->buyCard($user, 2);
		
		$this->doctrinemodel->flush();
		
		
		$gamecards = $this->doctrinemodel->createQueryBuilder('Models\GameCard')
		    ->getQuery()
		    ->execute();
		
		$gamecardsArray = array_values($gamecards->toArray());		
		
		$this->AssertEquals(count($gamecardsArray), 2, 'Game card number is incorrect');

		// check the first gameboard for single daub 
		$gamecard = $newGameRound->getCardForUser($user, 0);
		$newUserCard = $gamecard->getUserCard();
		$newGameRound->currentCallNumberIndex = 75;
		
		$userDaubNumbers = $newUserCard[0];
		
		$singleDaubNumber = $userDaubNumbers[count($userDaubNumbers)-1];
		
		array_pop($userDaubNumbers); // remove the last number 
		
		$this->AssertEquals($gamecard->daubAll($userDaubNumbers), \Constant\ErrorCode::OK, 'Daub all failed');
		$this->doctrinemodel->flush();
		$this->AssertEquals($gamecard->evaluateResult(range(1, 75)), \Constant\GameResult::Failed, 'evaluateResult not win');
				
		// add the instant win number
		array_push($gamecard->autoDaubNumberList, $singleDaubNumber);
		$this->AssertEquals($gamecard->evaluateResult(range(1, 75)), \Constant\GameResult::Win, 'evaluateResult not win');

		// check the second gameboard for double daub
		$secondGameCard = $newGameRound->getCardForUser($user, 1);
		$newUserCard = $secondGameCard->getUserCard();
		$newGameRound->currentCallNumberIndex = 75;
		
		$userDaubNumbers = $newUserCard[0];
		$firstDaubNumber = $userDaubNumbers[count($userDaubNumbers)-1];
		$secondDaubNumber = $userDaubNumbers[count($userDaubNumbers)-2];
		
		array_pop($userDaubNumbers); // remove the last number 
		array_pop($userDaubNumbers);
		
		$this->AssertEquals($secondGameCard->daubAll($userDaubNumbers), \Constant\ErrorCode::OK, 'Daub all failed');
		$this->doctrinemodel->flush();
		$this->AssertEquals($secondGameCard->evaluateResult(range(1, 75)), \Constant\GameResult::Failed, 'evaluateResult not win');
		
		array_push($secondGameCard->autoDaubNumberList, $firstDaubNumber);
		array_push($secondGameCard->secondDaubNumberList, $secondDaubNumber);
		$this->AssertEquals($secondGameCard->evaluateResult(range(1, 75)), \Constant\GameResult::Win, 'evaluateResult not win');
	}
}

$suite = new TestSuite;
$suite->AddTest('GameCardStaticTest');
$suite->AddTest('GameCardGeneraterTest');
$suite->AddTest('GameCardInstantWinTest');
$suite->AddTest('GameCardSinagleDauborDoubleDaubTest');
 
$runner = new ConsoleTestRunner();
$runner->Run($suite, false);