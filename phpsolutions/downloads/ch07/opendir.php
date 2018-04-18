<?php
// open the directory
$folder = opendir('../images');
// initialize an array to store the contents
$files = array();
// loop through the directory
while (false !== ($item = readdir($folder))) {
  $files[] = $item;
  }
// close it
closedir($folder);
?>
<pre>
<?php
print_r($files);
?>
</pre>