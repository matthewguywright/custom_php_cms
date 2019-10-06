<?php require_once("includes/sessions.php"); ?>
<?php
if (isset($_SESSION['username'])) {
		//logged in
	} else {
		//Not logged in
		header("Location: index.php");
		exit;
	}
?>
<?php
	require_once("includes/dbconnection.php"); ?>
<?php
	
	$id = $_GET['id'];
	
	if ($_GET['id'] == $_SESSION['user_id']) {
		header("Location: new_user.php?q=error");
		exit;
	} else {
		$sql = "DELETE FROM users WHERE id='$id' ";
		$ok = mysql_query($sql);
		if ($ok) {
			header("Location: new_user.php?q=delete");
		} else {
			print "<h2>The user was not deleted!</h2>";
		}
	print "<a href=\"staff.php\">Back to Control Panel</a>";
	
	}
?>