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
	if (intval($_GET['page']) == 0) {
		//redirect
		redirect_to("content.php");
	}
	if (isset($_POST['submit'])) {
		$errors = array();
		
		//FORM VALIDATION //,'visible'
		$required_fields = array('menu_name','position', 'update');
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
		
		//CLEAN UP FORM DATA
		$id = mysql_prep($_GET['page']);		
		$sql = "SELECT * FROM pages WHERE id = '$id' ";
		$result = mysql_query($sql, $dbconnect);
		$row = mysql_fetch_assoc($result);
			
		$subjectid = $row['subject_id'];	
		$menu_name = trim(mysql_prep($_POST['menu_name']));
		$position = mysql_prep($_POST['position']);
		$visible = mysql_prep($_POST['visible']);
		$content = mysql_prep($_POST['update']);	
		
		//DATABASE SUBMISSION
		if (empty($errors)) {
			$query = "UPDATE pages SET menu_name = '$menu_name', subject_id = '$subjectid', position = '$position', visible = '$visible', content = '{$content}' WHERE id = '$id' "; 
			$result = mysql_query($query, $dbconnect);
			//TEST FOR ROW AFFECTED
			if (mysql_affected_rows() == 1) {
				//Success
				$message = "The page was successfully updated.";
			} else {
				$message = "No updates were made.";
				$message .= "<br />" . mysql_error();
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		} //END FORM PROCESSING
	}
?>
<?php find_selected_page(); ?>
<?php require_once("includes/top.php"); ?>
    	<div id="contentLoad">
			<h2>Edit Page: <?php echo $sel_page['menu_name']; ?></h2>
            
            <?php
				if (!empty($message)) {
					echo "<p class=\"message\">" . $message . "</p>";
				}
			?>
<script language="javascript" type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript" language="javascript">
	tinyMCE.init({
    theme : "advanced",
    plugins : "safari,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,pagebreak,imagemanager",
	mode: "exact",
    elements : "update",	
    theme_advanced_buttons1_add_before : "save,newdocument,separator",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "emotions,iespell,media,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,spellchecker,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		content_css : "css/main.css",
	    plugin_insertdate_dateFormat : "%Y-%m-%d",
	    plugin_insertdate_timeFormat : "%H:%M:%S",
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js",
		template_external_list_url : "example_data/example_template_list.js",
		theme_advanced_resize_horizontal : true,
		theme_advanced_resizing : true,
		apply_source_formatting : true
  });
</script>            
            <form action="edit_page.php?page=<?php echo urlencode($sel_page['id']); ?>" method="post">
            	<p>Page name:
                	<input type="text" name="menu_name" value="<?php echo $sel_page['menu_name']; ?>" id="menu_name" />
                </p>
            	<p>Position:
                	<select name="position">
                    <?php
						$page_set = get_all_pages();
						$page_count = mysql_num_rows($page_set);
						for($count=1; $count <= $page_count+1; $count++) {
							echo "<option value=\"{$count}\"";
							if ($sel_page['position'] == $count) {
								echo " selected";
							}
							echo ">{$count}</option>";
						}
					?>                    	
                    </select>
                </p>
              <p>Visible:
                	<input type="radio" name="visible" value="0"<?php if ($sel_page['visible'] == 0) { echo " checked"; } ?> /> No
                    &nbsp;
                    <input type="radio" name="visible" value="1"<?php if ($sel_page['visible'] == 1) { echo " checked"; } ?>/> Yes
                <br />
              <table width="400" border="0" cellspacing="0" cellpadding="0" summary="Page Menu">
                  <tr>
                    <td width="33%"><div align="center"><a href="content.php">Cancel Editing</a></div></td>
                    <td width="33%"><div align="center">
                      <input type="submit" name="submit" value="Update Page" />
                    </div></td>
                    <td width="33%"><div align="center"><a href="delete_page.php?page=<?php echo urlencode($sel_page['id']); ?>" onclick="return confirm('Delete Page, are you sure?');">Delete Page</a>&nbsp;</div></td>
                  </tr>
              </table>
                <br />
                </p>
<div align="left">
                  <?php
					$id = $sel_page['id'];
					$sql = "SELECT * FROM pages WHERE id='$id'";
					$result = mysql_query($sql, $dbconnect);
					$row = mysql_fetch_assoc($result);
				?>
                  
                  <textarea id="update" name="update" rows="40" cols="80" style="width: 80%"> 
				  <?php echo $row['content']; ?></textarea>
                  <br />
                  <!--TO ADD TINYMCE, YOU MUST DELETE THE SUBMIT BUTTON BELOW-->
                  
              </div>
            </form>
            <br />
            
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
	