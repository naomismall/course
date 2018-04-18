<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Document root test</title>
</head>

<body>
<p>
<?php
if (isset($_SERVER['DOCUMENT_ROOT'])) {
  echo 'Supported. The server root is '.$_SERVER['DOCUMENT_ROOT'];
  }
else {
  echo "\$_SERVER['DOCUMENT_ROOT'] is not supported";
  }
 ?>
</p> 
</body>
</html>
