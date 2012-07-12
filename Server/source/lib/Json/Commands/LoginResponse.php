<?php

namespace Json\Commands;

class LoginResponse extends  BaseResponse
{
	public $sessionId;
	public $userId;
	public $dailyTokenBonus;
}