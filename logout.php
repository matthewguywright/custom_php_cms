<?php require_once("includes/sessions.php"); ?>
<?php
	if (!isset($_SESSION['username'])) {
		header("Location: index.php");
		exit;
	}
?>
<?php require_once("includes/functions.php"); ?>
<?php 
	//log out - 4 steps
	//find session
	session_start();
	//unset all the variables
	$_SESSION = array();
	//destroy session cookie
	if(isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	//destroy the session
	session_destroy();
	//redirect to login
	redirect_to("index.php");
?>