<?php

require_once '../odmconfig.php';
include_once './framework/php_unit_test.php';
require_once './framework/xhtml_test_runner.php';
require_once './framework/text_test_runner.php';
require_once './framework/xml_test_runner.php';
require_once './framework/console_test_runner.php';

class MemcacheTest extends TestCase
{
	public function SetUp(){
		
	}
	public function TearDown(){
		
	}
	
	public function Run()
	{
		$memcache = new \Memcache;
		$this->AssertEquals($memcache->connect('localhost', 11211), TRUE, 'connect');
		
		$memcache->set('testkey', 'testvalue', MEMCACHE_COMPRESSED);
		
		$this->AssertEquals($memcache->get('testkey'), 'testvalue');
	}
}


$suite = new TestSuite;
$suite->AddTest('MemcacheTest');
 
$runner = new ConsoleTestRunner();
$runner->Run($suite, false);

?>