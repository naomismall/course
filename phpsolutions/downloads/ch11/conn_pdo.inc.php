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
  try {
    $conn = new PDO('mysql:host=localhost;dbname=phpsolutions', $user, $pwd);
    return $conn;
	}
  catch (PDOException $e) {
    echo 'Cannot connect to database';
	exit;
	}
  }
?>