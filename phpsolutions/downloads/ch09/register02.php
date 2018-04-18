<?php
// execute script only if form has been submitted
if (array_key_exists('register', $_POST)) {
  // remove backslashes from the $_POST array
  include('../includes/corefuncs.php');
  nukeMagicQuotes();
  // check length of username and password
  $username = trim($_POST['username']);
  $pwd = trim($_POST['pwd']);
  if (strlen($username) < 6 || strlen($pwd) < 6) {
    $result = 'Username and password must contain at least 6 characters';
	}
  // check that the passwords match
  elseif ($pwd != $_POST['conf_pwd']) {
    $result = 'Your passwords don\'t match';
	}
  // continue if OK
  else {
    // encrypt password, using username as salt
    $pwd = sha1($username.$pwd);
    // define filename and open in read-write append mode
    $filename = 'C:/private/encrypted.txt';
    $file = fopen($filename, 'a+');
    // if filesize is zero, no names yet registered
    // so just write the username and password to file
    if (filesize($filename) === 0) {
      fwrite($file, "$username, $pwd");
      }
    // if filesize is greater than zero, check username first
    else {
      // move internal pointer to beginning of file
      rewind($file);
      // loop through file one line at a time
      while (!feof($file)) {
        $line = fgets($file);
        // split line at comma, and check first element against username
        $tmp = explode(', ', $line);
        if ($tmp[0] == $username) {
          $result = 'Username taken - choose another';
          break;
          }
        }
      // if $result not set, username is OK
      if (!isset($result)) {
        // insert line break followed by username, comma, and password
        fwrite($file, "\r\n$username, $pwd");
        $result = "$username registered";
        }
      // close the file
      fclose($file);
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
if (isset($result)) {
  echo "<p>$result</p>";
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
