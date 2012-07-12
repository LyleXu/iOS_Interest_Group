<?php

require_once '../odmconfig.php';
include_once './framework/amqptestcase.php';

class AMQPTopicTest extends AMQPTestCase
{
	public function Run()
	{
		// Declare a new exchange
		$ex = new AMQPExchange($this->cnn);
		$ex->declare('game', AMQP_EX_TYPE_TOPIC);
		
		// Create a new queue
		$q1 = new AMQPQueue($this->cnn);
		$q1->declare('queue1');
		$q1->purge('queue1');
		
		$q2 = new AMQPQueue($this->cnn);
		$q2->declare('queue2');
		$q1->purge('queue2');
		
		$q3 = new AMQPQueue($this->cnn);
		$q3->declare('queue3');
		$q3->purge('queue3');
		
		$options = array(
		    'min' => 0,
		    'max' => 10,
		    'ack' => true
		);

		// Bind it on the exchange to routing.key
		$ex->bind('queue1', 'game1.#');
		$ex->bind('queue2', 'game1.#');
		$ex->bind('queue3', 'game1.#');
		$ex->bind('queue3', 'queue3.#');
		
		$msgbody1 = 'hello';
		// Publish a message to the exchange with a routing key
		$result = $ex->publish($msgbody1, 'game1.msg');
		
		$this->AssertEquals($result, TRUE, 'publish message failed');
		
		$msgbody2 = 'world';
		// Publish a message to the exchange with a routing key
		$result = $ex->publish($msgbody2, 'game1.msg');
		
		$this->AssertEquals($result, TRUE, 'publish message failed');
		
		$msgbody3 = 'hello player3';
		// Publish a message to the exchange with a routing key
		$result = $ex->publish($msgbody3, 'queue3.command');
		
		$this->AssertEquals($result, TRUE, 'publish message failed');
		
		// Read from the queue
		$msg = $q1->consume($options);
		$this->AddMessage(var_export($msg, true));
		$this->AssertEquals(count($msg), 2);
		$this->AssertEquals($msg[0]['message_body'], $msgbody1, 'message not equal');
		$this->AssertEquals($msg[1]['message_body'], $msgbody2, 'message not equal');
		
		// Read from the queue
		$msg = $q2->consume($options);
		$this->AssertEquals(count($msg), 2);
		$this->AssertEquals($msg[0]['message_body'], $msgbody1, 'message not equal');
		$this->AssertEquals($msg[1]['message_body'], $msgbody2, 'message not equal');
		
		// Read from the queue
		$msg = $q3->consume($options);
		$this->AddMessage(var_export($msg, true));
		$this->AssertEquals(count($msg), 3);
		$this->AssertEquals($msg[0]['message_body'], $msgbody1, 'message not equal');
		$this->AssertEquals($msg[1]['message_body'], $msgbody2, 'message not equal');
		$this->AssertEquals($msg[2]['message_body'], $msgbody3, 'message not equal');
		
		$msg = $q3->consume($options);
		$this->AssertEquals(count($msg), 0);
	}
}


$suite = new TestSuite;
$suite->AddTest('AMQPTopicTest');
 
$runner = new ConsoleTestRunner();
$runner->Run($suite, false);

?>