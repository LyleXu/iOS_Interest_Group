<?php 

namespace Constant;

class ErrorCode
{
	// >=0 means success, >0 means success but return special code..
	// Success Code
	const TooLateToPurchaseCard = 100;
	const AlreadyBuyCards = 101;
	const TaskAlrealyInQueue = 102;
	
	// HTTPStream
	const StreamClosed = 88;
		
	// Common
	const OK = 0;
	const Failed = -1;
	const AlreadyExist = -2;
	const InvalidParameter = -3;
	const DaubsNotEmpty = -4;
	const DaubNotInCallNumbers = -5;
	const DaubNotInCards = -6;
	const NoDaubs = -7;
	const CallBingoFailed = -8;
	const InvalidGameRound = -9;
	const InvalidCardId = -10;
	const InvalidRoundId = -11;
	const InvalidPowerUpId = -12;
	const InvalidDaubNumber = -13;
	const InvalidFormat = -14;
	const NoPermission = -15;
	
	// Book
	const CannotGetBookList = -200;
	const BianHaoAlreadyExists = -201;
	
	// User
	const InvalidUser = -100;
	const UserOffline = -101;
	const UserExists = -102;
	const UserPwdWrong = -103;
	const UserNotExists = -104;
	const InvalidRegister = -105;
	const EmptyNonce = -106;
	const EmptyToken = -107;
	const EmptySession = -108;
	const InvalidSession = -109;
	const NotTimeToGiveTokenBonus = -110;
	const NotEnoughLevel = -111;
	const UserOrPasswordNotCorrect = -112;
	const UdidAlreadRegisted = -113;
	const ReachMaxPlayerLimit = -114;
	const ReachMaxCardCountLimit = -115;
	
	
}
