<?php
##################################################################
# Move the database connection outside the conditional statement #
##################################################################
include('../includes/conn_mysql.inc.php');
// create database connection
$conn = dbConnect('admin');

if (array_key_exists('insert', $_POST)) {
  include('../includes/corefuncs.php');
  nukeMagicQuotes();
  ###################################
  # Add image_id to $expected array #
  ###################################
  $expected = array('title', 'article', 'image_id');
  foreach ($_POST as $key => $value) {
    if (in_array($key, $expected)) {
      ${$key} = mysql_real_escape_string($value);
      }
    }
  ###############################
  # Check the value of image_id #
  ###############################
  if (empty($image_id) || !is_numeric($image_id)) {
    $image_id = 'NULL';
	}
  ##############################################
  # Amend the INSERT query to include image_id #
  ##############################################
  $sql = "INSERT INTO journal (image_id, created, title, article)
          VALUES($image_id, NOW(), '$title', '$article')";
  $result = mysql_query($sql) or die(mysql_error());
  if ($result) {
    header('Location: http://localhost/phpsolutions/admin/journal_list.php');
    exit;
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Journal - insert new record</title>
<link href="../assets/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Insert new journal entry </h1>
<form id="form1" name="form1" method="post" action="">
    <p>
        <label for="title">Title:</label>
        <input name="title" type="text" class="widebox" id="title" />
    </p>
    <p>
        <label for="article">Article:</label>
        <textarea name="article" cols="60" rows="8" class="widebox" id="article"></textarea>
    </p>
	<p>
      <label for="image_id">Image:</label>
      <select name="image_id" id="image_id">
        <option value="">Select image</option>
		<?php
		// get details of images
        $getImages = 'SELECT * FROM images ORDER BY filename';
        $imageList = mysql_query($getImages) or die (mysql_error());
		while ($image = mysql_fetch_assoc($imageList)) {
		##############################################
		# Loop doesn't need to display selected item #
		##############################################
		?>
		<option value="<?php echo $image['image_id']; ?>">
		<?php echo $image['filename']; ?>
		</option>
		<?php } ?>
      </select>
    </p>
    <p>
        <input type="submit" name="insert" value="Insert new entry" />
    </p>
</form>
</body>
</html>
