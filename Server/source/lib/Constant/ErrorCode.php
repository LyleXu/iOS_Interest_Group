<?php 

namespace Constant;

class ErrorCode
{
	// >=0 means success, >0 means success but return special code..
		
	// Common
	const OK = 0;
	const Failed = -1;
	const AlreadyExist = -2;
	const InvalidParameter = -3;
	const InvalidFormat = -4;
	
	// User
	const InvalidUser = -100;
	const GetUserListFailed = -101;
	const UserAlreadyExists = -102;
	const UserNotExists = -103;
	const UserPwdWrong = -104;
	
	// Book
	const CannotGetBookList = -200;
	const BianHaoAlreadyExists = -201;
	const NoSuchBook = -202;
	
	// Borrow History
	const NoSuchHistory = -300;
	const NoBookInBorrow = -301;
	
	
	
}
