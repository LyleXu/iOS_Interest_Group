<?php
namespace Constant;

class RegularExpressions
{
	const EMail = '/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i';
	const UserName = '/^[a-z0-9_-]{3,15}$/i';
	const Password = '/^.*(?=.{4,})(?=.*\d)(?=.*[a-z]).*$/i';
}
