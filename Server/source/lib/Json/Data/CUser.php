<?php

namespace Json\Data;

class CUser
{
	public $username;
	public  $pwd;
	public $email;
		
	public function  __construct(\Models\User $user)
	{
		$this->username = $user->getUsername();
		$this->pwd = $user->getPwd();	
		$this->email = $user->getEmail();	
	}
}