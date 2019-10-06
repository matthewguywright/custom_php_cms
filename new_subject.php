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
			<h2>Add Subject</h2>
            <form action="create_subject.php" method="post">
            	<p>Subject name:
                	<input type="text" name="menu_name" value="Enter Subject Here" id="menu_name" />
                </p>
            	<p>Position:
                	<select name="position">
                    <?php
						$subject_set = get_all_subjects();
						$subject_count = mysql_num_rows($subject_set);
						for($count=1; $count <= $subject_count+1; $count++) {
							echo "<option value=\"{$count}\">{$count}</option>";
						}
					?>                    	
                    </select>
                </p>
                <p>Visible:
                	<input type="radio" name="visible" value="0"  /> No
                    &nbsp;
                    <input name="visible" type="radio" value="1" checked="checked" />
                  Yes
                </p>
                <input type="submit" value="Add Subject" />&nbsp; &nbsp; <a href="content.php">Cancel Add Subject</a>
            </form>
            <br />
           
        </div> <!--ENDS CONTENTLOAD-->
	</div> <!--ENDS CONTENT_MAIN-->

	<div id="content_sub">
<?php echo navigation($sel_subject, $sel_page); ?>
	<br />
    <a href="content.php">Back</a>
    <br />
    <a href="logout.php">Logout</a>
	</div> <!--ENDS CONTENT_SUB-->    
<?php require_once("includes/site_info.php"); ?>