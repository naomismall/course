<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Date formatting with PHP</title>
</head>

<body>
<?php ini_set('date.timezone', 'Europe/London'); ?>
<p>American style: <?php echo date('l, F jS, Y'); ?></p>
<p>European style: <?php echo date('l, jS F Y'); ?></p>
</body>
</html>
