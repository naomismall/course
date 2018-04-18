<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Read text into an array</title>
</head>

<body>
<?php
// read the file into an array called $users
$users = file('C:/private/filetest03.txt');

// loop through the array to process each line
for ($i = 0; $i < count($users); $i++) {
  // separate each element and store in a temporary array
  $tmp = explode(', ', $users[$i]);
  // assign each element of the temporary array to a named array key
  $users[$i] = array('name' => $tmp[0], 'password' => $tmp[1]);
  }
?>
<pre>
<?php print_r($users); ?>
</pre>
</body>
</html>
