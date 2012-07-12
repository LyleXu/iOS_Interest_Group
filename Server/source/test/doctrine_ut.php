<?php

error_reporting(E_ALL | E_STRICT);

require_once '../odmconfig.php';
include_once './framework/doctrinetestcase.php';

class DoctrineCascadesPersist extends DoctrineTestCase
{
	public function Run()
	{
		$a = new \Models\A();
		$b = new \Models\B();
		$b->setValue(100);
		
		$a->setB($b);
		
		$this->doctrinemodel->persist($a);
		$this->doctrinemodel->flush();
	}
}

class DoctrineCascadesPersist_AfterFlush extends DoctrineTestCase
{
	public function Run()
	{
		$a = new \Models\A();
		$this->doctrinemodel->persist($a);
		$this->doctrinemodel->flush();
		$b = new \Models\B();
		$a->setB($b);
		
		$this->doctrinemodel->flush();
	}
}

class DoctrineCascadesRemove extends DoctrineTestCase
{
	public function Run()
	{
		$a = new \Models\A();
		$this->doctrinemodel->persist($a);
		
		$b = new \Models\B();
		$a->setB($b);
		
		$this->doctrinemodel->flush();
		$this->doctrinemodel->remove($a);
		
		$this->doctrinemodel->flush();
	}
}

class DoctrineTestArrayCollection extends DoctrineTestCase
{
	public function Run()
	{
		$a = new \Models\A();
		$this->doctrinemodel->persist($a);
		$this->doctrinemodel->flush();
		
		$this->AddMessage(gettype($a->getDoccol()));
		$this->AddMessage(gettype($a->getNatcol()));
		$this->AddMessage(gettype($a->getBs()));
		
		$a->addDoccol(1);
		$a->mergeDoccol(array(2,3));
		
		//array_push($a->getNatcol(), 1);
		
		$this->doctrinemodel->flush();
	}
}

class DoctrineTestIncrement extends DoctrineTestCase
{
	public function Run()
	{
		for ($i = 1; $i < 100; $i++)
		{
			$c = new \Models\C();
			$c->value = str_repeat($i, 10);
			$this->doctrinemodel->persist($c);
		}
		$this->doctrinemodel->flush();
	}
}

$suite = new TestSuite;
$suite->AddTest('DoctrineTestIncrement');
 
$runner = new TextTestRunner();
$runner->Run($suite, false);