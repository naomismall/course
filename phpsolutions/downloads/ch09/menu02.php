<?php
session_start();
// if session variable not set, redirect to login page
if (!isset($_SESSION['authenticated'])) {
  header('Location: http://localhost/phpsolutions/sessions/login.php');
  exit;
  }
// run this script only if the logout button has been clicked
if (array_key_exists('logout', $_POST)) {
  // empty the $_SESSION array
  $_SESSION = array();
  // invalidate the session cookie
  if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-86400, '/');
  }
  // end session and redirect
  session_destroy();
  header('Location: http://localhost/phpsolutions/sessions/login.php');
  exit;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Secret menu</title>
</head>

<body>
<h1>Restricted area</h1>
<p><a href="secretpage.php">Another secret page</a> </p>
<form id="logoutForm" name="logoutForm" method="post" action="">
  <input name="logout" type="submit" id="logout" value="Log out" />
</form>
</body>
</html>
