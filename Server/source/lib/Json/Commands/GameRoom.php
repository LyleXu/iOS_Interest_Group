<?php 

namespace Json\Commands;

class GameRoom  
{
	public $status;
	public $name;
	public $description;
	public $id;
	public $level;
	public $cityId;
	public $minCoin;
	public $maxCoin;
	public $minToken;
	public $maxToken;
	public $costPerCard;
	public $extraTokenCompleted;
	public $xpPerDaub;
	public $xpPerBingo;
	public $tokenPerBingo;
	public $coinPerBingo;
	public $firstExtraCoin;
	public $secondExtraCoin;
	public $thirdExtraCoin;
	public $firstExtraToken;
	public $secondExtraToken;
	public $thirdExtraToken;
	public $coinSlotLow;
	public $coinSlotHigh;
	
	public function __construct(\Models\GameRoom $room)
	{
		$this->cityId = $room->getCityId();
		$this->name = $room->getName();
		$this->description = $room->getDescription();
		$this->level = $room->getLevel();
		$this->id = $room->getId();
		$this->status = $room->getStatus();
		$this->minCoin = $room->getBingoCoinBonus();
		$this->maxCoin = $room->getMaxCoin();
		$this->minToken = $room->getBingoTokenBonus();
		$this->maxToken = $room->getMaxToken();
		$this->costPerCard = $room->getCostPerCard();
		$this->extraTokenCompleted = $room->getDailyTokenCollectionCompleted();
		
		$this->xpPerBingo = $room->getBingoXPBonus();
		$this->xpPerDaub = $room->getDaubXPBonus();
		$this->tokenPerBingo = $room->getBingoTokenBonus();
		$this->coinPerBingo = $room->getBingoCoinBonus();
		$this->firstExtraCoin = $room->getFirstPlaceExtraCoins();
		$this->firstExtraToken = $room->getFirstPlaceExtraToken();
		$this->secondExtraCoin = $room->getSecondPlaceExtraCoins();
		$this->secondExtraToken = $room->getSecondPlaceExtraToken();
		$this->thirdExtraCoin = $room->getThirdPlaceExtraCoins();
		$this->thirdExtraToken = $room->getThirdPlaceExtraToken();
		$this->coinSlotLow = $room->getCoinSlotPayoutLow();
		$this->coinSlotHigh = $room->getCoinSlotPayoutHigh();
	}
}

?>