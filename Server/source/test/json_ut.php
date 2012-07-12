<?php

class TestFoo
{
	public $intValue;
	public $arrayValue;
	public $message;
}

$arrayData = array( 0, 1);

$foo = new TestFoo();
$foo->intValue = 1;
$foo->arrayValue = $arrayData;
$foo->message = 'bye moto';

echo json_encode($foo, JSON_FORCE_OBJECT) . PHP_EOL;

echo json_encode($foo);

?>