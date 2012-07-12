<?php

require_once '../odmconfig.php';
include_once './framework/doctrinetestcase.php';

class DoctrineUpdateTest extends DoctrineTestCase
{
	public function SetUp()
	{
		//
	}
	
	public function TearDown()
	{
		//
	}
	
	public function Run()
	{
		$aFound = $this->doctrinemodel->createQueryBuilder('Models\A')
		    ->getQuery()
		    ->getSingleResult();
		$this->AssertNotEquals($aFound, NULL);
		$aFound->intAValue = $aFound->intAValue + 100;
		$aFound->stringAValue = $aFound->stringAValue . '__aa__';
		
		$this->doctrinemodel->flush();
	}
}
$suite = new TestSuite;
$suite->AddTest('DoctrineUpdateTest');
 
$runner = new ConsoleTestRunner();
$runner->Run($suite, false);