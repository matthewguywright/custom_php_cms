<?php require_once("includes/sessions.php"); ?>
<?php require_once("includes/dbconnection.php"); ?>
<?php
	if (!isset($_SESSION['username'])) {
		header("Location: index.php");
		exit;
	}
?>
<?php
	if ($_POST['emailsubmit']) {
	$errors = array();
	//FORM VALIDATION
	$required_fields = array('name','subject','message','to','from');
	foreach($required_fields as $fieldname) {
		if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
			$errors[] = $fieldname;
		}
	}
	
	$error = '';
	//Processing
	//EMAIL CHECK
	if (isset($_POST['emailsubmit'])) {
	// Email address validation
	$emailPattern = "/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i";
	
		if (!preg_match($emailPattern, trim($_POST['to']))) {
     		$error .= " The 'to' E-Mail Address is not valid! ";
		} else {
			$to = trim($_POST['to']);
		}
		if (!preg_match($emailPattern, trim($_POST['from']))) {
     		$error .= " The 'from' E-Mail Address is not valid! ";
		} else {
			$from = trim($_POST['from']);
		}
	}
	}
	
	if (empty($error) && isset($_POST['emailsubmit']) && empty($errors)) {
		$subject = $_POST['subject'];
		//Email String-----------------------------------------	
		$msg =  "Name: ".$_POST["name"]."\n";
		$msg .= "Message: ".$_POST["message"]."\n";

		//Mail Header Information
		$recipient = "$to";
		$subject = "$subject";
		$mailheaders = "From:  ".$_POST["from"]."\n";
		$mailheaders .= "Reply-To: ".$_POST["from"]."\n";

		//Send Mail
		mail($recipient, $subject, $msg, $mailheaders);
			if (mail) {
				$message .= " E-Mail was successfully sent! ";
			} else {
				$message .= " E-Mail was not sent! Please try again later. If the problem persists, please contact Webmaster. ";
			}
	}
?>
<?php require_once("includes/top.php"); ?>
<script language="javascript" type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript" language="javascript">
	tinyMCE.init({
    theme : "simple",
	mode: "exact",
    elements : "message",	
		apply_source_formatting : true
  });
</script>
    <h2>Send an E-Mail:</h2>
    <?php if (isset($message)) { echo "<p style=\"color: red\">" . $message . "</p>"; } ?>
    <?php if (isset($error)) { echo "<p style=\"color: red\">" . $error . "</p>"; } ?>
	<?php if (!empty($errors)) { echo "<p style=\"color: red\">Check the Following Fields: "; } ?> 
	<?php
	if (!empty($errors)) {
		foreach($errors as $errorr) {
			echo "<br />".$errorr;	 
		}
	}
	?>
	</p>
    <div id="emailDiv" style="width: 600px">
      <form id="emailform" name="emailform" method="post" action="sendmail.php">
        <label for="to">To:</label>
        <input name="to" type="text" id="to" value="<?php if (!empty($_POST['emailsubmit'])) { print trim($_POST['to']); } ?>" size="40" />
        <br />
        <br />
        <label for="name">Your Name:</label>
        <input name="name" type="text" id="name" value="<?php if (!empty($_POST['emailsubmit'])) { print $_POST['name']; } ?>" size="40" />
        <br />
        <br />
          <label for="from">From:</label>
                        <input name="from" type="text" id="from" value="<?php if (!empty($_POST['emailsubmit'])) { print trim($_POST['from']); } ?>" size="40" />
                        <br />
                        <br />
          <label for="subject">Subject:</label>
                        <input name="subject" type="text" id="subject" value="<?php if (!empty($_POST['emailsubmit'])) { print $_POST['subject']; } ?>" size="40" />
                        <br />
                        <br />
          <label for="label">Message:</label>
                        <br />
                        <label for="message"></label>
                        <textarea name="message" id="message" cols="70" rows="5"><?php if (!empty($_POST['emailsubmit'])) { print $_POST['message']; }?></textarea>
                        <br />
                        This form supports single E-Mail entries only. It does not yet support multiple recipients. If you add multiple E-Mails, it will not work properly.<br />
                        <br />
                        <label for="emailsubmit"></label>
                        <center><input type="submit" name="emailsubmit" id="emailsubmit" value="Send E-Mail" onclick="return confirm('Send E-Mail, are you sure?');"/>
                        </center>
      </form>
      </div>
    <!--ENDS STAFFNAVBAR-->
</div> <!--ENDS CONTENT_MAIN-->

<div id="content_sub"> 
    <a href="staff.php">Back to Main Menu</a>
</div> <!--ENDS CONTENT_SUB-->    
<?php require_once("includes/site_info.php"); ?>