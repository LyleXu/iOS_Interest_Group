<?php

var_dump('aaa');

$array = array();
$dict1 = array();
array_push($dict1, 10);
array_push($dict1, 20);
array_push($dict1, 30);

$dict2 = array();
array_push($dict2, 110);
array_push($dict2, 120);
array_push($dict2, 130);

array_push($array, (object)$dict1);
array_push($array, (object)$dict2);

$x = (object) $array;
echo print_r($x, true) . PHP_EOL;

echo 'method1' . PHP_EOL;
var_dump(object_to_array($x));
echo 'end' . PHP_EOL;

echo 'method2' . PHP_EOL;
var_dump(objectToArray($x));
echo 'end' . PHP_EOL;

function object_to_array(stdClass $Class){
    # Typecast to (array) automatically converts stdClass -> array.
    $Class = (array)$Class;
    
    # Iterate through the former properties looking for any stdClass properties.
    # Recursively apply (array).
    foreach($Class as $key => $value){
	if(is_object($value)&&get_class($value)==='stdClass'){
	    $Class[$key] = object_to_array($value);
	}
    }
    return $Class;
}

function objectToArray($d) {
	if (is_object($d)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}

	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return array_map(__FUNCTION__, $d);
	}
	else {
		// Return array
		return $d;
	}
}
?>