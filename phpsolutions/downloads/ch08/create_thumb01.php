<?php
if (array_key_exists('create', $_POST)) {
  // image resizing script goes here
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Create thumbnail image</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
    <p>
        <select name="pix" id="pix">
            <option value="">Select an image</option>
          <?php
include('../includes/buildFileList5.php');
buildFileList5('../images');
?>
        </select>
    </p>
    <p>
        <input name="create" id="create" type="submit" value="Create thumbnail" />
    </p>
</form>
</body>
</html>
