<?php

require_once '../odmconfig.php';
include_once './framework/doctrinetestcase.php';

class UserTest extends DoctrineTestCase
{
	private $m = NULL;
	private $db;
	private $users;
	
	public function SetUp()
	{
		$this->m = new \Mongo();
		$this->db = $this->m->bingo;
		$this->users = $this->db->User;
		
		$this->users->drop();
	}
	
	public function Run()
	{
		$user = new Models\User();
		$user->name = 'winston';
		
		$this->doctrinemodel->persist($user);
		$this->doctrinemodel->flush();
		
		$userfind = $this->doctrinemodel->createQueryBuilder('Models\User')
		    ->field('name')->equals('winston')
		    ->getQuery()
		    ->getSingleResult();
		
		$this->AssertEquals($userfind->name, 'winston', 'User name not equal');
	}

	public function TearDown()
	{
	 	$this->users->drop();
	}
}

$suite = new TestSuite;
$suite->AddTest('UserTest');
 
$runner = new TextTestRunner();
$runner->Run($suite);
