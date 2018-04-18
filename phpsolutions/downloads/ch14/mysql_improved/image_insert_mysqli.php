<?php
include('../includes/buildFileList5.php');
include('../includes/corefuncs.php');
include('../includes/conn_mysqli.inc.php');
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
    // STEP 2
    // check whether the filename is already registered in the database
    $checkUnique = "SELECT filename FROM images
                    WHERE filename = ?";
    // initialize prepared statement
    $stmt = $conn->stmt_init();
    if ($stmt->prepare($checkUnique)) {
      // bind filename parameter and execute statement
	  $stmt->bind_param('s', $filename);
	  $OK = $stmt->execute();
	  ################################################
	  # To use num_rows with a prepared statement,   #
	  # you must first use the store_result() method #
	  ################################################
	  $stmt->store_result();
	  $numRows = $stmt->num_rows;
	  // free the statement for the next query
	  $stmt->free_result();
	  }
    // STEP 3
    // if $numRows is greater than 0, the image is a duplicate
    if ($numRows > 0) {
      $error = "$filename is already registered in the database.";
	  }
    // STEP 4
    // if not a duplicate, proceed with insertion
    else {
      // insert the image details into the images table
      // prepare the SQL query
      $insert = "INSERT INTO images (filename, caption)
                 VALUES (?, ?)";
      // statement object already exists, so you just need to prepare it with the new SQL
      if ($stmt->prepare($insert)) {
        // bind parameters and execute statment
        $stmt->bind_param('ss', $filename, $caption);
	    $OK = $stmt->execute();
	    // free the statement for the next query
	    $stmt->free_result();
	    }
      // STEP 5
      // initialize an array for the categories
      $categories = array();
      // check whether any categories have been selected
      if (isset($_POST['categories'])) {
        // STEP 6
        // get the primary key of the image just inserted
        $getImageId = 'SELECT image_id FROM images
                       WHERE filename = ? AND caption = ?';
        // statement object already exists, so you just need to prepare it with the new SQL
        if ($stmt->prepare($getImageId)) {
          // bind parameters and execute statment
          $stmt->bind_param('ss', $filename, $caption);
	      // bind the result to $image_id
	      $stmt->bind_result($image_id);
 	      // execute the statement and get the result
	      $OK = $stmt->execute();
	      $stmt->fetch();
	      // free the statment for the next query
	      $stmt->free_result();
	      }
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
	    // all values have been checked or come from a previous query
	    // therefore there's no need to use a prepared statement
	    $conn->query($insertCats);
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
    $catList = $conn->query($allCats);
	while ($row = $catList->fetch_assoc()) {
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
