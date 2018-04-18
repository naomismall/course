<?php
if (array_key_exists('upload', $_POST)) {
  // define constant for upload folder
  define('UPLOAD_DIR', 'C:/upload_test/');
  // move the file to the upload folder and rename it
  move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR.$_FILES['image']['name']);
  }
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
</body>
</html>
