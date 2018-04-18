<?php
##################################################################
# Move the database connection outside the conditional statement #
##################################################################
include('../includes/conn_mysqli.inc.php');
// create database connection
  $conn = dbConnect('admin');

if (array_key_exists('insert', $_POST)) {
  include('../includes/corefuncs.php');
  // remove backslashes
  nukeMagicQuotes();
  // initialize flag
  $OK = false;
  
  #############################################################
  # Amend the INSERT query and parameters to include image_id #
  #############################################################
  // create SQL
  $sql = 'INSERT INTO journal (image_id, title, article, created)
          VALUES(?, ?, ?, NOW())';
  // initialize prepared statement
  $stmt = $conn->stmt_init();
  if ($stmt->prepare($sql)) {
    // bind parameters and execute statment
    $stmt->bind_param('iss', $_POST['image_id'], $_POST['title'], $_POST['article']);
	$OK = $stmt->execute();
	}
  // redirect if successful or display error
  if ($OK) {
	header('Location: http://localhost/phpsolutions/admin/journal_list.php');
    exit;
    }
  else {
    echo $stmt->error;
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
		// get details of the images
        $getImages = 'SELECT * FROM images ORDER BY filename';
        $imageList = $conn->query($getImages) or die(mysqli_error($conn));
		while ($image = $imageList->fetch_assoc()) {
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
