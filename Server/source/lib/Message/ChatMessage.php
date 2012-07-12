<?php

namespace Message;

class ChatMessage extends \MessageQueue\Message
{
	public $playerName = '';
	public $playerId = '';
	public $playerAvatarTemplateId = '';
    public $message = '';
	
    public function __construct($playerName, $playerId, $avatarId, $message)
    {
    	parent::__construct();
    	
    	$this->playerName = $playerName;
    	$this->playerId = $playerId;
    	$this->playerAvatarTemplateId = $avatarId;
    	$this->message = $message;
    }
    
    public function execute()
    {
    }
    
    function getPriority()
    {
    	return \Constant\MessagePriority::Low;
    }
    
    function getEventType()
    {
    	return \Constant\EventType::ChatEvent;
    }
}