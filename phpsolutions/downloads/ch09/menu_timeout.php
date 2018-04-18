<?php
session_start();
ob_start();
// set a time limit in seconds
$timelimit = 15;
// get the current time
$now = time();
// where to redirect if rejected
$redirect = 'http://localhost/phpsolutions/sessions/login.php';
// if session variable not set, redirect to login page
if (!isset($_SESSION['authenticated'])) {
  header("Location: $redirect");
  exit;
  }
// if timelimit has expired, destroy session and redirect
elseif ($now > $_SESSION['start'] + $timelimit) {
  // empty the $_SESSION array
  $_SESSION = array();
  // invalidate the session cookie
  if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-86400, '/');
  }
  // end session and redirect with query string
  session_destroy();
  header("Location: {$redirect}?expired=yes");
  exit;
  }
// if it's got this far, it's OK, so update start time
else {
  $_SESSION['start'] = time();
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
<?php include('../includes/logout.inc.php'); ?>
</body>
</html>
