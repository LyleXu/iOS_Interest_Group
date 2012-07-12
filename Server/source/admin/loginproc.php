<?php

// Inialize session
session_start();

// Include database connection settings
include('config.inc');

$username = $_POST['username'];
$password = $_POST['password'];

// Retrieve username and password from database according to user's input
// TODO

// Check username and password match
// TODO
if ($username != 'admin' || $password != 'admin')
{
	header('Location: securedpage.php');
}
else 
{
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;
	
	// Jump to login page
	header('Location: index.php');
}

?>