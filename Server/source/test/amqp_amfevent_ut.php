<?php

require_once '../odmconfig.php';
include_once './framework/amqptestcase.php';

class AMQPEventTest extends AMQPTestCase
{
	public function Run()
	{
		// Create a new queue
		$q1 = new AMQPQueue($this->cnn);
		$q1->declare('queue1');
		$q1->purge('queue1');
		
		$options = array(
		    'min' => 0,
		    'max' => 10,
		    'ack' => true
		);

		// Bind it on the exchange to routing.key
		$q1->bind(\Constant\AMQPChannelConstant::AMF, \Constant\AMQPCommand::BingoBroadcast);
		
		// Read from the queue
		while (TRUE)
		{
			$msg = $q1->consume($options);

			var_dump($msg);
		}
	}
}


$suite = new TestSuite;
$suite->AddTest('AMQPEventTest');
 
$runner = new TextTestRunner();
$runner->Run($suite, false);

?>