<?php

namespace MessageQueue\Client;

use MessageQueue\Message;

interface ClientInterface
{
    function initialize($drop = FALSE);
    function uninitialize();
    function getMessages();
    function consumeMessage();
}