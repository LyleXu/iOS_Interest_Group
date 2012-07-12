<?php
use Json\Commands\BaseResponse;
use Json\Commands\LoginResponse;
use Constant\ErrorCode;
use Models\User;
include_once __DIR__ . '/../lib/DoctrineBaseService.php';

class LoginService extends DoctrineBaseService {	
	
	 /* Login
	 * @param String $name
	 * @param String $password
	 * @param String $cnonce
	 * @return LoginResponse
	 */
	function Login($name, $password ) {
		$response = new Json\Commands\LoginResponse ();
		
		try {
			$user = $this->doctrinemodel->getRepository ( 'Models\User' )->findOneBy ( array ('name' => $name ) );
			
			if ($user != null) {
					$encrypt = base64_encode(md5(trim($password)));
					//the user and pwd is correct.
					if (strcmp ( $encrypt, $user->getPassword() ) == 0) {					
						// if login in different place, send a notification here..
					} else {
						$response->_returnCode = ErrorCode::UserPwdWrong; // user/pwd is not correct.
					}
			} else {
				$response->_returnCode = ErrorCode::UserNotExists; // user/pwd is not correct.
			}
		
		} catch ( Exception $e ) {
			$response->_returnCode = ErrorCode::Failed;
			$response->_returnMessage = $e->getMessage ();
		}
		return $response;
	}
	
	
	
	 /** 
	 * Convert the guest user to the regular user
	 * @param string $username
	 * @param string $password
	 * @param string $email
	 * @param int $avatarTemplateId
	 * @return BaseResponse
	 */
	public function Register($username,$password,$email){
		$response = new Json\Commands\BaseResponse();
		
		// check username,
		if (preg_match(\Constant\RegularExpressions::EMail, $email) == 0 ||
			preg_match(\Constant\RegularExpressions::UserName, $username) == 0 ||
			preg_match(\Constant\RegularExpressions::Password, $password) == 0  
			)
		{
			$response->_returnCode = \Constant\ErrorCode::InvalidFormat;
			return $response;
		}
		
		try {			
			$user = $this->doctrinemodel->getRepository ( 'Models\User' )->findOneBy ( array ('name' => $username ) );
			if($user == NULL)
			{
				$newUser = new User();
				$newUser->setName($username);
				$newUser->setPassword(base64_encode ( md5($password ) ));
				$newUser->setEmail($email);
				$this->doctrinemodel->persist($newUser);
				$this->doctrinemodel->flush();
				
				$response->_returnCode = ErrorCode::OK;
			}else{
				$response->_returnCode = ErrorCode::UserNotExists;
			}
		}catch( Exception $e ) {
			$response->_returnCode = ErrorCode::Failed;
			$response->_returnMessage = $e->__toString ();
		}
		return $response;
	}

}
?>	
