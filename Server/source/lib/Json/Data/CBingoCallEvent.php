<?php

namespace Json\Data;

class CBingoCallEvent
{
	public $callerInfo;
	public $allPlayersRank = array();
	public $currentStatus;
	
	public function __construct(){
		$this->currentStatus = new \Json\Data\CGameRoundInfo();
	}
}

?>