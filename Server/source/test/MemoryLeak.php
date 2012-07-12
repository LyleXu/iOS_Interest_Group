<?php

use Models\GameCard;
require_once '../odmconfig.php';
include_once './framework/doctrinetestcase.php';

class MemoryLeakBaseTestCase extends DoctrineTestCase
{
	function convert($size)
	{
    	$unit=array('b','kb','mb','gb','tb','pb');
    	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
 	}
 
	protected  function PrintMemoryOverview()
	{
		$used = $this->convert(memory_get_usage(TRUE));
		echo 'Memory used: ' . $used . PHP_EOL;
		flush();
	}
	
	protected   function GCCollectCycle()
	{
		$cyclecount = gc_collect_cycles();
		echo 'GC collect: ' . $cyclecount . PHP_EOL;
		flush();
	}

	public function Run()
	{
		
	}
}

class NormalMemoryLeakTest extends MemoryLeakBaseTestCase
{
	public function Run()
	{
		$this->PrintMemoryOverview();
		$a = str_repeat("Hello", 4242);
		$this->PrintMemoryOverview();
		unset($a);
		$this->GCCollectCycle();	
		$this->PrintMemoryOverview();
	}
}

class DoctrineMemoryLeakTest extends MemoryLeakBaseTestCase
{
	public function Run()
	{
		ob_implicit_flush(TRUE);
		
		
		for ($i = 0; $i < 10; $i++)
		{
			$this->PrintMemoryOverview();
		
			$users = $this->doctrinemodel->getRepository ( 'Models\User' )->findAll();
			
			foreach ($users as $user) {
				echo 'Found User: ' . $user->name . PHP_EOL;
	    		//$this->doctrinemodel->detach($user);
	    		//unset($user);
			}
			
			//unset($users);
			//$this->doctrinemodel->clear();
			//$this->doctrinemodel->close();
			$this->GCCollectCycle();	
			$this->PrintMemoryOverview();
			
			//sleep(1);
		}
	}
}

$suite = new TestSuite;
//$suite->AddTest('NormalMemoryLeakTest');
$suite->AddTest('DoctrineMemoryLeakTest');

$runner = new ConsoleTestRunner();
$runner->Run($suite, false);