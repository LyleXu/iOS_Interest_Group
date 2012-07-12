<?php

namespace Utility;

/**
 * Class Singleton is a generic implementation of the singleton design pattern.
 *
 * Extending this class allows to make a single instance easily accessible by
 * many other objects.
 *
 * @author     Quentin Berlemont <quentinberlemont@gmail.com>
 */
abstract class Singleton
{
    /**
     * Prevents direct creation of object.
     *
     * @param  void
     * @return void
     */
    protected function __construct() {}

    /**
     * Prevents to clone the instance.
     *
     * @param  void
     * @return void
     */
    final private function __clone() {}

    /**
     * Gets a single instance of the class the static method is called in.
     *
     * See the {@link http://php.net/lsb Late Static Bindings} feature for more
     * information.
     *
     * @param  void
     * @return object Returns a single instance of the class.
     */
    final static public function getInstance()
    {
        static $instance = null;

        return $instance ?: $instance = new static;
    }
}
?>