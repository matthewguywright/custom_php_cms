<?php require_once("includes/sessions.php"); ?>
<?php
	if (!isset($_SESSION['username'])) {
		header("Location: index.php");
		exit;
	}
?>
<?php require_once("includes/dbconnection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	if (intval($_GET['subj']) == 0) {
		//redirect
		redirect_to("content.php");
	}
	$id = mysql_prep($_GET['subj']);
	
	if ($subject = get_subject_by_id($id)) {
	$query = "DELETE FROM subjects WHERE id = '$id' LIMIT 1";
	$result = mysql_query($query, $dbconnect);
	if (mysql_affected_rows() == 1) {
		redirect_to("content.php?q=subjectdeleted");
	} else {
		//DELETION FAILED
		echo "<p>Subject deletion failed.</p>";
		echo "<p>" . mysql_error() . "</p>";
		echo "<a href=\"content.php\">Return to Main Page</a>";
	}
	} else {
		//SUBJECT DIDN"T EXIST
		redirect_to("content.php");
	}	
?>
<?php
	mysql_close($dbconnect);
?>