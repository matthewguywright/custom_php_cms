<?php require_once("includes/sessions.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/dbconnection.php"); ?>
<?php require_once("includes/top.php"); ?>
<?php
$message = '';
if (isset($_SESSION['username'])) {
		//logged in
		header("Location: staff.php");
		exit;
	}

//This area checks for username 
if (isset($_POST['submit'])) {
	//perform validations of the form data
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$hashed_password = sha1($password);
	$query = "SELECT * ";
	$query .= "FROM users ";
	$query .= "WHERE username = '$username' ";
	$query .= "AND hashed_password = '$hashed_password' ";

	$Result = mysql_query($query);
	if (mysql_num_rows($Result) == 1) {
		$found_user = mysql_fetch_array($Result);
		
		//storing session variables
		$_SESSION['user_id'] = $found_user['id'];
		$_SESSION['username'] = $found_user['username'];
		redirect_to("staff.php");
	} else {
		$message = "<p style=\"color: #FF9933\">Username and Password combination was incorrect. Please make sure the caps lock key is off and try again.</p>";
		$username = "";
		$password = "";
		}
} else {
		$username = "";
		$password = "";
}
?>
    <h2>User Login</h2>
        <div id="staffnavbar">
<p>
<?php echo $message; ?>
<form action="index.php" method="post">
                <div align="left">Username: 
                  <input name="username" type="text" id="username" size="30" maxlength="30" value="<?php echo htmlentities($username); ?>" />
                  <br />
                  <br />
  				Password: 
  				<input name="password" type="password" id="password" size="30" maxlength="30" value="<?php echo htmlentities($password); ?>" />
  				</p>
                <br />
                <br />
                <center><!--<a href="index.php?q=forgotpw">Forgot Password (Code Me)</a>&nbsp; &nbsp;--><input type="submit" name="submit" id="login" value="Login" />
                  <br />
                </center>
                </div>
</form>
</p>
        </div> <!--ENDS STAFFNAVBAR-->
</div> <!--ENDS CONTENT_MAIN-->

<div id="content_sub"> 
    <a href="/">Back to Website</a>
</div> <!--ENDS CONTENT_SUB-->    
<?php require_once("includes/site_info.php"); ?>