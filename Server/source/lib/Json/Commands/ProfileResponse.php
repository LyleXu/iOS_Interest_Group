<?php

namespace Json\Commands;

class ProfileResponse extends  BaseResponse
{
	public $xp;
	public $bingos;
	public $token;
	public $coin;
	public $keys;
	public $avatar;
	public $avatarTemplateId;
	public $powerCount;
	public $name;
	public $dailyTokenBonusRate;
	
	function __construct()
	{
	}
	
	function SetupUser(\Models\User $user)
	{
		$this->name = $user->getName();
		$this->xp = $user->getXp();
   		$this->bingos = $user->getBingos();
    	$this->token = $user->getToken();
    	$this->coin = $user->getCoin();
    	$this->keys = $user->getKeys();
    	$this->avatar = $user->getAvatar();
    	$this->avatarTemplateId = $user->getAvatarTemplateId();
    	$this->dailyTokenBonusRate = $user->getDailyTokenBonusRate();
	}
}