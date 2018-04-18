<?php
##################################################################
# Move the database connection outside the conditional statement #
##################################################################
include('../includes/conn_pdo.inc.php');
// create database connection
$conn = dbConnect('admin');
// get details of images
$getImages = 'SELECT * FROM images ORDER BY filename';

if (array_key_exists('insert', $_POST)) {
  include('../includes/corefuncs.php');
  // remove backslashes
  nukeMagicQuotes();
  // initialize flag
  $OK = false;
  ###################################################
  # Amend the prepared statment to include image_id #
  ###################################################
  // create SQL
  $sql = 'INSERT INTO journal (image_id, title, article, created) 
          VALUES(:image_id, :title, :article, NOW())';
  // prepare the statement
  $stmt = $conn->prepare($sql);
  // bind the parameters and execute the statement
  ###############################################################
  # image_id must be an integer, so use PDO::PARAM_INT constant #
  ###############################################################
  $stmt->bindParam(':image_id', $_POST['image_id'], PDO::PARAM_INT);
  $stmt->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
  $stmt->bindParam(':article', $_POST['article'], PDO::PARAM_STR);
  $OK = $stmt->execute();
  // redirect if successful or display error
  if ($OK) {
	header('Location: http://localhost/phpsolutions/admin/journal_list.php');
    exit;
    }
  else {
    $error = $stmt->errorInfo();
	echo $error[2];
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
		##############################################
		# Loop doesn't need to display selected item #
		##############################################
		foreach ($conn->query($getImages) as $image) {
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
