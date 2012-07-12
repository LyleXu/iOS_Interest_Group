<?php

require_once '../odmconfig.php';
include_once './framework/doctrinetestcase.php';

class GameRoomTest extends DoctrineTestCase
{
	private $m = NULL;
	private $db;
	private $gameroom;
	private $users;
	
	public function SetUp()
	{
		$this->m = new \Mongo();
		$this->db = $this->m->bingo;
		
		$this->gameroom = $this->db->GameRoom;
		$this->users = $this->db->User;
		$this->gameroom->drop();
		$this->users->drop();
	}
	
	public function Run()
	{
		$username = 'winston';
		$gamename = 'gameroom';
		
		// gameroom persist
		$gameroom = new Models\GameRoom();
		$gameroom->id = 1;
		$gameroom->name = $gamename;
		
		$this->doctrinemodel->persist($gameroom);
		$this->doctrinemodel->flush();
		
		$groomFind = $this->doctrinemodel->getRepository('Models\GameRoom')->findOneBy(array('name' => $gamename));
		$this->AssertEquals($groomFind->name, $gamename, 'gameroom persist');
		
		// User persist
		$user = new Models\User();
		$user->name = $username;
		
		$this->doctrinemodel->persist($user);
		$this->doctrinemodel->flush();
		
		$userFind = $this->doctrinemodel->getRepository('Models\User')->findOneBy(array('name' => $username));
		$this->AssertEquals($userFind->name, $username, 'user persist');
		
		// Join Game
		$this->AssertEquals($groomFind->ConnectUser($userFind), TRUE, 'Call ConnectUser');
		$this->AssertEquals($groomFind->getConnectedUsers()->count(), 1);
		$this->AssertEquals($groomFind->getConnectedUsers()->contains($userFind), TRUE, 'Join Game');
		
		$this->AssertEquals($groomFind->DisconnectUser($userFind), TRUE, 'Call DisconnectUser');
		$this->AssertEquals($groomFind->getConnectedUsers()->count(), 0, 'Exit game user count');
		$this->AssertEquals($groomFind->getConnectedUsers()->contains($userFind), FALSE, 'Exit Game');
		
		$groomFind->ResetUsers();
		$this->AssertEquals($groomFind->getConnectedUsers()->count(), 0);
		$this->AssertEquals($groomFind->getConnectedUsers()->contains($userFind), FALSE, 'Reset Game Users');
	}

	public function TearDown()
	{
		$this->gameroom->drop();
		$this->users->drop();
	}
}

$suite = new TestSuite;
$suite->AddTest('GameRoomTest');
 
$runner = new TextTestRunner();
$runner->Run($suite, true);