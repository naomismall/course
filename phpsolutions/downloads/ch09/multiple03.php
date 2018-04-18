<?php
session_start();
if (!isset($_SESSION['formStarted'])) {
  header('Location: http://localhost/phpsolutions/sessions/multiple01.php');
  exit;
  }
// each page needs a different name for the submit button
if (array_key_exists('Submit3', $_POST)) {
  // set required fields
  // must be an array, even if only one item is required
  // if no fields are required, an empty array is needed
  // otherwise, in_array() later in the script will generate an error
  $required = array('address');
  // create empty array for any missing fields
  $missing = array();
  
  // process the $_POST variables and save them in the $_SESSION array
  foreach ($_POST as $key => $value) {
    // assign to temporary variable and strip whitespace if not an array
    $temp = is_array($value) ? $value : trim($value);
	// if empty and required, add to $missing array
	if (empty($temp) && in_array($key, $required)) {
	  array_push($missing, $key);
	  }
	// otherwise, assign to a variable of the same name as $key
	else {
	  $_SESSION[$key] = $temp;
	  }
	}
  // if no required fields are missing, redirect to next page
  if (!$missing) {
    header('Location: http://localhost/phpsolutions/sessions/multiple04.php');
	exit;
	}
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Multiple form 3</title>
</head>

<body>
<?php
if (isset($missing)) {
  echo "<p>$missing[0] missing</p>";
  }
?>
<form id="form1" name="form1" method="post" action="">
    <p>
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" />
    </p>
    <p>
        <input type="submit" name="Submit3" value="Send details" />
    </p>
</form>
</body>
</html>
