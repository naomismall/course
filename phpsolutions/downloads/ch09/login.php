<?php
// process the script only if the form has been submitted
if (array_key_exists('login', $_POST)) {
  // start the session
  session_start();
  // include nukeMagicQuotes and clean the $_POST array
  include('../includes/corefuncs.php');
  nukeMagicQuotes();
  $textfile = 'C:/private/filetest03.txt';
    if (file_exists($textfile) && is_readable($textfile)) {
    // read the file into an array called $users
    $users = file($textfile);

    // loop through the array to process each line
    for ($i = 0; $i < count($users); $i++) {
      // separate each element and store in a temporary array
      $tmp = explode(', ', $users[$i]);
      // assign each element of the temp array to a named array key
      $users[$i] = array('name' => $tmp[0], 'password' => rtrim($tmp[1]));
	  // check for a matching record
	  if ($users[$i]['name'] == $_POST['username'] && $users[$i]['password'] == $_POST['pwd']) {
	  // alternative (shorter) code
	  //if ($tmp[0] == $_POST['username'] && rtrim($tmp[1]) == $_POST['pwd']) {
	    // if there's a match, set a session variable
	    $_SESSION['authenticated'] = 'Jethro Tull';
		break;
		}
      }
	// if the session variable has been set, redirect
	if (isset($_SESSION['authenticated'])) {
	  header('Location: http://localhost/phpsolutions/sessions/menu.php');
	  exit;
	  }
	// if the session variable hasn't been set, refuse entry
	else {
	  $error = 'Invalid username or password.';
	  }
    }
  // error message to display if text file not readable
  else {
    $error = 'Login facility unavailable. Please try later.';
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
?>
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
