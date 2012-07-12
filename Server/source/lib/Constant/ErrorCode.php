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
	
	// Game
	const GameServerNotAvailable = -200;
	const GameIdInvalid = -201;
	const GameRoundResultNotFound = -202;
	const GameRoundAlreadyRunning = -203;
	const GameRoundFinishedOrUnknown = -204;
	const GameRoundNotFound = -205;
	const NoBingoLeft = -206;
	
	// System
	const VersionNeedUpdate = -300;
	const VersionUnkownPlatform = -301;
	
	// Buy
	const KeyPackegeIdNotCorrect = -400;
	const NoEnoughMoney = -401;
	const PowerUpsPackegeIdNotCorrect = -402;
	const NoEnougnToken = -403;
	const GetAchievementsFailed = -404;
	const CityCollectionIdNotCorrect = -405;
	const HasGotAchievement = -406;
	const GetCityCollectionFailed = -407;
	const HasGotCityCollection = -408;
	const EmptyCityCollection = -409;
	const GetAllPowerUpsTypeFailed = -410;
	
	// PowerUp
	const PowerUpOwnerNotMatch = -500;
	const PowerUpInvalidStatus = -501;
	const PowerUpHasUsed = -502;
	const NoAvailablePowerUp = -503;
	
	// Treasure
	const NoTreasureChestToOpen = -600;
}
