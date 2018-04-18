<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Simple function with argument - no return value</title>
</head>

<body>
<?php
function sayHi($name) {
  echo "Hi, $name!";
  }
$visitor = 5;
sayHi($visitor);
?>
</body>
</html>
