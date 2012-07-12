<?php 

namespace Models;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="User")
 * 	@ODM\UniqueIndex(keys={"name"="asc", "udid"="asc"})
 * */
class User
{
    /** @ODM\Id */
    private $id;
	
    /** @ODM\String */
    private $name;

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
    
    
	
	public function __construct($username, $password = NULL)
    	{
    		$this->name = $username;
    		$this->pwd = $password;
    	}

	public function getPassword()
	{	
		return $this->pwd;
	}   

public function setName($username)
{
	$this->name = $username;
}

public function setPassword($pwd)
{
	$this->pwd = $pwd;
}

public function setEmail($mail)
{
	$this->email = $mail;
}
 
    public function Reset()
    {
    }
    
    
}
?>
