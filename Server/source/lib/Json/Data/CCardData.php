<?php 

namespace Json\Data;

class CCardData
{
	public $cardData;
	public $index;
	public $coinNumbers;
	public $treasureNumbers;
	
	public function __construct(\Models\GameCard $gamecard)
	{
		$this->cardData = $gamecard->getUserCard();
		$this->index = $gamecard->getIndex();
		$this->coinNumbers = $gamecard->getCoinNumberList();
		$this->treasureNumbers = $gamecard->getTreasureNumberList();
	}
}

?>