<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Demonstration of variable scope</title>
</head>

<body>
<?php
function doubleIt($number) {
  $number *= 2;
  echo "$number<br />";
  }
$number = 4;
doubleIt($number);
echo $number;
?>
</body>
</html>
