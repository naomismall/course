<?php
include('../includes/conn_mysqli.inc.php');
include('../includes/corefuncs.php');
// remove backslashes
nukeMagicQuotes();
// initialize flags
$OK = false;
$done = false;
 // create database connection
$conn = dbConnect('admin');
// get details of selected record
if (isset($_GET['article_id']) && !$_POST) {
  // prepare SQL query
  $sql = 'SELECT article_id, title, article
          FROM journal WHERE article_id = ?';
  // initialize statement
  $stmt = $conn->stmt_init();
  if ($stmt->prepare($sql)) {
    // bind the query parameters
    $stmt->bind_param('i', $_GET['article_id']);
	// bind the results to variables
	$stmt->bind_result($article_id, $title, $article);
	// execute the query, and fetch the result
	$OK = $stmt->execute();
	$stmt->fetch();
	}
  }
// if form has been submitted, update record
if (array_key_exists('update', $_POST)) {
  $sql = 'UPDATE journal SET title = ?, article = ?
          WHERE article_id = ?';
  $stmt = $conn->stmt_init();
  if ($stmt->prepare($sql)) {
    $stmt->bind_param('ssi', $_POST['title'], $_POST['article'], $_POST['article_id']);
	$done = $stmt->execute();
	}
  }
// redirect on success or if $_GET['article_id']) not defined
if ($done || !isset($_GET['article_id'])) {
  header('Location: http://localhost/phpsolutions/admin/journal_list.php');
  exit;
  }
// display error message if query fails
if (isset($stmt) && !$OK && !$done) {
  echo $stmt->error;
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
<?php if($article_id == 0) { ?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } 
else {
?>
<form id="form1" name="form1" method="post" action="">
    <p>
        <label for="title">Title:</label>
        <input name="title" type="text" class="widebox" id="title" value="<?php echo htmlentities($title); ?>" />
    </p>
    <p>
        <label for="article">Article:</label>
        <textarea name="article" cols="60" rows="8" class="widebox" id="article"><?php echo htmlentities($article); ?></textarea>
    </p>
    <p>
        <input type="submit" name="update" value="Update entry" />
		<input name="article_id" type="hidden" value="<?php echo $article_id; ?>" />
    </p>
</form>
<?php } ?>
</body>
</html>
