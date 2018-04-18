<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>File upload</title>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data" name="uploadImage" id="uploadImage"> 
    <p>
		<label for="image">Upload image:</label>
        <input type="file" name="image" id="image" />
    </p>
    <p>
        <input type="submit" name="upload" id="upload" value="Upload" />
    </p>
</form>
<pre>
<?php
if (array_key_exists('upload', $_POST)) {
  print_r($_FILES);
  }
?>
</pre>
</body>
</html>
