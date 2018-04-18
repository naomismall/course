<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Multiple file upload</title>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data" name="multiUpload" id="multiUpload">
    <p>
        <label for="image1">File 1:</label>
        <input type="file" name="image[]" id="image1" />
    </p>
    <p>
        <label for="image2">File 2:</label>
        <input type="file" name="image[]" id="image2" />
    </p>
    <p>
        <input name="upload" type="submit" id="upload" value="Upload files" />
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
