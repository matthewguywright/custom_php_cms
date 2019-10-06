<?php require_once("constants.php"); ?>
<?php
	//CONNECT TO MYSQL  
	$dbconnect = mysql_connect(DB_HOST,DB_USER,DB_PW); 
	if (!$dbconnect) {
		die('Connection Failed! '.mysql_error());
	}
	
	//SELECT THE DATABASE
	$dbselect = mysql_select_db(DB_NAME,$dbconnect); 
	if (!$dbselect) {
		die('Connection Failed! '.mysql_error());
	}
?>