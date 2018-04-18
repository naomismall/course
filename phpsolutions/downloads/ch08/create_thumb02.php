<?php
// execute script only if the form has been submitted
if (array_key_exists('create', $_POST)) {
  // define constants
  define('SOURCE_DIR', 'C:/htdocs/phpsolutions/images/');
  define('THUMBS_DIR', 'C:/upload_test/thumbs/');
  define('MAX_WIDTH', 120);
  define('MAX_HEIGHT', 90);
  
  // get image name and build full pathname
  if (!empty($_POST['pix'])) {
    $original = SOURCE_DIR.$_POST['pix'];
	}
  else {
    $original = NULL;
	}
  // abandon processing if no image selected
  if (!$original) {
    echo 'No image selected';
	}
  // otherwise resize the image
  else {
    // begin by getting the details of the original
    list($width, $height, $type) = getimagesize($original);
	// calculate the scaling ratio
    if ($width <= MAX_WIDTH && $height <= MAX_HEIGHT) {
      $ratio = 1;
      }
    elseif ($width > $height) {
      $ratio = MAX_WIDTH/$width;
      }
    else {
      $ratio = MAX_HEIGHT/$height;
      }
	echo "Image selected: $original<br />";
	echo "Original width: $width<br />Original height: $height<br />";
	echo "Image type: $type<br />Scaling ratio: $ratio";
	}
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
// if using PHP 4, use buildFileList4.php and buildFileList4()
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
