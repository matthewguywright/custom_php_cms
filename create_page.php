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
	$errors = array();
	//FORM VALIDATION
	$required_fields = array('menu_name','position','update');
	foreach($required_fields as $fieldname) {
		if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
			$errors[] = $fieldname;
		}
	}
	
	$fields_with_lengths = array('menu_name' => 30);
	foreach($fields_with_lengths as $fieldname => $maxlength ) {
		if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) {
		$errors[] = $fieldname;
		}
	}
	
	if (!empty($errors)) {
		redirect_to("new_page.php");
	}
	
?>
<?php
	$subjectid = $_GET['subj'];
	$menu_name = trim(mysql_prep($_POST['menu_name']));
	$position = mysql_prep($_POST['position']);
	$visible = mysql_prep($_POST['visible']);
	$content = mysql_prep($_POST['update']);
?>
<?php
	$query = "INSERT INTO pages (subject_id, menu_name, position, visible, content) VALUES ('$subjectid', '{$menu_name}', '{$position}', '{$visible}', '{$content}')";	
	if (mysql_query($query)) {
		//Success!
		redirect_to("content.php?q=1");
	} else {
		//DISPLAY ERROR MESSAGE
		echo "<p>Page Creation Failed!</p>";
		echo "<p>" . mysql_error() . "</p>";
	}
?>
<?php
	mysql_close($dbconnect);
?>