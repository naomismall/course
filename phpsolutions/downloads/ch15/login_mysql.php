<?php
// process the script only if the form has been submitted
if (array_key_exists('login', $_POST)) {
  // start the session
  session_start();
  include('../includes/corefuncs.php');
  include('../includes/conn_mysql.inc.php');
  // clean the $_POST array and assign to shorter variables
  nukeMagicQuotes();
  $username = trim($_POST['username']);
  $pwd = trim($_POST['pwd']);
  // connect to the database as a restricted user
  $conn = dbConnect('query');
  // prepare username for use in SQL query
  $username = mysql_real_escape_string($username);
  // get the username's details from the database
  $sql = "SELECT * FROM users WHERE username = '$username'";
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);
  // use the salt to encrypt the password entered in the form
  // and compare it with the stored version of the password
  // if they match, set the authenticated session variable 
  if (sha1($pwd.$row['salt']) == $row['pwd']) {
    $_SESSION['authenticated'] = 'Jethro Tull';
	}
  // if no match, destroy the session and prepare error message
  else {
    $_SESSION = array();
	session_destroy();
	$error = 'Invalid username or password';
	}
  // if the session variable has been set, redirect
  if (isset($_SESSION['authenticated'])) {
	// get the time the session started
	$_SESSION['start'] = time();
	header('Location: http://localhost/phpsolutions/authenticate/menu.php');
	exit;
	}
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>
</head>

<body>
<?php
if (isset($error)) {
  echo "<p>$error</p>";
  }
elseif (isset($_GET['expired'])) {
?>
  <p>Your session has expired. Please log in again.</p>
<?php } ?>
<form id="form1" name="form1" method="post" action="">
    <p>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" />
    </p>
    <p>
        <label for="textfield">Password</label>
        <input type="password" name="pwd" id="pwd" />
    </p>
    <p>
        <input name="login" type="submit" id="login" value="Log in" />
    </p>
</form>
</body>
</html>
