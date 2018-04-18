<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Index page</title>
    </head>
    <body>
        <?php
		
		// optionally include navigation here
		
		?>
		<h1>Index page</h1>
		<?php 
		
		// Proverbs
		$lines = file('data/proverbs.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        $random = array_rand($lines, 1);
        
        echo $lines[$random];
        
/* 		foreach ($lines as $line_number => $line) {
			echo '<p>Proverb: ' .$line.'</p>';
		} */

		?>
    </body>
</html>
