<?php

require_once '../odmconfig.php';
include_once './framework/doctrinetestcase.php';

class GameRoundTest extends DoctrineTestCase
{
	private $m = NULL;
	private $db;
	private $gameroom;
	private $gameround;
	private $users;
	
	public function SetUp()
	{
		$this->m = new \Mongo();
		$this->db = $this->m->bingo;
		
		$this->gameroom = $this->db->GameRoom;
		$this->users = $this->db->User;
		$this->gameround = $this->db->GameRound;
		
		$this->gameroom->drop();
		$this->users->drop();
		$this->gameround->drop();
	}
	
	public function Run()
	{
		$username = 'winston';
		$username2 = 'lyle';
		$gamename = 'gameroom';
		
		// gameroom persist
		$gameRoom = new Models\GameRoom();
		$gameRoom->id = 1;
		$gameRoom->name = $gamename;
		
		$user = new Models\User();
		$user->name = $username;
		$user2 = new Models\User();
		$user2->name = $username2;
		
		$this->doctrinemodel->persist($gameRoom);
		$this->doctrinemodel->persist($user);
		$this->doctrinemodel->persist($user2);
		$this->doctrinemodel->flush();
		
		// Join game
		$this->AssertEquals($gameRoom->ConnectUser($user), TRUE, 'Call ConnectUser for user');
		
		// Init GameRound
		$gameRound = new Models\GameRound($gameRoom, 10, 25);
		$this->doctrinemodel->persist($gameRound);
		$this->doctrinemodel->flush();
		$gameRound->Initialize();
		
		$userboards = $gameRound->getUserBoards();
		$callnumbers = $gameRound->getCallNumber();
		$this->AssertEquals(count($callnumbers), 10, 'call number equal 10');
		$this->AssertEquals(count($userboards), 1, 'user boards equal 1');
		$this->AssertEquals(count($userboards[$user->id]), 25, 'userboard size equal 25');
		
		$gameRound2 = new Models\GameRound($gameRoom, 11, 25);
		$this->doctrinemodel->persist($gameRound2);
		$this->doctrinemodel->flush();
		$gameRound2->Initialize();
		
		// Join game for user2
		$this->AssertEquals($gameRoom->ConnectUser($user2), TRUE, 'Call ConnectUser for user2');
				
		$userboards = $gameRound2->getUserBoards();
		$callnumbers = $gameRound2->getCallNumber();
		$this->AssertEquals(count($callnumbers), 11, 'call number equal 11');
		$this->AssertEquals(count($userboards), 1, 'user boards equal 1');
		$this->AssertEquals(count($userboards[$user->id]), 25, 'user2 userboard size equal 25');
		$this->AssertEquals(count($userboards[$user2->id]), 25, 'user2 userboard size equal 25');
	}

	public function TearDown()
	{
		$this->gameroom->drop();
		$this->users->drop();
		$this->gameround->drop();
	}
}

$suite = new TestSuite;
$suite->AddTest('GameRoundTest');
 
$runner = new TextTestRunner();
$runner->Run($suite, true);