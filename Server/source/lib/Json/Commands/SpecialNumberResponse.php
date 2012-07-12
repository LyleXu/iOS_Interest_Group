<?php

namespace Json\Commands;

class SpecialNumberResponse extends  BaseResponse
{
	public $specialNumbers;		// an int array, order by gameboard index
	public $doubleDaubSecondSpecialNumbers;	// if it's the double daub, return the second special numbers
}