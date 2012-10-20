<?php 

namespace Models;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="Book")
 * 	@ODM\UniqueIndex(keys={"BianHao"="asc", "udid"="asc"})
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
    private $description;
    
    /** @ODM\String */
    private $author;
    
    /** @ODM\Int */
    private $publishedDate;
    
    /** @ODM\String */
    private $publisher;
    
    /** @ODM\String */
    private $language;
    
    /** @ODM\Int */
    private $printLength;
    
    /** @ODM\String */
    private $ISBN;   
    
    /** @ODM\String */
    private $image;
    
    /** @ODM\Int */
    private $EnterLibraryTime;
    
	public function __construct($Bianhao, $title, $author)
    	{
    		$this->BianHao = $Bianhao;
    		$this->title = $title;
    		$this->author = $author;
    	}

    public function GetTitle()
    {
    	return $this->title;    	
    }
	  
    public function GetBianHao()
    {
    	return $this->BianHao;
    }
    
    public function GetAuthor()
    {
    	return $this->author;   	
    }
    
    public function setAuthor($author)
    {
    	$this->author = $author;
    }
    
    public function GetDescription()
    {
    	return $this->description;   	
    }
    
    public function setDescription($description)
    {
    	$this->description = $description;   	
    }
    
    public function getPrintLength()
    {
    	return $this->printLength;   	
    }
    
    public function setPrintLength($printLength)
    {
    	$this->printLength = $printLength;
    }
    
    public function getPublishedDate()
    {
    	return $this->publishedDate;
    }
    
    public function setPublishedDate($publishedDate)
    {
    	$this->publishedDate = $publishedDate;
    }
    
    public function getPublisher()
    {
    	return $this->publisher;
    }
    
    public function setPublisher($publisher)
    {
    	$this->publisher = $publisher;
    }
    
    public function getLanguage()
    {
    	return $this->language;
    }
    
    public function setLanguage($language)
    {
    	$this->language = $language;
    }
}
?>
