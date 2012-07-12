<?php
require_once __DIR__ . '/Blowfish.php';
class BingoCrypt {
	
	private $iv;
	private $key;
	private $cryptFactroy;
	
	function __construct() {
		$this->cryptFactroy = & Crypt_Blowfish::factory ( 'cbc' );
		if (PEAR::isError ( $this->cryptFactroy )) {
			echo $this->cryptFactroy->getMessage ();
			exit ();
		}
		
		$this->iv = 'abc123@%';
		$this->key = 'this is the screct key for bingo';
	}
	
	public function encrypt($pwd) {
		$this->cryptFactroy->setKey( $this->key, $this->iv );
		return $this->cryptFactroy->encrypt($pwd);
	}
	
	public function decrypt($pwd)
	{
		$this->cryptFactroy->setKey( $this->key, $this->iv );
		return $this->cryptFactroy->decrypt($pwd);
	}
}