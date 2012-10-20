<?php 

namespace Models;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="BorrowHistory")
 * 	@ODM\UniqueIndex(keys={"startBorrowDate"="asc", "udid"="asc"})
 * */
class BorrowHistory
{
    /** @ODM\Id */
    private $id;
	
    /** @ODM\ReferenceOne(targetDocument="User") */
    private $user;

   /** @ODM\ReferenceOne(targetDocument="Book") */
    private $book;
    
    /** @ODM\String */
    private $startBorrowDate;

    /** @ODM\String */
    private $planReturnDate;
    
    /** @ODM\String */
    private $realReturnDate;   
	
	public function __construct($user, $book, $startBorrowDate, $planReturnDate)
	{
		$this->user = $user;
		$this->book = $book;
		$this->startBorrowDate = $startBorrowDate;
		$this->planReturnDate = $planReturnDate;
		$this->realReturnDate = '-1';
	}   
	
	public function getUser()
	{
		return $this->user;
	}
	
	public function getBook()
	{
		return $this->book;
	}
	
	public function getStartBorrowDate()
	{
		return $this->startBorrowDate;
	}
	
	public function getPlanReturnDate()
	{
		return $this->planReturnDate;
	}
	
	public function getRealReturnDate()
	{
		return $this->realReturnDate;
	}
	
	public function setRealReturnDate($date)
	{
		$this->realReturnDate = $date;
	}
}
?>
