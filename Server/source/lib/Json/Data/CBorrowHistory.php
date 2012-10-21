<?php

namespace Json\Data;

class CBorrowHistory
{
	public $username;
	public $bookName;
	public $bookBianhao;
	public $borrowDate;
	public $planReturnDate;
	public $realReturnDate;
		
	public function  __construct(\Models\BorrowHistory $borrowRecord)
	{
		$this->username = $borrowRecord->getUser()->getUsername();
		$this->bookName = $borrowRecord->getBook()->GetTitle();
		$this->bookBianhao = $borrowRecord->getBook()->GetBianHao();
		$this->borrowDate = $borrowRecord->getStartBorrowDate();
		$this->planReturnDate = $borrowRecord->getPlanReturnDate();
		$this->realReturnDate = $borrowRecord->getRealReturnDate();
	}
}