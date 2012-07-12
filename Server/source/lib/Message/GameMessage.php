<?php

namespace Message;

class GameMessage extends \MessageQueue\Message
{
	public $roundID;
	public $eventType;
	public $eventData;
    
    public function __construct()
    {
    	parent::__construct();
    }
    
    public function execute()
    {
    }
    
    function getPriority()
    {
    	return \Constant\MessagePriority::Middle;
    }
    
    function getEventType()
    {
    	return \Constant\EventType::GameEvevt;
    }
}