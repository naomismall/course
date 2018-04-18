<?php
include('../includes/buildFileList5.php');
include('../includes/corefuncs.php');
include('../includes/conn_mysql.inc.php');
// connect to the database with administrative privileges
$conn = dbConnect('admin');
// process the form when submitted
if (array_key_exists('insert', $_POST)) {
  // STEP 1
  // remove magic quotes and validate input
  nukeMagicQuotes();
  $filename = $_POST['filename'];
  $caption = trim($_POST['caption']);
  if (empty($filename) || empty($caption)) {
    $error = 'You must select a filename and enter a caption.';
	}
  // carry only if input OK
  else {
    // prepare text for database query
    $filename = mysql_real_escape_string($filename);
    $caption = mysql_real_escape_string($caption);
    // STEP 2
    // check whether the filename is already registered in the database
    $checkUnique = "SELECT filename FROM images
                    WHERE filename = '$filename'";
    $result = mysql_query($checkUnique);
    $numRows = mysql_num_rows($result);
    // STEP 3
    // if $numRows is greater than 0, the image is a duplicate
    if ($numRows > 0) {
      $error = "$filename is already registered in the database.";
	  }
    // STEP 4
    // if not a duplicate, proceed with insertion
    else {
      // insert the image details into the images table
      $insert = "INSERT INTO images (filename, caption)
                 VALUES ('$filename', '$caption')";
      mysql_query($insert);
      // STEP 5
      // initialize an array for the categories
      $categories = array();
      // check whether any categories have been selected
      if (isset($_POST['categories'])) {
        // STEP 6
        // get the primary key of the image just inserted
        $getImageId = "SELECT image_id FROM images
                       WHERE filename = '$filename'
                       AND caption = '$caption'";
        $result = mysql_query($getImageId);
        $row = mysql_fetch_assoc($result);
        $image_id = $row['image_id'];
        // STEP 7
	    // loop through the selected categories and build value pairs
	    // ready for insertion into the lookup table
        foreach ($_POST['categories'] as $cat_id) {
          if (is_numeric($cat_id)) {
	        $categories[] = "($image_id, $cat_id)";
	        }
	      }
	    }
      // join the value pairs as a comma-separated string
      if (!empty($categories)) {
        $categories = implode(',', $categories);
	    $noCats = false;
	    }
      else {
        $noCats = true;
	    }
      // STEP 8
      // insert the categories into the lookup table
      if (!$noCats) {  
        $insertCats = "INSERT INTO image_cat_lookup (image_id, cat_id)
	                   VALUES $categories";
	    mysql_query($insertCats);
	    }
      // STEP 9
      // redirect the page after insertion
      // this is inside the else clause initiated in step 4
      // it is ignored if there were errors in steps 1 or 3
      header('Location: http://localhost/phpsolutions/admin/image_list.php');
      exit;
      }
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Insert image</title>
<link href="../assets/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Insert image </h1>
<?php if (isset($error)) { ?>
<p class="warning"><?php echo $error; ?></p>
<?php } ?>
<form id="form1" name="form1" method="post" action="">
  <p>
    <label for="filename">Filename:</label>
    <select name="filename" id="filename">
      <option value="">Select image file</option>
	  <?php buildFileList5('../images/'); ?>
            </select>
  </p>
  <p>
    <label for="textfield">Caption:</label>
    <input name="caption" type="text" class="widebox" id="caption" />
  </p>
  <p>
    <label for="categories">Categories:</label>
    <select name="categories[]" size="5" multiple="multiple" id="categories">
	<?php
	// build a multiple choice list with the contents of the categories table
	$allCats = 'SELECT * FROM categories';
    $catList = mysql_query($allCats);
	while ($row = mysql_fetch_assoc($catList)) {
	?>
	<option value="<?php echo $row['cat_id']; ?>">
	<?php echo $row['category']; ?>
	</option>
	<?php } ?>
    </select>
  </p>
  <p>
    <input name="insert" type="submit" id="insert" value="Insert image" />
  </p>
</form>
</body>
</html>
