<?php
// if the form has been submitted, process the input text
if (array_key_exists('putContents', $_POST)) {
  // strip backslashes from the input text and save to shorter variable
  $contents = get_magic_quotes_gpc() ? stripslashes($_POST['contents']) : $_POST['contents'];
  
  // open the file in write-only mode
  $file = fopen('C:/private/filetest04.txt', 'w');
  // write the contents
  fwrite($file, $contents);
  // close the file
  fclose($file);
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Write only</title>
</head>

<body>
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
