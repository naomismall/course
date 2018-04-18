<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Page 2</title>
    </head>
    <body>
        <?php
		
		// optionally include navigation here
        
        
				
		?>
		<h1>Page 2</h1>
		<?php
		
		// Output the page 2 content here
        
        //$lines = file('data/proverbs.txt');
        $page2content = file_get_contents('data' . DIRECTORY_SEPARATOR . 'page2text.txt');
		echo '<p>' . $page2content . '</p>';
		?>
    </body>
</html>
