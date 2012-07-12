<?php

namespace Json\Data;

class CAchievement
{
	public $name;
	public  $number;
	public $description;
	public $afterDescription;
	public $openfeintId;
	
	public function  __construct(\Models\Achievements $ach, $detailed = FALSE)
	{
		$this->name = $ach->getName();
		$this->number = $ach->getNumber();
		$this->openfeintId = $ach->getOpenfeintId();
		
		if ($detailed)
		{
			$this->description = $ach->getDescription();
			$this->afterDescription = $ach->getAfterDescription();
		}
	}
}