<?php 

namespace Models;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="Book")
 * 	@ODM\UniqueIndex(keys={"name"="asc", "udid"="asc"})
 * */
class Book
{
    /** @ODM\Id */
    private $id;
	
    /** @ODM\String */
    private $BianHao;
    
    /** @ODM\String */
    private $title;

    /** @ODM\String */
    private $Author;
    
    /** @ODM\String */
    private $ISBN;   
    
    /** @ODM\String */
    private $image;
    
    /** @ODM\Int */
    private $EnterLibraryTime;
    
	public function __construct($Bianhao, $title)
    	{
    		$this->BianHao = $Bianhao;
    		$this->title = $title;
    	}

    public function GetTitle()
    {
    	return $this->title;    	
    }
	  
    public function GetBianHao()
    {
    	return $this->BianHao;
    }
}
?>
