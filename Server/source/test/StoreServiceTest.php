<?php

include_once './framework/doctrinetestcase.php';

class StoreServiceTest extends DoctrineTestCase
{
	public function Run()
	{

		include_once '../InitData.ini.php';
		$typeAndRate = array();
		foreach ($PowerupTypes as $value) {
			$typeAndRate[$value[0]] = $value[3];
		} 
		
		$amount = 1;
		$typeCollection = Utility\CommonUtility::GetRandomPowerUpsType($typeAndRate, $amount);
		$this->AssertEquals(count($typeCollection), $amount, "get random $amount powerup failed");
		
		$amount = 5;
		$typeCollection = Utility\CommonUtility::GetRandomPowerUpsType($typeAndRate, $amount);
		$this->AssertEquals(count($typeCollection), $amount, "get random $amount powerup failed");
		
		$amount = 11;
		$typeCollection = Utility\CommonUtility::GetRandomPowerUpsType($typeAndRate, $amount);
		$this->AssertEquals(count($typeCollection), $amount, "get random $amount powerup failed");
	}
}


$suite = new TestSuite;
$suite->AddTest('StoreServiceTest');
 
$runner = new ConsoleTestRunner();
$runner->Run($suite, false);