<?php
use Json\Commands\BaseResponse;
use Json\Commands\LoginResponse;
use Constant\ErrorCode;
use Models\User;
include_once __DIR__ . '/../lib/DoctrineBaseService.php';

class LoginService extends DoctrineBaseService {	
	
	/**
	 * Login
	 * @param unknown_type $username
	 * @param unknown_type $password
	 * @return \Json\Commands\LoginResponse
	 */
	function Login($username, $password ) {
		$response = new \Json\Commands\LoginResponse ();
		
		try {
			$user = $this->doctrinemodel->getRepository ( 'Models\User' )->findOneBy ( array ('username' => $username));
			//echo '#'.$username.'#';
			//echo $user;
			if ($user != null) {
				$encrypt = base64_encode(md5(trim($password)));
				//the user and pwd is correct.
				if (strcmp ( $encrypt, $user->getPwd() ) == 0) {
					// if login in different place, send a notification here..
					$response->_returnCode = ErrorCode::OK;
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
}
?>	
