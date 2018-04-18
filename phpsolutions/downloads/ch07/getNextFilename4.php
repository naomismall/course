<?php
function getNextFilename4($dir, $prefix, $type) {
  // run some security checks on the arguments supplied
  if (!is_dir($dir)) return false;
  if (!preg_match('/^[-._a-z0-9]+$/i', $prefix)) return false;
  $permittedTypes = array('txt', 'doc', 'pdf', 'jpg', 'jpeg', 'gif', 'png');
  if (!in_array(strtolower($type), $permittedTypes)) return false;
  
  // if the checks are OK, get an array of the directory contents
  // start by creating an array to store the directory contents
  $existing = array();
  // open the directory
  $theDir = opendir($dir);
  // loop through it to populate the $existing array
  while (false !== ($item = readdir($theDir))) {
    $existing[] = $item;
	}
  // close the directory
  closedir($theDir);
  // create a search pattern for filenames that match the prefix and type
  $pattern = '/^'.$prefix.'(\d+)\.'.$type.'$/i';
  $nums = array();
  // loop through the directory
  // get the numbers from all files that match the pattern 
  foreach ($existing as $file) {
    if (preg_match($pattern, $file, $m)) {
	  $nums[] = intval($m[1]);
	  }
	}
  // find the highest number and increase it by 1
  // if no file yet created, assign it number 1
  $next = $nums ? max($nums)+1 : 1;
  // calculate how many zeros to prefix the number with
  if ($next < 10) {
    $zeros = '00';
	}
  elseif ($next < 100) {
    $zeros = '0';
	}
  else {
    $zeros = '' ;
	}
  // return the next filename in the series
  return "{$prefix}{$zeros}{$next}.{$type}";
  }
?>