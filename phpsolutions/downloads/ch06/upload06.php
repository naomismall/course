<?php
// define a constant for the maximum upload size
define ('MAX_FILE_SIZE', 51200);

if (array_key_exists('upload', $_POST)) {
  // define constant for upload folder
  define('UPLOAD_DIR', 'C:/upload_test/');
  // replace any spaces in original filename with underscores
  // at the same time, assign to a simpler variable
  $file = str_replace(' ', '_', $_FILES['image']['name']);
  // convert the maximum size to KB
  $max = number_format(MAX_FILE_SIZE/1024, 1).'KB';
  // begin by assuming the file is unacceptable
  $sizeOK = false;
  
  // check that file is within the permitted size
  if ($_FILES['image']['size'] > 0 && $_FILES['image']['size'] <= MAX_FILE_SIZE) {
    $sizeOK = true;
	}
  
  if ($sizeOK) {
    switch($_FILES['image']['error']) {
	  case 0:
        // move the file to the upload folder and rename it
		$success = move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR.$file);
		if ($success) {
          $result = "$file uploaded successfully";
	      }
		else {
		  $result = "There was an error uploading $file. Please try again.";
		  }
	    break;
	  case 3:
		$result = "There was an error uploading $file. Please try again.";
	  default:
        $result = "System error uploading $file. Contact webmaster.";
	  }
    }
  elseif ($_FILES['image']['error'] == 4) {
    $result = 'No file selected';
	}
  else {
    $result = "$file cannot be uploaded. Maximum size: $max.";
	}
  }
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>File upload</title>
</head>

<body>
<?php
// if the form has been submitted, display result
if (isset($result)) {
  echo "<p><strong>$result</strong></p>";
  }
?>
<form action="" method="post" enctype="multipart/form-data" name="uploadImage" id="uploadImage">
    <p>
		<label for="image">Upload image:</label>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
        <input type="file" name="image" id="image" /> 
    </p>
    <p>
        <input type="submit" name="upload" id="upload" value="Upload" />
    </p>
</form>
</body>
</html>
