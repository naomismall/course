<?php
include('../includes/conn_pdo.inc.php');
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
// redirect if $_GET['article_id'] not defined
if ($done || !isset($_GET['article_id'])) {
  header('Location: http://localhost/phpsolutions/admin/journal_list.php');
  exit;
  }
// display error message if query fails
if (isset($stmt) && !$OK && !$done) {
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
<title>Journal - update record</title>
<link href="../assets/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Update journal entry</h1>
<p><a href="journal_list.php">List all entries</a> </p>
<?php if (!isset($article_id)) {
?>
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
