<?php
namespace Utility;

require_once 'bingo/odmconfig.php';
require_once 'bingo/dbconfig.php';

use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\IndexedReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
    
class AMQPConnect extends Singleton
{
	private $cnn;

	public function __construct()
	{
		$this->cnn = new \AMQPConnection(array(
		    'host' => AMQP_HOST,
		    'vhost' => AMQP_NAME,
		    'port' => AMQP_PORT,
		    'login' => AMQP_USER,
		    'password' => AMQP_PASSWORD
		));
		
		$this->cnn->connect();
	}
	
	public function getConnection()
	{
		return $this->cnn;
	}
	
	public function isConnected()
	{
		return $this->cnn->isConnected();
	}
	
	public function connect()
	{
		return $this->cnn->connect();
	}
	
	public function disconnect()
	{
		$this->cnn->disconnect();
	}
}
?>