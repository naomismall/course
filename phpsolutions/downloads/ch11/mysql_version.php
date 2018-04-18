<?php
// Change the hostname if necessary, and insert your MySQL username and password
$hostname = 'localhost';
$username = '';
$password = '';
$db = mysql_connect($hostname, $username, $password) or die('Cannot connect to database');
$result = mysql_query('SELECT VERSION()') or die(mysql_error());
mysql_close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Get MySQL version</title>
</head>

<body>
<p>Your server is running MySQL <?php echo mysql_result($result, 0); ?>.</p>
</body>
</html>
