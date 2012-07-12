<?php

namespace MessageQueue\Client;

use Utility\AMQPChannel;
use Utility\AMQPConnect;

require_once 'bingo/odmconfig.php';

use MessageQueue\Queue;
use MessageQueue\Message;

class AMQPQueueClient extends AbstractClient implements ClientInterface
{
	private $cnn;
	private $queue;
	private $consumeOption;
	private $gameid;
	private $userid;
	
    public function __construct($gameid, $userid)
    {
    	$this->gameid = $gameid;
    	$this->userid = $userid;
    }

    public function initialize($drop = FALSE)
    {
		// TODO:
		$this->cnn = AMQPConnect::getInstance()->getConnection();
		
		// binding queue
		$this->queue = new \AMQPQueue($this->cnn);
		$this->queue->declare($this->userid);
		$this->queue->purge($this->userid);
		
		try {
			// gameroom
			//$this->queue->bind($this->gameid, 'bingo.#');
			$this->queue->bind($this->gameid,  \Constant\AMQPCommand::BingoBroadcast);
			$this->queue->bind($this->gameid,  \Constant\AMQPCommand::BingoPrivatePrefix . $this->userid . '.#');
			
			// amf
			/*
			$this->queue->bind(\Constant\AMQPChannelConstant::AMF, \Constant\AMQPCommand::BingoBroadcast);
			$this->queue->bind(\Constant\AMQPChannelConstant::AMF, $this->gameid);
			$this->queue->bind(\Constant\AMQPChannelConstant::AMF, $this->gameid . '.' . $this->userid);
			*/
		}
		catch (Exception $e)
		{
			// TODO
			throw  $e;
		}

		$this->consumeOption = array(
		    'min' => 1,
		    'max' => 20
		);
		
        $this->_initialized = true;
    }

    function uninitialize()
    {
    	$this->cnn->disconnect();
    }

    function consumeMessage()
    {
    	return $this->queue->consume($this->consumeOption);
    }
    
    public function getMessages()
    {
	    //get the messages
		$message = $this->queue->get();
		return $message;
    }

    public function deleteMessages(array $ids)
    {
    }
}