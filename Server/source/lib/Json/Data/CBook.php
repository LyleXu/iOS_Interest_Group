<?php

namespace Json\Data;

class CBook
{
	public $title;
	public  $bianhao;
	public $author;
	public $description;
	public $image;
		
	public function  __construct(\Models\Book $book)
	{
		$this->title = $book->GetTitle();
		$this->bianhao = $book->GetBianHao();	
		$this->author = $book->GetAuthor();	
		$this->description = $book->GetDescription();
	}
}