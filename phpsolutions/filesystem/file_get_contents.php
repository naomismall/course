<?php

	
	$contents = file_get_contents('C:/wamp/www/naomi/phpsolutions/downloads/ch07/filetest02.txt');
	if ($contents == false) {
		echo 'Sorry, there was a problem reading the file';
	}
	else {
		// convert contents to uppercase and display
		echo strtoupper($contents);
	}
?>
