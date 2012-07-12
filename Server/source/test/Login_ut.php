<?php
require_once '../odmconfig.php';
include_once './framework/doctrinetestcase.php';
include_once '../amfphp/services/LoginService.php';
//include_once '../lib/Crypt/Blowfish.php';
include_once '../lib/Constant/ErrorCode.php';

class LoginServiceTest extends DoctrineTestCase
{
	private $m = NULL;
	private $db;
	private $users;
	
	public function SetUp()
	{
		
	}
	
	public function Run()
	{
		
		$username = 'LyleXu';
		$pwd = '123456';
		
		$login = new LoginService();
		
		$registerNonce = $login->GetRegisterNonce();
		$this->AssertEquals(strlen($registerNonce->_nonce), 6, 'register nonce is not correct');
		
		/*
		$register = $login->Register($this->AddQuote($username)
									, $this->AddQuote($pwd) 
									, $this->AddQuote('LyleXu@gmail.com')
									, $this->AddQuote($registerNonce->_sessionId)
									, $this->AddQuote($registerNonce->_nonce));
		
		$this->AssertEquals($register->_returnCode, Constant\ErrorCode::OK, 'Register not successfully');
		
		
		
		$nonce = $login->GetNonce($this->AddQuote($username));
	    $this->AssertEquals(strlen($nonce->_nonce), 6, 'Login not successfully');	
	    
		$cnonce = "abcdef";
		
		$pwdfromclient = md5($nonce->_nonce.$cnonce.$decrypt);
		
		$result = $login->Login($username,$pwdfromclient,$cnonce);
		$this->AssertEquals($result->_returnCode, Constant\ErrorCode::OK, 'Login not successfully');		
		*/
	}

	public function TearDown()
	{
	 	//$this->users->drop();
	}
}

$suite = new TestSuite;
$suite->AddTest('LoginServiceTest');
 
$runner = new ConsoleTestRunner();
//$runner = new TextTestRunner();
$runner->Run($suite, false);
