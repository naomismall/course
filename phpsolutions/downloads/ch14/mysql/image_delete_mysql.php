<?php
include('../includes/conn_mysql.inc.php');
include('../includes/corefuncs.php');
// remove backslashes
nukeMagicQuotes();
 // create database connection
$conn = dbConnect('admin');
// initialize flag
$deleted = false;
// get details of selected record
if ($_GET && !$_POST) {
  // check the primary key sent in the URL query string
  if (isset($_GET['image_id']) && is_numeric($_GET['image_id'])) {
    $image_id = $_GET['image_id'];
	}
  else {
    $image_id = NULL;
	}
  // continue if the primary key is OK
  if ($image_id) {
    // query the journal table to find if there are any dependent records
    $getDependents = "SELECT image_id FROM journal WHERE image_id = $image_id";
    $result = mysql_query($getDependents) or die (mysql_error());
	// if $numRows is greater than 0, there are dependent records
    $numRows = mysql_num_rows($result);
	// get the details of the image itself
	$getImage = "SELECT * FROM images WHERE image_id = $image_id";
	$result = mysql_query($getImage);
	$row = mysql_fetch_assoc($result);
	}
  }
// if confirm deletion button has been clicked, delete record
if (array_key_exists('delete', $_POST)) {
  // check that the primary key is numeric
  if (!is_numeric($_POST['image_id'])) {
    die('Invalid request');
	}
  else {
    $image_id = $_POST['image_id'];
	}
  // delete the image
  $sql = "DELETE FROM images
          WHERE image_id = $image_id";
  $deleted = mysql_query($sql) or die(mysql_error());
  }
// redirect the page if deletion successful, if cancel button clicked, or $_GET['image_id'] not defined
if ($deleted || array_key_exists('cancel_delete', $_POST) || !isset($_GET['image_id']))  {
  header('Location: http://localhost/phpsolutions/admin/image_list.php');
  exit;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Images - delete record</title>
<link href="../assets/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Delete image </h1>
<?php if (empty($row)) { ?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } 
elseif ($numRows > 0) {
?>
<p class="warning">The following item has dependent records in the journal table and cannot be deleted.</p>
<?php } else { ?>
<p class="warning">Please confirm that you want to delete the following item. This action cannot be undone.</p>
<?php } ?>
<p><?php
// display details of the selected image 
if (!empty($row)) {
  echo htmlentities($row['filename']).': '.htmlentities($row['caption']);
  }
?></p>
<form id="form1" name="form1" method="post" action="">
    <p>
	<?php if (!empty($row) && $numRows == 0) { ?>
        <input type="submit" name="delete" value="Confirm deletion" />
	<?php } ?>
		<input name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" />
	<?php if (!empty($row) && $numRows == 0) { ?>
		<input name="image_id" type="hidden" value="<?php echo $row['image_id']; ?>" />
	<?php } ?>
    </p>
</form>
</body>
</html>
