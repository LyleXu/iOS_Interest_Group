<?php 

require_once 'gtcclibrary/Doctrine/Common/ClassLoader.php';

use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\IndexedReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

// ODM Classes
$classLoader = new ClassLoader('Doctrine\ODM\MongoDB', 'gtcclibrary');
$classLoader->register();

// Common Classes
$classLoader = new ClassLoader('Doctrine\Common', 'gtcclibrary');
$classLoader->register();

// MongoDB Classes
$classLoader = new ClassLoader('Doctrine\MongoDB', 'gtcclibrary');
$classLoader->register();

// Json Classes
$classLoader = new ClassLoader('Json', 'gtcclibrary');
$classLoader->register();

// Utility Classes
$classLoader = new ClassLoader('Utility', 'gtcclibrary');
$classLoader->register();

// Message queue
$classLoader = new ClassLoader('MessageQueue', 'gtcclibrary');
$classLoader->register();

// Constant
$classLoader = new ClassLoader('Constant', 'gtcclibrary');
$classLoader->register();

// Daemon Message
$classLoader = new ClassLoader('Message',  'gtcclibrary');
$classLoader->register();

// Daemon
$classLoader = new ClassLoader('Daemon', 'gtcclibrary');
$classLoader->register();

// Document classes
$classLoader = new ClassLoader('Models', 'gtcclibrary');
$classLoader->register();
