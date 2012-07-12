<?php

class Nonce {
	
	static public function createNonce($length = 6) {
		
		$length = ( int ) $length;
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$chars .= 'abcdefghijklmnopqrstuvwxyz';
		$chars .= '1234567890';
		
		$unique = '';
		for($i = 0; $i < $length; $i ++) {
			$unique .= substr ( $chars, (rand () % (strlen ( $chars ))), 1 );
		}
		
		return $unique;
	}
}