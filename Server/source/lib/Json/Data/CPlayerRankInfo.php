<?php 

namespace Json\Data;

class CPlayerRankInfo
{
	public $playerNickName;
	public $rankIndex;
	public $time;
	public $playerId;
	public $avatarTemplateId;
		
	public function __construct(\Models\User $user)
	{
		$this->playerId = $user->getId();
		$this->playerNickName = $user->getName();
		$this->avatarTemplateId = $user->getAvatarTemplateId();
		
		$this->rankIndex = 0;
		$this->time = time();
	}
}

?>