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
    $result = 'No image selected';
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
	// strip the extension off the image filename
	$imagetypes = array('/\.gif$/', '/\.jpg$/', '/\.jpeg$/', '/\.png$/');
    $name = preg_replace($imagetypes, '', basename($original));
	
	// create an image resource for the original
	switch($type) {
      case 1:
        $source = @ imagecreatefromgif($original);
	    if (!$source) {
	      $result = 'Cannot process GIF files. Please use JPEG or PNG.';
	      }
	    break;
      case 2:
        $source = imagecreatefromjpeg($original);
	    break;
      case 3:
        $source = imagecreatefrompng($original);
	    break;
      default:
        $source = NULL;
	    $result = 'Cannot identify file type.';
      }
	// make sure the image resource is OK
	if (!$source) {
	  $result = 'Problem copying original';
	  }
	else {
	  // calculate the dimensions of the thumbnail
      $thumb_width = round($width * $ratio);
      $thumb_height = round($height * $ratio);
	  // create an image resource for the thumbnail
      $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
	  // create the resized copy
	  imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
	  // save the resized copy
	  switch($type) {
        case 1:
	      if (function_exists('imagegif')) {
	        $success = imagegif($thumb, THUMBS_DIR.$name.'_thb.gif');
	        $thumb_name = $name.'_thb.gif';
		    }
	      else {
	        $success = imagejpeg($thumb, THUMBS_DIR.$name.'_thb.jpg', 50);
		    $thumb_name = $name.'_thb.jpg';
		    }
	      break;
	    case 2:
	      $success = imagejpeg($thumb, THUMBS_DIR.$name.'_thb.jpg', 100);
	      $thumb_name = $name.'_thb.jpg';
	      break;
	    case 3:
	      $success = imagepng($thumb, THUMBS_DIR.$name.'_thb.png');
	      $thumb_name = $name.'_thb.png';
	    }
		if ($success) {
		  $result = "$thumb_name created";
		  }
	  // remove the image resources from memory
	  imagedestroy($source);
      imagedestroy($thumb);
	  }
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
<?php
if (isset($result)) {
  echo "<p>$result</p>";
  }
?>
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
