<?php

require_once '../odmconfig.php';

// Foo class
class Foo extends \Utility\Singleton
{
    // Bar method
    public function bar()
    {
        echo __CLASS__ . PHP_EOL;
    }
}

// Returns a single instance of Foo class
$foo = Foo::getInstance();

// Prints: Foo
 $foo->bar();
?>