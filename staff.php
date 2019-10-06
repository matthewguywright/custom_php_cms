<?php require_once("includes/sessions.php"); ?>
<?php
	if (!isset($_SESSION['username'])) {
		header("Location: index.php");
		exit;
	}
?>
<?php require_once("includes/top.php"); ?>
    <h2>Staff Menu</h2>
    <p>Hello <?php print strtoupper($_SESSION['username']); ?>, welcome to the staff area.</p>
        <div id="staffnavbar" style="padding-left: 10px">
            <ul id="staff_nav">
                <li><a href="content.php">Manage Website Content</a></li>
                <li><a href="new_user.php">Global Settings</a></li>
                <li><a href="sendmail.php">Send an E-mail</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div> <!--ENDS STAFFNAVBAR-->
</div> <!--ENDS CONTENT_MAIN-->

<div id="content_sub"> 
    <a href="/">Back to Website</a>
</div> <!--ENDS CONTENT_SUB-->    
<?php require_once("includes/site_info.php"); ?>