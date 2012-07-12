<?php
require_once '../odmconfig.php';
include_once './framework/doctrinetestcase.php';
include_once '../amfphp/services/VersionService.php';
include_once '../lib/Constant/ErrorCode.php';

class VersionServiceTest extends DoctrineTestCase
{
	
	public function SetUp()
	{
		
	}
	
	public function Run()
	{
		$version = new VersionService();
		
		$platform = 'iPad';
		$currentVersion = '0.9';
		
		$result = $version->NeedUpdate($this->AddQuote($platform), $this->AddQuote($currentVersion));
		$this->AssertEquals($result->_returnCode, Constant\ErrorCode::VersionNeedUpdate, 'Need update');
		
		$platform = 'iPad';
		$currentVersion = '1.2';
		$result = $version->NeedUpdate($this->AddQuote($platform), $this->AddQuote($currentVersion));
		$this->AssertEquals($result->_returnCode, Constant\ErrorCode::OK, 'No Need update');
		
		$platform = 'abc';
		$result = $version->NeedUpdate($this->AddQuote($platform), $this->AddQuote($currentVersion));
		$this->AssertEquals($result->_returnCode, Constant\ErrorCode::VersionUnkownPlatform, 'Unkown platform');
		
	}

	public function TearDown()
	{
		
	}
}

$suite = new TestSuite;
$suite->AddTest('VersionServiceTest');
 
$runner = new ConsoleTestRunner();
$runner->Run($suite, false);
