<?php

namespace Json\Data;

class CBorrowHistory
{
	public $username;
	public $bookName;
	public $borrowDate;
	public $planReturnDate;
	public $realReturnDate;
		
	public function  __construct(\Models\BorrowHistory $borrowRecord)
	{
		$this->username = $borrowRecord->getUser()->getUsername();
		$this->bookName = $borrowRecord->getBook()->GetTitle();
		$this->borrowDate = $borrowRecord->getStartBorrowDate();
		$this->planReturnDate = $borrowRecord->getPlanReturnDate();
		$this->realReturnDate = $borrowRecord->getRealReturnDate();
	}
}