<?php

namespace Json\Data;

class GearmanWorkload
{
	public $gameRoomId;
	public $messageBody;
	public $targetUserId;
	
	public function __construct($roomid, $body, $targetUserId = NULL)
	{
		$this->gameRoomId = $roomid;
		$this->messageBody = $body;
		
		$this->targetUserId = $targetUserId;
	}
}