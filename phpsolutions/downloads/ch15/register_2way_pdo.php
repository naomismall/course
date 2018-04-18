<?php
// execute script only if form has been submitted
if (array_key_exists('register', $_POST)) {
  // remove backslashes from the $_POST array
  include('../includes/corefuncs.php');
  include('../includes/conn_pdo.inc.php');
  nukeMagicQuotes();
  // check length of username and password
  $username = trim($_POST['username']);
  $pwd = trim($_POST['pwd']);
  // initialize error array
  $message = array();
  // check length of username
  if (strlen($username) < 6 || strlen($username) > 15) {
    $message[] = 'Username must be between 6 and 15 characters';
	}
  // validate username
  if (!ctype_alnum($username)) {
    $message[] = 'Username must consist of alphanumeric characters with no spaces';
	}
  // check password
  if (strlen($pwd) < 6 || preg_match('/\s/', $pwd)) {
    $message[] = 'Password must be at least 6 characters with no spaces';
	}
  // check that the passwords match
  if ($pwd != $_POST['conf_pwd']) {
    $message[] = 'Your passwords don\'t match';
	}
  // if no errors so far, check for duplicate username
  if (!$message) {
    // connect to database as administrator
	$conn = dbConnect('admin');
	// check for duplicate username
    $checkDuplicate = "SELECT COUNT(*) FROM users_2way
	                   WHERE username = '$username'";
	$result = $conn->query($checkDuplicate);
	$numRows = $result->fetchColumn();
	// release database resource for next query
	$result->closeCursor();
	// if $numRows is positive, the username is already in use
	if ($numRows) {
	  $message[] = "$username is already in use. Please choose another username.";
	  }
	// otherwise, it's OK to insert the details in the database
	else {
	  // create key
	  $key = 'takeThisWith@PinchOfSalt';
	  // insert details into database
	  $insert = "INSERT INTO users_2way (username, pwd)
	             VALUES ('$username', AES_ENCRYPT('$pwd', '$key'))";
	  $result = $conn->query($insert);
	  if ($result) {
	    $message[] = "Account created for $username";
		}
	  else {
	    $message[] = "There was a problem creating an account for $username";
		}
	  }
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Register user</title>
</head>

<body>
<h1>Register user</h1>
<?php
if (isset($message)) {
  echo '<ul>';
  foreach ($message as $item) {
    echo "<li>$item</li>";
	}
  echo '</ul>';
  }
?>
<form id="form1" name="form1" method="post" action="">
    <p>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" />
    </p>
    <p>
        <label for="pwd">Password:</label>
        <input type="password" name="pwd" id="pwd" />
    </p>
    <p>
        <label for="conf_pwd">Confirm password:</label>
        <input type="password" name="conf_pwd" id="conf_pwd" />
    </p>
    <p>
        <input name="register" type="submit" id="register" value="Register" />
    </p>
</form>
</body>
</html>
