<?php

namespace Json\Data;

class CCollection
{
	public $cityId;
	public $name;
	public $itemId;
	public $price;
	
	public function  __construct(\Models\CityCollectionType $collectionType)
	{		
		$this->cityId = $collectionType->getRoomId();
		$this->name = $collectionType->getName();
		$this->itemId = $collectionType->getItemId();
		$this->price = $collectionType->getPrice();
	}
}