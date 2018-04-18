<?php
include('../includes/corefuncs.php');
include('../includes/conn_mysql.inc.php');
nukeMagicQuotes();
$conn = dbConnect('admin');
// get details of the record to be updated when page first loads
if (!array_key_exists('update', $_POST) && isset($_GET['image_id'])) {
  if (isset($_GET['image_id']) && is_numeric($_GET['image_id'])) {
    $image_id = $_GET['image_id'];
	}
  else {
    $image_id = NULL;
	}
  // if image_id is valid, get details of the image
  if ($image_id) {
    $image_query = "SELECT * FROM images WHERE image_id = $image_id";
    $result = mysql_query($image_query);
    $imageDets = mysql_fetch_assoc($result);
    // get details of the categories the image is associated with in the lookup table
    $cat_query = "SELECT * FROM image_cat_lookup WHERE image_id = $image_id";
    $result = mysql_query($cat_query);
    // initialize an array to store the categories from the lookup table
    $cats = array();
    // loop through the result of the lookup table query to populate the array
    while ($row = mysql_fetch_assoc($result)) {
      $cats[] = $row['cat_id'];
	  }
	}
  }
// process the update if the form has been submitted
elseif (array_key_exists('update', $_POST)) {
  // initialize flag
  $OK = true;
  // verify that the image_id is a number
  if (is_numeric($_POST['image_id'])) {
    $image_id = $_POST['image_id'];
	}
  else {
    $OK = false;
	}
  // prepare the caption for insertion into the database
  // make sure that it contains a value
  $caption = trim($_POST['caption']);
  if (!empty($caption)) {
    $caption = mysql_real_escape_string($caption);
	}
  // if the caption is empty, you need to redisplay the form with its existing values
  // do this by copying the values from the $_POST array to the same variables used when the page first loads
  // by setting $OK to false, the update will not be peformed
  // $missing is used as a flag to prevent the page from being redirected
  else {
    $OK = false;
	$missing = 'Please enter a caption';
	$imageDets['filename'] = $_POST['filename'];
	$imageDets['caption'] = $caption;
	$cats = array();
	foreach ($_POST['categories'] as $cat) {
	  $cats[] = $cat;
	  }
	}
  // initialize an array for categories to be inserted in the lookup table
  $categories = array();
  // if image_id and caption are OK, and categories have been selected,
  // loop through the selected categories to build values string for INSERT query
  if ($OK && isset($_POST['categories'])) {
    foreach ($_POST['categories'] as $cat_id) {
      if (is_numeric($cat_id)) {
	    $categories[] = "($image_id, $cat_id)";
	    }
	  }
	}
  // join values as a comma-separated string
  if (!empty($categories)) {
    $categories = implode(',', $categories);
	$noCats = false;
	}
  else {
    $noCats = true;
	}
  // if image_id is numeric, proceed with the update
  if ($OK) {
    // begin by updating the images table
    $updateImage = "UPDATE images SET caption = '$caption'
                    WHERE image_id = $image_id";
	mysql_query($updateImage);
	// delete existing references to the image in the lookup table
	$deleteCats = "DELETE FROM image_cat_lookup WHERE image_id = $image_id";
	mysql_query($deleteCats);
	// if catagories have been selected, insert the new values in the lookup table
	if (!$noCats) {
	  $updateCats = "INSERT INTO image_cat_lookup (image_id, cat_id)
	                 VALUES $categories";
	  mysql_query($updateCats);
	  }
	}
  // redirect the page unless $missing has been set
  // using $missing rather than $OK means the page is redirected if image_id is not a number
  // there's no point redisplaying the page if someone has tried tampering with the primary key
  if (!isset($missing)) {
    header('Location: http://localhost/phpsolutions/admin/image_list.php');
    exit;
	}
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Update image details</title>
<link href="../assets/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Update image details</h1>
<p><a href="image_list.php">List all images</a></p>
<?php if (isset($missing)) { ?>
<p class="warning"><?php echo $missing; ?></p>
<?php } elseif (!isset($image_id) || empty($imageDets)) { ?>
<p class="warning">Invalid request: record does not exist.</p>
<?php }
if (isset($image_id)) {
?>
<form id="form1" name="form1" method="post" action="">
  <p>
    <label for="filename">Filename:</label>
	<!-- The readonly attribute is applied to the filename field to prevent it from being changed accidentally -->
    <input name="filename" type="text" id="filename" readonly="readonly" value="<?php echo $imageDets['filename']; ?>" />
  </p>
  <p>
    <label for="caption">Caption:</label>
    <input name="caption" type="text" class="widebox" id="caption" value="<?php echo $imageDets['caption']; ?>" />
  </p>
  <p>
    <label for="categories">Categories</label>
    <select name="categories[]" size="5" multiple="multiple" id="categories">
	<?php
	// get category details
	$allCats = 'SELECT * FROM categories';
    $catList = mysql_query($allCats);
	while ($row = mysql_fetch_assoc($catList)) {
	?>
	<option value="<?php echo $row['cat_id']; ?>"
	<?php
	// highlight selected categories
	if (in_array($row['cat_id'], $cats)) {
	  echo ' selected="selected"';
	  }
	?>
	>
	<?php echo $row['category']; ?>
	</option>
	<?php } ?>
    </select>
  </p>
  <p>
    <input name="image_id" type="hidden" value="<?php if (isset($image_id)) {echo $image_id;} ?>" />
	<input name="update" type="submit" id="update" value="Update image details" />
  </p>
</form>
<?php } ?>
</body>
</html>
