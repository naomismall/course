<?php
function dbConnect($type) {
  if ($type  == 'query') {
    $user = 'psquery';
	$pwd = 'fuji';
	}
  elseif ($type == 'admin') {
    $user = 'psadmin';
	$pwd = 'kyoto';
	}
  else {
    exit('Unrecognized connection type');
	}
  $conn = mysql_connect('localhost', $user, $pwd) or die ('Cannot connect to server');
  mysql_select_db('phpsolutions') or die ('Cannot open database');
  return $conn;
  }
?>