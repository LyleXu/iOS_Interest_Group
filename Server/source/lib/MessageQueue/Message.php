<?php

namespace MessageQueue;

abstract class Message
{
	public $time;
	
	public function __construct()
    {
    	$this->time = time();
    }
    
    function execute(){}
	function getPriority(){}
	function getEventType(){}
}
