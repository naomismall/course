<?php
// open the file in read-only mode
$file = fopen('C:/private/filetest03.txt', 'r');
// create variable to store the contents
$contents = '';
// loop through each line until end of file
while (!feof($file)) {
  // retrieve next line, and add to $contents
  $contents .= fgets($file);
  }
// close the file
fclose($file);
// display the contents
echo nl2br($contents);
?>