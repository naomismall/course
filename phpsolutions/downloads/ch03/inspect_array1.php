<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Inspecting an array with print_r()</title>
</head>

<body>
<?php
$book = array('title'     => 'PHP Solutions: Dynamic Web Design Made Easy',
              'author'    => 'David Powers',
              'publisher' => 'friends of ED',
              'ISBN'      => '1-59059-731-1');
print_r($book);
?>
</body>
</html>
