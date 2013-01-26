<?php

namespace Json\Data;

class CBook
{
	public $title;
	public $bianhao;
	public $author;
	public $publishedDate;
	public $publisher;
	public $language;
	public $printLength;
	public $image;
	public $ISBN;
	public $bookDescription;
	public $price;
		
	public function  __construct(\Models\Book $book)
	{
		$this->bianhao = $book->GetBianHao();
		$this->title = $book->GetTitle();	
		$this->author = $book->GetAuthor();	
		$this->publisher = $book->getPublisher();
		$this->publishedDate = $book->getPublishedDate();
		$this->language = $book->getLanguage();
		$this->printLength = $book->getPrintLength();
		$this->ISBN = $book->getISBN();
		$this->bookDescription = $book->GetDescription();
		$this->price = $book->getPrice();
	}
}