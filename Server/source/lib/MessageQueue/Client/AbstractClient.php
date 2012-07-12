<?php 

namespace MessageQueue\Client;

class AbstractClient
{
    protected $_initialized = false;

    public function setQueueId($queueId)
    {
    }

    public function isInitialized()
    {
        return $this->_initialized;
    }
}