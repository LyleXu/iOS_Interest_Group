<?php
namespace Utility;

use Message\GameMessage;
use MessageQueue\BingoEvent;

require_once 'bingo/odmconfig.php';

use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\IndexedReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
    
class AMQPChannel
{
	private $channel;
	private $cnn;
	
	public function __construct($channelName, $declare = TRUE)
	{
		$connect = AMQPConnect::getInstance();
		$this->cnn =  $connect->getConnection();
		$this->channel = new \AMQPExchange($this->cnn, $channelName);
		
		if ($declare)
			$this->channel->declare($channelName, AMQP_EX_TYPE_TOPIC);
	}

	private function buildRouteKeyForPrivate($userid)
	{
		return \Constant\AMQPCommand::BingoPrivatePrefix . $userid;
	}
	
	private function buildRouteKeyForPrivateWithAction($userid, $action)
	{
		$noactionKey = $this->buildRouteKeyForPrivate($userid);
		return $noactionKey . '.' . $action;
	}
	
	public function setupUserQueue($userid)
	{
		$q = new \AMQPQueue($this->cnn);
		$q->declare($userid);
		
		$key =$this->buildRouteKeyForPrivate($userid);
		$this->channel->bind($userid, \Constant\AMQPCommand::BingoBroadcast);
		$this->channel->bind($userid, \Constant\AMQPCommand::BingoPrivatePrefix . $userid . '.#');
		
		return $q;
	}
	
	public function removeUserQueue($userid)
	{
		$q = new \AMQPQueue($this->cnn);
		$q->delete($userid);
	}
	
	public function broadCastStringMessageWithTopic($msg, $topic)
	{
		$this->channel->publish($msg, $topic);
	}
	
	public function broadCastStringMessage($msg)
	{
		return $this->broadCastStringMessageWithTopic($msg, \Constant\AMQPCommand::BingoBroadcast);
	}
	
	public function broadCastEvent(BingoEvent $event)
	{
		$this->broadCastStringMessage(json_encode($event));
	}
	
	public function broadCastGameMessage(\MessageQueue\Message $message)
	{
		$event = EventFactory::buildBingoEvent($message);
		return $this->broadCastEvent($event);
	}
	
	public function sendStringMessageWithTopic($msg, $topic)
	{
		$this->channel->publish($msg, $topic);
	}
	
	public function sendStringMessage($userid, $msg, $action)
	{
		return $this->sendStringMessageWithTopic($msg, $this->buildRouteKeyForPrivate($userid, $action));
	}
	
	public function sendEvent($userid, BingoEvent $event, $action)
	{
		$this->sendStringMessage($userid, json_encode($event), $action);
	}
	
	public function sendGameMessage($userid, \MessageQueue\Message $message, $action)
	{
		// build a bingo event..
		$event = EventFactory::buildBingoEvent($message);
		return $this->sendEvent($userid, $event, $action);
	}
}
?>