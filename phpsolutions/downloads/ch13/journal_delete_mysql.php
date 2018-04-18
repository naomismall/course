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
  // check that primary key is numeric
  if (isset($_GET['article_id']) && is_numeric($_GET['article_id'])) {
    $article_id = $_GET['article_id'];
	}
  else {
    $article_id = NULL;
	}
  if ($article_id) {
    $sql = "SELECT * FROM journal WHERE article_id = $article_id";
    $result = mysql_query($sql) or die (mysql_error());
    $row = mysql_fetch_assoc($result);
	}
  }
// if confirm deletion button has been clicked, delete record
if (array_key_exists('delete', $_POST)) {
  if (!is_numeric($_POST['article_id'])) {
    die('Invalid request');
	}
  $sql = "DELETE FROM journal
          WHERE article_id = {$_POST['article_id']}";
  $deleted = mysql_query($sql) or die(mysql_error());
  }
// redirect the page if deletion successful, cancel button clicked, or $_GET['article_id'] not defined
if ($deleted || array_key_exists('cancel_delete', $_POST) || !isset($_GET['article_id']))  {
  header('Location: http://localhost/phpsolutions/admin/journal_list.php');
  exit;
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
<?php if (!isset($article_id) || empty($row)) { ?>
<p class="warning">Invalid request: record does not exist.</p>
<?php } 
else {
?>
<p class="warning">Please confirm that you want to delete the following item. This action cannot be undone.</p>
<p><?php echo $row['created'].': '.htmlentities($row['title']); ?></p>
<?php } ?>
<form id="form1" name="form1" method="post" action="">
    <p>
	<?php if (!empty($row)) { ?>
        <input type="submit" name="delete" value="Confirm deletion" />
	<?php } ?>
		<input name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" />
	<?php if (!empty($row)) { ?>
		<input name="article_id" type="hidden" value="<?php echo $row['article_id']; ?>" />
	<?php } ?>
    </p>
</form>
</body>
</html>
