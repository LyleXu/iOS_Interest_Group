<?php
namespace Utility;

use MessageQueue\BingoEvent;
use MessageQueue\Message;

class EventFactory
{
	public static function buildBingoEvent(Message $message)
	{
		// build a bingo event..
		$event = new BingoEvent();
        $event->eventType = $message->getEventType();
		$event->eventData = json_encode($message);
		
		return $event;
	}
}