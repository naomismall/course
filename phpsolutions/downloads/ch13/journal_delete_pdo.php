<?php
include('../includes/conn_pdo.inc.php');
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
  $sql = 'SELECT * FROM journal WHERE article_id = ?';
  $stmt = $conn->prepare($sql);
  // execute query by passing array of variables
  $OK = $stmt->execute(array($_GET['article_id']));
  // fetch the result
  $row = $stmt->fetch();
  // assign result array to variables
  if (is_array($row)) {
    extract($row);
	}
  }
// if confirm deletion button has been clicked, delete record
if (array_key_exists('delete', $_POST)) {
  $sql = 'DELETE FROM journal WHERE article_id = ?';
  $stmt = $conn->prepare($sql);
  $deleted = $stmt->execute(array($_POST['article_id']));
  }
// redirect the page if deleted, cancel button clicked, or $_GET['article_id'] not defined
if ($deleted || array_key_exists('cancel_delete', $_POST) || !isset($_GET['article_id']))  {
  header('Location: http://localhost/phpsolutions/admin/journal_list.php');
  exit;
  }
// if any SQL query fails, display error message
if (isset($stmt) && !$OK && !$deleted) {
  $error = $stmt->errorInfo();
  if (isset($error[2])) {
    echo $error[2];
    }
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
<?php if (!isset($article_id)) { ?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } else { ?>
<p class="warning">Please confirm that you want to delete the following item. This action cannot be undone.</p>
<p><?php echo $created.': '.htmlentities($title); ?></p>
<?php } ?>
<form id="form1" name="form1" method="post" action="">
    <p>
	<?php if (isset($article_id)) { ?>
        <input type="submit" name="delete" value="Confirm deletion" />
	<?php } ?>
		<input name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" />
	<?php if (isset($article_id)) { ?>
		<input name="article_id" type="hidden" value="<?php echo $row['article_id']; ?>" />
	<?php } ?>
    </p>
</form>
</body>
</html>
