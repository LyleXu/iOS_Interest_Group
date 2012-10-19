<?php
use Json\Data\CUser;

use Json\Commands\UserResponse;

use Json\Commands\BaseResponse;
use Constant\ErrorCode;
use Models\User;
include_once __DIR__ . '/../lib/DoctrineBaseService.php';

class UserService extends DoctrineBaseService {	
	
	 /* Get All the Users 
	 * @return UserResponse
	 */
	function GetAllUsers() {
		
		$response = new UserResponse();
		
		try {
			$allBooks = $this->doctrinemodel->createQueryBuilder('Models\User')->getQuery()->execute()->toArray();
						
			if ($allBooks != NULL) {
				$response->_returnCode = ErrorCode::OK;
				
				$response->Users = array();
				
				foreach ($allBooks as $book) {
					array_push($response->Users, new CUser($book));
				}
			}	
			else {
				$response->_returnCode = ErrorCode::GetUserListFailed; 
			}
		
		} catch ( Exception $e ) {
			$response->_returnCode = ErrorCode::Failed;
			$response->_returnMessage = $e->getMessage ();
		}
		return $response;
	}

	/**
	 * 
	 */
	function AddUser($username,$pwd,$email)
	{
		$response = new UserResponse();
		
		try {
			$result = $this->doctrinemodel->getRepository ( 'Models\User' )->findOneBy ( array ('username' => $username ) );
			if($result != NULL)
			{
				$response->_returnCode = ErrorCode::UserAlreadyExists;
			}else
			{
				$pwd = base64_encode(md5(trim($pwd)));
				$user = new User($username, $pwd,$email);
				$this->doctrinemodel->persist($user);
				$this->doctrinemodel->flush();
				
				$response->_returnCode = ErrorCode::OK;
				$response->user = $user;
			}
		}
		catch ( Exception $e ) {
			$response->_returnCode = ErrorCode::Failed;
			$response->_returnMessage = $e->__toString ();
		}
		
		return $response;
	}
	
	/**
	 * 
	 * @param unknown_type $username
	 * @return \Json\Commands\UserResponse
	 */
	function RemoveUser($username)
	{
		$response = new UserResponse();
		
		try {
			$result = $this->doctrinemodel->getRepository ( 'Models\User' )->findOneBy ( array ('username' => $username ) );
			if($result != NULL)
			{
				$this->doctrinemodel->remove($result);
				$this->doctrinemodel->flush();
				$response->_returnCode = ErrorCode::OK;
			}else
			{
			
				$response->_returnCode = ErrorCode::InvalidUser;
				$response->_returnMessage = "InvalidUser";
			}
		}
		catch ( Exception $e ) {
			$response->_returnCode = ErrorCode::Failed;
			$response->_returnMessage = $e->__toString ();
		}
		
		return $response;
	}
	
	/**
	 * 
	 */
	function EditUser()
	{
		
	}
	
	function RemoveAllUser()
	{
		$response = new UserResponse();
		
		try {
			$allUsers = $this->doctrinemodel->getRepository ( 'Models\User' )->findAll()->toArray();
			if($allUsers != NULL)
			{
				foreach ($allUsers as $user)
				{
					$this->doctrinemodel->remove($user);
				}
				$this->doctrinemodel->flush();
				$response->_returnCode = ErrorCode::OK;
			}
		}
		catch ( Exception $e ) {
			$response->_returnCode = ErrorCode::Failed;
			$response->_returnMessage = $e->__toString ();
		}
		
		return $response;
		
	}
}
?>	
