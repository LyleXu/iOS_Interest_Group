<?php
use Utility\AMQPConnect;
require_once __DIR__ . '/../../odmconfig.php';

require_once 'xhtml_test_runner.php';
require_once 'text_test_runner.php';
require_once 'xml_test_runner.php';
require_once 'console_test_runner.php';

use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\IndexedReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
    
abstract class AMQPTestCase extends TestCase
{
	protected $cnn = null;
	
	public function __construct($name = null, $description = null, $id = null)
	{
		parent::__construct($name, $description, $id);
	}
		
	public function SetUp()
	{
		// try to drop
		$this->cnn = AMQPConnect::getInstance()->getConnection();
	}
	
	public function TearDown()
	{
		AMQPConnect::getInstance()->disconnect();
	}
}
?>
