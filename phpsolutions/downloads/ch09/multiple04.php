<?php
session_start();
if (!isset($_SESSION['formStarted'])) {
  header('Location: http://localhost/phpsolutions/sessions/multiple01.php');
  exit;
  }
############################################
# No need to clean the $_POST array        #
# Everything is now in the $_SESSION array #
############################################
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Multiple form 4</title>
</head>

<body>
<p>The details submitted were as follows: </p>
<ul>
<?php
// unset the formStarted variable
unset($_SESSION['formStarted']);
foreach ($_SESSION as $key => $value) {
  // skip the submit buttons
  // use identity operator with strpos to prevent false negatives
  if (strpos($key, 'Submit') === 0) {
	continue;
	}
  echo "<li>$key: $value</li>";
  }
  // clear the $_SESSION array and destroy session
  $_SESSION = array();
  session_destroy();
?>
</ul>
</body>
</html>
