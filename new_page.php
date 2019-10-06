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
	$subjectid = $_GET['subj'];
	find_selected_page();
?>
<?php require_once("includes/top.php"); ?>
    	<div id="contentLoad">
			<h2>Add Page</h2>
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
            <form action="create_page.php?subj=<?php echo urlencode($subjectid); ?>" method="post">
            	<p>Page name:
                	<input type="text" name="menu_name" value="Enter Page Name Here" id="menu_name" />
                </p>
            	<p>Position:
                	<select name="position">
                    <?php
						$page_set = get_all_pages();
						$page_count = mysql_num_rows($page_set);
						for($count=1; $count <= $page_count+1; $count++) {
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
                  <br />
                </p>
                <table width="400" border="0" cellspacing="0" cellpadding="0" summary="Page Menu">
                  <tr>
                    <td width="30%"><div align="center"><a href="content.php">Cancel New Page</a></div></td>
                    <td width="70%"><div align="center">
                      <input type="submit" value="Submit New Page" onclick="return confirm('Make sure that all fields are completely filled out.  Continue?');"/>
                    </div></td>
                  </tr>
                </table>
                <br />
              <textarea name="update" cols="80" rows="40" id="update" style="width: 90%">Enter page content here.  If you want to use HTML, click on the "HTML" button in the menu above.  To add an image, just click the "INSERT IMAGE" button and browse to or upload the image.</textarea>
              <br />
              <br />
        </form>
            </div> 
    	<!--ENDS CONTENTLOAD-->
	</div> <!--ENDS CONTENT_MAIN-->

	<div id="content_sub">
<?php echo navigation($sel_subject, $sel_page); ?>
	<br />
    <a href="content.php">Back</a>
    <br />
    <a href="logout.php">Logout</a>
	</div> <!--ENDS CONTENT_SUB-->    
<?php require_once("includes/site_info.php"); ?>