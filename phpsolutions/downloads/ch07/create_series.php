<?php
// if the form has been submitted, process the input text
if (array_key_exists('putContents', $_POST)) {
  include('../includes/getNextFilename5.php'); // use getNextFilename4.php if running on a PHP 4 server
  // strip backslashes from the input text and save to shorter variable
  $contents = get_magic_quotes_gpc() ? stripslashes($_POST['contents']) : $_POST['contents'];
  
  $dir = 'C:/private';
  $filename = getNextFilename5($dir, 'comment', 'txt'); // use getNextFilename4() if running on PHP 4
  if ($filename) {
    // create a file ready for writing only if it doesn't already exist
    if ($file = @ fopen("$dir/$filename", 'x')) {
      // write the contents
      fwrite($file, $contents);
      // close the file
      fclose($file);
      $result = "$filename created";
	  }
	else {
	  $result = 'Cannot create file';
	  }
	}
  else {
    $result = 'Invalid folder or filename';
	}
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Create series of consecutively numbered files</title>
</head>

<body>
<?php
if (isset($result)) {
  echo "<p>$result</p>";
  }
?>
<form id="writeFile" name="writeFile" method="post" action="">
    <p>
        <label for="contents">Write this to file:</label>
        <textarea name="contents" cols="40" rows="6" id="contents"></textarea>
    </p>
    <p>
        <input name="putContents" type="submit" id="putContents" value="Write to file" />
    </p>
</form>
</body>
</html>