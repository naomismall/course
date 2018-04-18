<?php
//define a constant for the maximum upload size
define ('MAX_FILE_SIZE', 600000);

if (array_key_exists('upload', $_POST)) {
  // define constant for upload folder
  define('UPLOAD_DIR', 'C:/upload_test/');

  // replace any spaces in original filename with underscores
  // at the same time, assign to a simpler variable
  $file = str_replace(' ', '_', $_FILES['image']['name']);

  // convert the maximum size to KB
  $max = number_format(MAX_FILE_SIZE/1024, 1).'KB';

  //create an array of permitted MIME types
  $permitted = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');

  foreach ($_FILES['image']['name'] as $number => $file) {
    //replace any spaces in the filename with underscores
    $file = str_replace(' ','_', $file);
 
    // begin by assuming the file is unacceptable
    $sizeOK = false;
    $typeOK = false;

    // check that file is within the permitted size
    if ($_FILES['image']['size'][$number] > 0 && $_FILES['image']['size'][$number] <= MAX_FILE_SIZE) {
      $sizeOK = true;
    }

    // check that file is of a permitted MIME type
    foreach ($permitted as $type) {

      if ($type == $_FILES['image']['type'][$number]) {
        $typeOK = true;
        break;
      }
    }

    if ($sizeOK && $typeOK) {
      switch ($_FILES['image']['error'][$number]) {
        case 0:
          //$username would normally come from a session variable
          $username = 'naomi';
          // if the subfolder doesn't exist yet, create it
          if (!is_dir(UPLOAD_DIR.$username)) {
            mkdir(UPLOAD_DIR.$username);
          }

          // make sure the file of same name does not already exist
          if (!file_exists(UPLOAD_DIR.$username.'/'.$file)) {
            // move the file to the upload folder and rename it
            $success = move_uploaded_file($_FILES['image']['tmp_name'][$number], UPLOAD_DIR.$file);
          }
          else {
            // get the date and time
            ini_set('date.timezone', 'Europe/London');
            $now = date('Y-m-d-His');
            $success = move_uploaded_file($_FILES['image']['tmp_name'][$number], UPLOAD_DIR.$now.$file);
          }
          if ($success) {
            $result[] = "$file uploaded sucessfully";
          }
          else {
            $result[] = "Error uploading $file. Please try again";
          }
          break;
        case 3:
          $result[] = "Error uploading $file. Please try again";
        default:
          $result[] = "System error uploading $file. Contact webmaster";
          
      }
    }

    elseif ($_FILES['image']['error'][$number] == 4) {
      $result[] = 'No file selected';
    }
    else {
      $result[] = "$file cannot be uploaded. Maximum size: $max. Acceptable file types: gif, jpg, png";
    }
    // move the file to the upload folder and rename it
    //`move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR.$file);
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
  echo '<ol>';
  foreach ($result as $item) {
    echo "<strong><li>$item</li></strong>";
  }
  echo '</ol>';
}
?>

<form action="" method="post" enctype="multipart/form-data" name="uploadImage" id="uploadImage">
    <p>
		<label for="image">Upload image:</label>
		<input type ="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
        <input type="file" name="image" id="image" /> 
    </p>
    <p>
        <input type="submit" name="upload" id="upload" value="Upload" />
    </p>
</form>
</body>
</html>