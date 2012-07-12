<?php
require_once "PHPMailer/class.phpmailer.php";
class BingoMail {
	private $username;
	private $toMail;
	private $password;
	
	public function __construct($username,$toMail, $password) {
		$this->toMail = $toMail;
		$this->password = $password;
		$this->username = $username;
	}
	
	public function Send() {
		
		try {
				$mail = new PHPMailer ( true ); //New instance, with exceptions enabled
	
				$initInfo = \Utility\GlobalConfiguration::GetInstance ()->Config [\Constant\SectionType::Mail];
				
				$body = $this->getBody($this->username,$this->password);
	
				$mail->IsSMTP (); // tell the class to use SMTP
				$mail->SMTPAuth = true; // enable SMTP authentication
				$mail->Port = 465; // set the SMTP server port
				$mail->Host = $initInfo[\Constant\ConfigKey::Host]; // SMTP server
				$mail->Username = $initInfo[\Constant\ConfigKey::Username]; // SMTP server username
				$mail->Password =  $initInfo[\Constant\ConfigKey::Password]; // SMTP server password
	
				$mail->IsSendmail (); // tell the class to use Sendmail
	
				$mail->AddReplyTo ( $initInfo[\Constant\ConfigKey::From], $initInfo[\Constant\ConfigKey::FromName] );
				
				$mail->From = $initInfo[\Constant\ConfigKey::From];
				$mail->FromName = $initInfo[\Constant\ConfigKey::FromName];
							
				$mail->AddAddress ( $this->toMail);
				
				$mail->Subject = $initInfo[\Constant\ConfigKey::Subject];
				
				$mail->WordWrap = 80; // set word wrap
				
	
				$mail->MsgHTML ( $body );
				
				$mail->IsHTML ( true ); // send as HTML
				
	
				$mail->Send ();
				
				return NULL;
				
			} catch ( phpmailerException $e ) {
				
				return $body.'######1#######'.$e->errorMessage ();;
			}
	}
	
	private function GetBody($username,$password) {
		$body  = '
		<p>Dear '.$username.',</p>
	<table>
	<tr>You have requested to get your password on Bingo System because you have forgotten your password.<br></tr> 
	<tr>If you did not request this, please ignore it.<br></tr> 
	<tr>Your username is: '.$username.'<br></tr>
	<tr>Your password is: '.$password.'<br></tr>
	<table>
	
	<p>Please do not reply this mail. Thanks for your coorparation.</p>
	
	<p>All the best,</p>
	Bingo System<br>
		';
		
		return $body;
	}
}