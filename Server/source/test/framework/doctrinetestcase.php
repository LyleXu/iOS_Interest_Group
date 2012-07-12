<?php
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
    
abstract class DoctrineTestCase extends TestCase
{
	protected $doctrinemodel = null;
	private $m;
	private $db;
	private $dbuser = 'admin';
	private $dbpassword = 'admin';
	
	public function __construct($name = null, $description = null, $id = null)
	{
		parent::__construct($name, $description, $id);
		$this->m = new Mongo("mongodb://" . $this->dbuser . ":" . $this->dbpassword . "@localhost");
		$this->db = $this->m->selectDB('bingo');
		
		$this->doctrinemodel = \Utility\DoctrineConnect::GetInstance(__DIR__.'/../../cache')->Doctrinemodel;
	}
		
	public function SetUp()
	{
		// try to drop
		$this->db->authenticate($this->dbuser, $this->dbpassword);
		$response = $this->db->drop();
		$this->AssertEquals(intval($response['ok']), 1, 'drop db');
		
		// insert the user - note that the password gets hashed as 'username:mongo:password'
		// set readOnly to true if user should not have insert/delete privs
		$collection = $this->db->selectCollection("system.users");
		$collection->insert(array('user' => $this->dbuser, 'pwd' => md5($this->dbuser . ":mongo:" . $this->dbpassword), 'readOnly' => false));
		$this->db->authenticate($this->dbuser, $this->dbpassword);
	}
	
	public function TearDown()
	{
	}
	
	protected function AddQuote($value)
	{
		return '"'.$value.'"';
	}
}
?>
