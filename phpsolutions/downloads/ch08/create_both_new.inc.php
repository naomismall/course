<?php

/**************************************************
The changes are on lines 10, 41-67, 106, 121 & 130
***************************************************/

  ########################################
  # include the getNextFilename function #
  ########################################
  include('getNextFilename5.php'); // use getNextFilename4.php on a PHP 4 server
  ########################################
  
  // define constants
  define('THUMBS_DIR', 'C:/upload_test/thumbs/');
  define('MAX_WIDTH', 120);
  define('MAX_HEIGHT', 90);
  
  // process the uploaded image
  if (is_uploaded_file($_FILES['image']['tmp_name'])) {
    $original = $_FILES['image']['tmp_name'];
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
    $name = preg_replace($imagetypes, '', basename($_FILES['image']['name']));

	########################################################
	# getNextFilename() requires the file type as a string #
	# so begin by converting it to a string assigned to $t #
	########################################################
	switch($type) {
	  case 1:
	    $t = 'gif';
		break;
	  case 2:
	    $t = 'jpg';
		break;
	  case 3:
	    $t = 'png';
	  }
	################################
	# get new name for upload file #
	################################
	$newName = getNextFilename5(UPLOAD_DIR, $name, $t);  // use getNextFilename4() on a PHP 4 server

	################################################
	# use the new name instead of the existing one #
	################################################
	// move the temporary file to the upload folder
	$moved = move_uploaded_file($original, UPLOAD_DIR.$newName);
	if ($moved) {
	  $result = "$newName successfully uploaded; ";
	  $original = UPLOAD_DIR.$newName;
	  }
	else {
	  $result = 'Problem uploading '.$_FILES['image']['name'].'; ';
	  }
    ################################################

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
		  ######################################################
		  # use the new name as the basis for the thumb's name #
		  ######################################################
		  $name = basename($newName, '.gif');
	      ######################################################
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
		  ######################################################
		  # use the new name as the basis for the thumb's name #
		  ######################################################
		  $name = basename($newName, '.jpg');
	      ######################################################
		  $success = imagejpeg($thumb, THUMBS_DIR.$name.'_thb.jpg', 100);
	      $thumb_name = $name.'_thb.jpg';
	      break;
	    case 3:
		  ######################################################
		  # use the new name as the basis for the thumb's name #
		  ######################################################
		  $name = basename($newName, '.png');
	      ######################################################
		  $success = imagepng($thumb, THUMBS_DIR.$name.'_thb.png');
	      $thumb_name = $name.'_thb.png';
	    }
		if ($success) {
		  $result .= "$thumb_name created";
		  }
		else {
		  $result .= 'Problem creating thumbnail';
		  }
	  // remove the image resources from memory
	  imagedestroy($source);
      imagedestroy($thumb);
	  }
	}
?>