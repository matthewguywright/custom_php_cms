<?php require_once("includes/sessions.php"); ?>
<?php require_once("includes/dbconnection.php"); ?>
<?php
	if (!isset($_SESSION['username'])) {
		header("Location: index.php");
		exit;
	}
?>
<?php
	switch ($_GET['q']) {
		case "error":
			$message = 'Cannot delete currently logged in user!';
		break;
		case "delete":
			$message = 'The user was deleted!';
		break;
		default:
			$message = '';
	}
?>
<?php
	//Processing
	//EMAIL CHECK
	if (isset($_POST['emailsubmit'])) {
	// Email address validation
	$emailPattern = "/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i";
	
		if (!preg_match($emailPattern, $_POST['email'])) {
     		$message = "---A Valid Email Address is Required! No updates were made!---";
		} else {
			$email = $_POST['email'];
			$sql = "UPDATE email SET email = '$email' ";
			$EmailResult = mysql_query($sql);
			$message = "Your E-mail Address has been changed!";
		}
	}
?>
<?php
//CREATE NEW USER
	if (isset($_POST['newusersubmit'])) {
		//REQUIRED FIELDS
		$required_fields = array('username', 'password');
		foreach($required_fields as $fieldname) {
		if (($_POST[$fieldname]) == NULL) {
			$Errors[] = $fieldname;
		}
	}
	
	if (isset($Errors)) {
		foreach ($Errors as $Value) {
			if (($Value) == 'username') {
				$message = "---Username and password are required!---";
			} elseif (($Value) == 'password') {
				$message = "---Username and password are required!---";
			}
			}
		}
	}
	
	if (isset($_POST['newusersubmit']) && (($Errors) == NULL) && (strlen($_POST['password']) >= 6)) {
		$submitusername = $_POST['username'];
		$submitpassword = $_POST['password'];
		$sql = "INSERT INTO users (username, hashed_password) VALUES ('$submitusername', SHA1('$submitpassword')) ";
		$result = mysql_query($sql);
		$message = "The new user was added!";
	} elseif (isset($_POST['newusersubmit']) && (($_POST['submitpassword']) == NULL)) {
		$message = "---The user was not added, username and password are required!---<br />---Password must contain atleast 6 characters!---";
	
	}
?>
<?php
//CHANGE PASSWORD CHECK FOR 6 CHARACTERS ATLEAST
	if (isset($_POST['submitpassword'])) {
		if ((strlen($_POST['changepw']) >= 6)) {
		//SQL
		$password = $_POST['changepw'];
		$sql = "UPDATE users SET hashed_password = SHA1('$password') WHERE username = '$_SESSION[username]' ";
		$PwResult = mysql_query($sql); 
		//ECHO SUCCESS
		$message = "Your password has been successfully changed!";
		} else {
		$message = "---Password must contain atleast 6 characters, password was not changed!---";
		}
	}
?>
<?php require_once("includes/top.php"); ?>
    <h2>Global Settings:</h2>
    <?php if (isset($message)) { echo "<p style=\"color: red\">" . $message . "</p>"; } ?>
    <div id="staffnavbar">
            <ul id="staff_nav">
              <table width="600" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td valign="top"><div align="right" style="font-weight: bold">
                    <div align="left">E-Mail Address:</div>
                  </div></td>
                  <td width="568" bgcolor="#FFFFFF"><form id="emailchange" name="emailchange" method="post" action="new_user.php">
                      <label for="email">This is the email used for the questions/comments section of the website. There will only be one. This does not pertain to individual users, only to the global e-mail setting that will be used as the submission email. (Visitors will send questions/comments to this email)<br />
                      <br />
                        New E-Mail Address: </label>
                      <input name="email" type="text" id="email" size="35" maxlength="35" /><br />
                      <?php if (isset($emailerror)) { echo $emailerror; } ?><br />
                    <?php $sql = "SELECT * FROM email"; $result = mysql_query($sql); $row = mysql_fetch_assoc($result); ?>
                    Current E-Mail Address: <?php echo $row['email']; ?><br />
                    <br />
                    <center>
                      <input type="submit" name="emailsubmit" id="emailsubmit" value="Submit New E-Mail Address" onclick="return confirm('Change e-mail address, are you sure?')"/>
                      <br />
                      <br />
                    </center>
                  </form></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right" style="font-weight: bold">
                    <div align="left">Users:</div>
                  </div></td>
                  <td bgcolor="#FFFFFF"><form id="newadmin" name="newadmin" method="post" action="new_user.php">
                      <label for="username">This field allows you to add additional users to your admin list. Anyone added here will have full admin privelages such as deleting and creating new users.<br />
                      <br />
                        Username: </label>
                      <input name="username" type="text" id="username" size="25" maxlength="25" />
                      <br />
                      <br />
                      <label for="password">Password: </label>
                      <input name="password" type="text" id="password" size="25" maxlength="25" /><br />
                      <?php if (isset($newusererror)) { echo $newusererror; } ?><br />
                      <center>
                        <p>
                          <input type="submit" name="newusersubmit" id="newusersubmit" value="Create New Admin User" onclick="return confirm('Create new user, are you sure?')"/>
                        </p>
                      </center>
                  </form></td>
                </tr>
                <tr>
                  <td align="right" valign="top"><div align="right" style="font-weight: bold">
                    <div align="left">Change Password:</div>
                  </div></td>
                  <td align="left" valign="top"><form action="new_user.php" method="post" enctype="multipart/form-data" name="form2" id="form2">
                      <label for="changepw"></label>
                      <div align="left">
                        <p>
                          <input name="changepw" type="text" id="changepw" size="35" maxlength="50" />
                          <input type="submit" name="submitpassword" id="submitpassword" value="Update Password" />
                          <br />
                        </p>
                        <center>
                        </center>
                      </div>
                  </form></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right" style="font-weight: bold">
                    <div align="left">Current Users:</div>
                  </div></td>
                  <td><table>
                      <tr>
                        <th width="75" class="style3" id="delete"><div align="center">Delete</div></th>
                        <th width="447" id="name"><div align="left">Username</div></th>
                      </tr>
                      <?php
		$query = "SELECT * FROM users";
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result) ) {
			?>
                      <tr>
                        <td><div align="center"><a href="deleteuser.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete user, are you sure?')">delete</a></div></td>
                        <td><?php echo $row['username']; ?> </td>
                      </tr>
                      <?php
		}
	?>
                  </table></td>
                </tr>
              </table>
            </ul>
        </div> <!--ENDS STAFFNAVBAR-->
</div> <!--ENDS CONTENT_MAIN-->

<div id="content_sub"> 
    <a href="staff.php">Back to Main Menu</a>
</div> <!--ENDS CONTENT_SUB-->    
<?php require_once("includes/site_info.php"); ?>