<?php

require_once '../odmconfig.php';
include_once './framework/php_unit_test.php';
require_once './framework/xhtml_test_runner.php';
require_once './framework/text_test_runner.php';
require_once './framework/xml_test_runner.php';
require_once './framework/console_test_runner.php';

class GearmanTest extends TestCase
{
	public function SetUp(){
		
	}
	public function TearDown(){
		
	}
	
	public function Run()
	{
		/* create our object */
		$gmclient= new \GearmanClient();
		
		/* add the default server */
		$gmclient->addServer();
		
		/* run reverse client */
		$job_handle = $gmclient->doBackground("reverse", "this is a test");
	}
}


$suite = new TestSuite;
$suite->AddTest('GearmanTest');
 
$runner = new ConsoleTestRunner();
$runner->Run($suite, false);

?>