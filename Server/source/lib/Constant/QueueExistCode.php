<?php 

namespace Constant;

class QueueExistCode
{
	const Unknown = 0;
	const ClientDemand = -1;
	const ServerDemand = -2;
	const QueueHeartBeatStop = -3;
	const UserHeartBeatStop = -4;
	const TokenExpire = -5;
	const UserOffline = -6;
}
