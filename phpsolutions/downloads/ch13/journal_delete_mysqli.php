<?php
include('../includes/conn_mysqli.inc.php');
include('../includes/corefuncs.php');
// remove backslashes
nukeMagicQuotes();
 // create database connection
$conn = dbConnect('admin');
// initialize flags
$OK = false;
$deleted = false;
// get details of selected record
if (isset($_GET['article_id']) && !$_POST) {
  // prepare SQL query
  $sql = 'SELECT article_id, title, created
          FROM journal WHERE article_id = ?';
  // initialize statement
  $stmt = $conn->stmt_init();
  if ($stmt->prepare($sql)) {
    // bind the query parameters
    $stmt->bind_param('i', $_GET['article_id']);
	// bind the result to variables
	$stmt->bind_result($article_id, $title, $created);
	// execute the query, and fetch the result
	$OK = $stmt->execute();
	$stmt->fetch();
	}
  }
// if confirm deletion button has been clicked, delete record
if (array_key_exists('delete', $_POST)) {
  $sql = 'DELETE FROM journal WHERE article_id = ?';
  $stmt = $conn->stmt_init();
  if ($stmt->prepare($sql)) {
    $stmt->bind_param('i', $_POST['article_id']);
	$deleted = $stmt->execute();
	}
  }
// redirect the page if deletion is successful, cancel button clicked, or $_GET['article_id'] not defined
if ($deleted || array_key_exists('cancel_delete', $_POST) || !isset($_GET['article_id']))  {
  header('Location: http://localhost/phpsolutions/admin/journal_list.php');
  exit;
  }
// if any SQL query fails, display error message
if (isset($stmt) && !$OK && !$deleted) {
  echo $stmt->error;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Journal - delete record</title>
<link href="../assets/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Delete journal entry </h1>
<?php if($article_id == 0) { ?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } else { ?>
<p class="warning">Please confirm that you want to delete the following item. This action cannot be undone.</p>
<p><?php echo $created.': '.htmlentities($title); ?></p>
<?php } ?>
<form id="form1" name="form1" method="post" action="">
    <p>
	<?php if($article_id > 0) { ?>
        <input type="submit" name="delete" value="Confirm deletion" />
	<?php } ?>
		<input name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" />
	<?php if($article_id > 0) { ?>
		<input name="article_id" type="hidden" value="<?php echo $article_id; ?>" />
	<?php } ?>
    </p>
</form>
</body>
</html>
