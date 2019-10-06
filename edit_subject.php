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
	
	if (isset($_POST['submit'])) {
		$errors = array();
		//FORM VALIDATION //,'visible'
		$required_fields = array('menu_name','position');
		foreach($required_fields as $fieldname) {
			if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && !is_int($_POST[$fieldname]))) {
				$errors[] = $fieldname;
			}
	}
	
		$fields_with_lengths = array('menu_name' => 30);
		foreach($fields_with_lengths as $fieldname => $maxlength ) {
			if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) {
		$errors[] = $fieldname;
			}
		}
	
	if (empty($errors)) {
		//PERFORM UPDATE
		$id = mysql_prep($_GET['subj']);	
		$menu_name = mysql_prep($_POST['menu_name']);
		$position = mysql_prep($_POST['position']);
		$visible = mysql_prep($_POST['visible']);
		
		$query = "UPDATE subjects SET menu_name = '$menu_name', position = '$position', visible = '$visible' WHERE id = '$id' ";
		$result = mysql_query($query, $dbconnect);
		if (mysql_affected_rows() == 1) {
			//Success
			$message = "The subject was successfully updated.";	
		} else {
			//Failed
			$message = "The subject update failed.";
			$message .= "<br />". mysql_error();	
		}
		
	} else {
		//Errors Occured
		if (count($errors) > 1) {
			$message = "There were " . count($errors) . " errors in the form.";
		} else {
			$message = "There was " . count($errors) . " error in the form.";
		}
	}
		
				
} //END OF ISSET POST
?>
<?php find_selected_page(); ?>
<?php require_once("includes/top.php"); ?>
    	<div id="contentLoad">
			<h2>Edit Subject: <?php echo $sel_subject['menu_name']; ?></h2>
            
            <?php
				if (!empty($message)) {
					echo "<p class=\"message\">" . $message . "</p>";
				}
			?>
            
            <form action="edit_subject.php?subj=<?php echo urlencode($sel_subject['id']); ?>" method="post">
            	<p>Subject name:
                	<input type="text" name="menu_name" value="<?php echo $sel_subject['menu_name']; ?>" id="menu_name" />
                </p>
            	<p>Position:
                	<select name="position">
                    <?php
						$subject_set = get_all_subjects();
						$subject_count = mysql_num_rows($subject_set);
						for($count=1; $count <= $subject_count+1; $count++) {
							echo "<option value=\"{$count}\"";
							if ($sel_subject['position'] == $count) {
								echo " selected";
							}
							echo ">{$count}</option>";
						}
					?>                    	
                    </select>
                </p>
                <p>Visible:
                	<input type="radio" name="visible" value="0"<?php if ($sel_subject['visible'] == 0) { echo " checked"; } ?> /> No
                    &nbsp;
                    <input type="radio" name="visible" value="1"<?php if ($sel_subject['visible'] == 1) { echo " checked"; } ?>/> Yes
                </p>
                <input type="submit" name="submit" value="Edit Subject" />
                &nbsp;&nbsp;
                <a href="delete_subject.php?subj=<?php echo urlencode($sel_subject['id']); ?>" onclick="return confirm('Delete Subject, are you sure?');">Delete Subject</a>&nbsp;&nbsp;<a href="content.php">Cancel Editing</a>  
            </form>
            <p><hr />
            <a href="new_page.php?subj=<?php echo urlencode($sel_subject['id']); ?>">+ Add a new page to <?php echo $sel_subject['menu_name']; ?>.</a>
            <br />
              <br />
                        </p>
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