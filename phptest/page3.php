<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Page 3</title>
    </head>
    <body>
        <?php
		
		// optionally include navigation here
				
		?>
		<h1>Page 3</h1>
        <?php
		
		// Output the page 3 content here
        
        $handle = fopen('data/page3text.txt', 'r');
        
        if ($handle) {
        
            while (($line = fgets($handle)) !== false) {
                               
                if (trim($line) != '' ) {
                                    
                    $first_char = substr($line,0,1);
                    
                    if ($first_char == '#') {
                        $line = ltrim($line, '#');
                        echo '<h1>' . $line . '</h1>';
                      
                    }
                    else {
                        
                        echo '<p>' . $line . '</p>';
                    }
                }
            }
            if (!feof($handle)) {
                
                echo "Oops: fgets returned false before end of file";
            }
            fclose($handle);
        }        
				
		?>
    </body>
</html>