<?php

require_once '../odmconfig.php';
include_once './framework/amqptestcase.php';

class AMQPDirectExOneQueueTest extends AMQPTestCase
{
	public function Run()
	{
		// Declare a new exchange
		$ex = new AMQPExchange($this->cnn);
		$ex->declare('game', AMQP_EX_TYPE_FANOUT);
		
		// Create a new queue
		$q1 = new AMQPQueue($this->cnn);
		$q1->declare('queue1');
		
		$q2 = new AMQPQueue($this->cnn);
		$q2->declare('queue2');
		
		// Bind it on the exchange to routing.key
		//$ex->bind('queue1', 'broadcast=true,target=queue1,x-match=any');
		$ex->bind('queue1', '');
		$ex->bind('queue2', '');
		
		$msgBody = 'hello';
		// Publish a message to the exchange with a routing key
		$ex->publish($msgBody, 'foo');
		
		// Read from the queue
		$msg = $q1->consume();
		
		$this->AssertEquals(count($msg), 1);
		$this->AssertEquals($msg[0]['message_body'], $msgBody, 'message not equal');
		
		// Read from the queue
		$msg = $q2->consume();
		
		$this->AssertEquals(count($msg), 1);
		$this->AssertEquals($msg[0]['message_body'], $msgBody, 'message not equal');
		
		$this->AddMessage(var_export($msg[0], true));
	}
}


$suite = new TestSuite;
$suite->AddTest('AMQPDirectExOneQueueTest');
 
$runner = new ConsoleTestRunner();
$runner->Run($suite, false);

?>