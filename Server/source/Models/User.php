<?php 

namespace Models;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="User")
 * 	@ODM\UniqueIndex(keys={"username"="asc", "udid"="asc"})
 * */
class User
{
    /** @ODM\Id */
    private $id;
	
    /** @ODM\String */
    private $username;

    /** @ODM\String */
    private $pwd;
    
    /** @ODM\String */
    private $email;

    /** @ODM\Int */
    private $userType;
    
    /** @ODM\Int */
    private $registerTime;
    
    /** @ODM\Int */
    private $lastLoginTime;
    
    
	
	public function __construct($username, $password, $email = NULL)
    	{
    		$this->username = $username;
    		$this->pwd = $password;
    		$this->email = $email;
    	}

    public function getId()
    {
    	return $this->id;
    }
    	
	public function getPwd()
	{	
		return $this->pwd;
	}   

	public function setPwd($password)
	{
		$this->pwd = $password;
		
	}
	
	public function  getUsername()
	{
		return $this->username;
	}
	
	public function  setUsername($username)
	{
		$this->username = $username;
	}

	public function getEmail()
	{
		return $this->email ;
	}
 
    public function  setEmail($mail)
    {
    	$this->email = $mail;
    }
    
}
?>
