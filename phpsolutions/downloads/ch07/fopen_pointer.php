<?php
// if the form has been submitted, process the input text
if (array_key_exists('putContents', $_POST)) {
  // strip backslashes from the input text and save to shorter variable
  $contents = get_magic_quotes_gpc() ? stripslashes($_POST['contents']) : $_POST['contents'];
  
  $filename = 'C:/private/filetest05.txt';
  // open a file for reading and writing
  $file = fopen($filename, 'r+');
  
  // the pointer is at the beginning, so existing content is overwritten
  // uncomment the next line to move the pointer to the end
  // fseek($file, 0, SEEK_END);
  fwrite($file, $contents);
  
  // read the contents from the current position
  $readRest = '';
  while (!feof($file)) {
    $readRest .= fgets($file);
	}
  
  // reset internal pointer to the beginning
  rewind($file);
  // read the contents from the beginning (nasty gotcha here)
  // file has not been closed, so filesize refers to original size
  $readAll = fread($file, filesize($filename));
  
  // uncomment the next four lines when adding content at end
  // $readAll = '';
  // while (!feof($file)) {
  //   $readAll .= fgets($file);
  //   }

  // pointer now at the end, so write the form contents again
  fwrite($file, $contents);
  
  // read immediately without moving the pointer
  $readAgain = '';
  while (!feof($file)) {
    $readAgain .= fgets($file);
	}
  
  // close the file
  fclose($file);
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Moving the pointer</title>
</head>

<body>
<?php
if (isset($readRest)) {
  echo "<p><strong>Read after first write operation:</strong> $readRest</p>";
  echo "<p><strong>Read after rewinding pointer:</strong> $readAll</p>";
  echo "<p><strong>Read after second write operation:</strong> $readAgain</p>";
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
