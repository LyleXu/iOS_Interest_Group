<?php
use Json\Data\CBook;

use Json\Commands\BookResponse;

use Json\Commands\BaseResponse;
use Constant\ErrorCode;
use Models\Book;
include_once __DIR__ . '/../lib/DoctrineBaseService.php';

class BookService extends DoctrineBaseService {	
	
	 /* Get All the books in the Library
	 * @return BookResponse
	 */
	function GetAllBooks() {
		
		$response = new Json\Commands\BookResponse();
		
		try {
			$allBooks = $this->doctrinemodel->createQueryBuilder('Models\Book')->getQuery()->execute()->toArray();
						
			if ($allBooks != NULL) {
				$response->_returnCode = ErrorCode::OK;
				
				$response->Books = array();
				
				foreach ($allBooks as $book) {
					array_push($response->Books, new CBook($book));
				}
			}	
			else {
				$response->_returnCode = ErrorCode::CannotGetBookList; 
			}
		
		} catch ( Exception $e ) {
			$response->_returnCode = ErrorCode::Failed;
			$response->_returnMessage = $e->getMessage ();
		}
		return $response;
	}

	/**
	 * 
	 */
	function AddBook($bianHao,$title)
	{
		$response = new BookResponse();
		
		try {
			$result = $this->doctrinemodel->getRepository ( 'Models\Book' )->findOneBy ( array ('BianHao' => $bianHao ) );
			if($result != NULL)
			{
				$response->_returnCode = ErrorCode::BianHaoAlreadyExists;
			}else
			{
				$book = new Book($bianHao, $title);
				$this->doctrinemodel->persist($book);
				$this->doctrinemodel->flush();
				
				$response->_returnCode = ErrorCode::OK;
				$response->book = $book;
			}
		}
		catch ( Exception $e ) {
			$response->_returnCode = ErrorCode::Failed;
			$response->_returnMessage = $e->__toString ();
		}
		
		return $response;
	}
	
	/**
	 * 
	 */
	function RemoveBook()
	{
		
	}
	
	/**
	 * 
	 */
	function EditBook()
	{
		
	}
}
?>	
