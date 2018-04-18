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
  $conn = new mysqli('localhost', $user, $pwd, 'phpsolutions') or die ('Cannot open database');
  return $conn;
  }
?>