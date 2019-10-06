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
	find_selected_page();	
?>
<?php require_once("includes/top.php"); ?>
     	<div id="contentLoad">
     <?php
	 	//MESSAGE FIELDS PULLING Q ID
	 	$successful = $_GET['q'];
	 	if ($successful == 1) {
			echo "<p>The page was successfully added.</p>";
		}
		
		$deleted = $_GET['q'];
		if ($deleted == 'pagedeleted') {
			echo "<p>The page was successfully deleted.</p>";
		}
		
		$sub_deleted = $_GET['q'];
		if ($deleted == 'subjectdeleted') {
			echo "<p>The subject was successfully deleted.</p>";
		}
	 ?>
        <br />
	 <?php 
		if (!is_null($sel_subject)) { //subject selected ?>
			<h2><?php echo $sel_subject['menu_name']; ?></h2>
	<?php	
		} elseif (!is_null($sel_page)) { //page selected ?>
			<h2><?php echo $sel_page['menu_name']; ?></h2>
	<?php 	
		} else { //nothing selected ?>
        	<h3>Current Administrator: <?php echo strtoupper($_SESSION['username']); ?>!</h3>
			<p>To add a new menu heading (subject), click on "Add a new subject". To edit a subject or page, click on that item in the menu. To add a new page, you must first click on it's subject, then click the "Add a new page" link. If there isn't a subject created yet for your page, simply click "Add a new subject". After the new subject is created, click on it and add a page.</p>
    <?php } ?>
       
			<?php echo $sel_page['content']; ?>
            
            <?php
				if (isset($sel_page['id'])) { ?>
            <a class="edit" href="edit_page.php?page=<?php echo $sel_page['id']; ?>">Edit Page</a>
			<?php } ?>
        </div> <!--ENDS CONTENTLOAD-->
	</div> <!--ENDS CONTENT_MAIN-->

	<div id="content_sub">
    	<?php echo navigation($sel_subject, $sel_page); ?>
        <br />
        <a href="new_subject.php">+ Add a new subject</a>
        <br />
        <a href="staff.php">Back to Main Menu</a>
        <br />
        <a href="logout.php">Logout</a>
	</div> <!--ENDS CONTENT_SUB-->    
<?php require_once("includes/site_info.php"); ?>