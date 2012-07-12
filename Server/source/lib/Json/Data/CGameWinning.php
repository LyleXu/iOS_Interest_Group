<?php 

namespace Json\Data;

class CGameWinning
{
    public $xp;
    public $coin;
    public $token;
    public $keys;
    public $powerUps;
    public $teamPoints;
    public $treasureChests;
    public $totalBingo;
    public $highBingoRank;
    
    public function __construct()
    {
    	$this->xp = 0;
    	$this->coin = 0;
    	$this->token = 0;
    	$this->keys = 0;
    	$this->powerUps = 0;
    	$this->teamPoints = 0;
    	$this->treasureChests = 0;
    	$this->totalBingo = 0;
    	$this->highBingoRank = 0;
    }
}
?>