<?php

namespace MessageQueue;

use MessageQueue\Message,
	MessageQueue\Client,
	MessageQueue\Client\ClientInterface;

class Queue
{
    private $_client;
    private $_sleepSeconds = 0;
    private $_pingEnabled;
    
	protected $exitCode = \Constant\QueueExistCode::Unknown;
	private $shouldStop = FALSE;
	private $pingFrequence = 0;
	
	protected $logger;
	
    public function __construct(ClientInterface $client, $sleepSeconds = 1, $pingEnabled = TRUE, $pingFrequence = 5)
    {
    	$this->_client = $client;
    	
    	$this->_pingEnabled = $pingEnabled;
    	$this->_sleepSeconds = $sleepSeconds;
    	$this->pingFrequence = $pingFrequence;
    }

    public function Initialize()
    {
    	$this->_client->initialize(TRUE);
    }
    
    public function Uninitialize()
    { 
    	$this->_client->uninitialize();
    }
    
    public function Ping()
    {	
    } 
    
    public function CanContinue()
    {
    	return TRUE;
    }
        
    
    public function runConsumer()
    {
    	$this->Initialize();
    	
        while (TRUE) {
        	$messages = $this->consumeMessages();
        	if ($messages != NULL)
        	{
        		foreach ($messages as $msg)
        		{
					echo $msg['message_body'];
		            flush(); 
		            
		            $this->logger->LogDebug($msg['message_body']);
        		}
        	}
        }
        
        $this->Uninitialize();
    }
    
    public function run()
    {
    	$this->Initialize();
    	$index = 0;
    	
        while (TRUE) {
        	if ($index % $this->pingFrequence == 0 && $this->_pingEnabled)
        		$this->Ping();
        		
        	try {
        		$this->execute();
        	}
            catch (Exception $e)
            {
            	//
            }
            
            // Stop sig
            if ($this->shouldStop == TRUE)
            	break;
            
            // Check queue model
            if ($this->CanContinue() == FALSE)
            {
            	break;
            }
            // Sleep, release CPU
            sleep($this->_sleepSeconds);
            
            // Auto increase
            $index++;
            if ($index == PHP_INT_MAX)
            	$index = 0;
        }
        
        $this->Uninitialize();
    }

    public function getMessages()
    {
        return $this->_client->getMessages();
    }
    
    public function consumeMessages()
    {
    	return $this->_client->consumeMessage();
    }

    public function deleteMessages(array $ids)
    {
        return $this->_client->deleteMessages($ids);
    }

    public function execute()
    {
    	$messages = $this->getMessages();
    	
        if (count($messages) > 0) {
            foreach ($messages as $message) {
            	
            	try {
	            	if (isset($message->sender) && $message->sender != $this->_sender)
	            	{
	            	}
	            	else
	            	{	
		            	
		            	$event = new BingoEvent();
		            	$event->eventType = $message->getEventType();
		            	$event->eventData = json_encode($message);
		            	
		            	echo json_encode($event);
		            	flush();
	            	}
            	}
            	catch (Exception $e)
            	{
            		// TODO
            	}
            }
            $this->deleteMessages(array_keys($messages));
        }
    }
    
    public function getExitCode()
    {
    	return $this->exitCode;
    }
    
    public function setExitCode($error)
    {
    	$this->exitCode = $error;
    }
}