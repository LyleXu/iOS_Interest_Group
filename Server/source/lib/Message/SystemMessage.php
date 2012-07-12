<?php

namespace Message;

class SystemMessage extends \MessageQueue\Message
{
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
    	return \Constant\MessagePriority::High;
    }
    
    function getEventType()
    {
    	return \Constant\EventType::SystemEvent;
    }
}