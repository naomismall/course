<?php
include('../includes/conn_mysql.inc.php');
include('../includes/corefuncs.php');
// remove backslashes
nukeMagicQuotes();
// initialize flag
$done = false;
// prepare an array of expected items
$expected = array('title', 'article', 'article_id', 'image_id');
 // create database connection
$conn = dbConnect('admin');
// get details of selected record
if ($_GET && !$_POST) {
  if (!is_numeric($_GET['article_id'])) {
    die('Invalid request');
	}
  $sql = "SELECT * FROM journal WHERE article_id = {$_GET['article_id']}";
  $result = mysql_query($sql) or die (mysql_error());
  $row = mysql_fetch_assoc($result);
  // get details of images
  $getImages = 'SELECT * FROM images ORDER BY filename';
  $imageList = mysql_query($getImages) or die (mysql_error());
  }
// if form has been submitted, update record
if (array_key_exists('update', $_POST)) {
  // prepare expected items for insertion in to database
  foreach ($_POST as $key => $value) {
    if (in_array($key, $expected)) {
      ${$key} = mysql_real_escape_string($value);
      }
    }
  // abandon the process if primary key invalid
  if (!is_numeric($article_id)) {
    die('Invalid request');
	}
  // check the value of image_id
  if (empty($image_id) || !is_numeric($image_id)) {
    $image_id = 'NULL';
	}
  // prepare the SQL query
  $sql = "UPDATE journal SET image_id = $image_id,
          title = '$title', article = '$article'
          WHERE article_id = $article_id";
  // submit the query and redirect if successful
  $done = mysql_query($sql) or die(mysql_error());
  }
if ($done || (!$_GET && !$_POST)) {
  header('Location: http://localhost/phpsolutions/admin/journal_list.php');
  exit;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Journal - update record</title>
<link href="../assets/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Update journal entry</h1>
<p><a href="journal_list.php">List all entries</a> </p>
<?php if (empty($row)) {
?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } 
else {
?>
<form id="form1" name="form1" method="post" action="">
    <p>
        <label for="title">Title:</label>
        <input name="title" type="text" class="widebox" id="title" value="<?php echo htmlentities($row['title']); ?>" />
    </p>
    <p>
        <label for="article">Article:</label>
        <textarea name="article" cols="60" rows="8" class="widebox" id="article"><?php echo htmlentities($row['article']); ?></textarea>
    </p>
    <p>
      <label for="image_id">Image:</label>
      <select name="image_id" id="image_id">
        <option value="">Select image</option>
		<?php
		while ($image = mysql_fetch_assoc($imageList)) {
		?>
		<option value="<?php echo $image['image_id']; ?>"
		<?php
		if ($image['image_id'] == $row['image_id']) {
		  echo ' selected="selected"';
		  }
		?>><?php echo $image['filename']; ?>
		</option>
		<?php } ?>
      </select>
    </p>
    <p>
        <input type="submit" name="update" value="Update entry" />
		<input name="article_id" type="hidden" value="<?php echo $row['article_id']; ?>" />
    </p>
</form>
<?php } ?>
</body>
</html>
