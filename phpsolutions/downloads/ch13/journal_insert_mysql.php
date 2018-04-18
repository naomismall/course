<?php
if (array_key_exists('insert', $_POST)) {
  include('../includes/conn_mysql.inc.php');
  include('../includes/corefuncs.php');
  // remove backslashes
  nukeMagicQuotes();
  // prepare an array of expected items
  $expected = array('title', 'article');
  // create database connection
  $conn = dbConnect('admin');
  // make $_POST data safe for insertion into database
  foreach ($_POST as $key => $value) {
    if (in_array($key, $expected)) {
      ${$key} = mysql_real_escape_string($value);
      }
    }
  // prepare the SQL query
  $sql = "INSERT INTO journal (title, article, created)
          VALUES('$title', '$article', NOW())";
  // process the query
  $result = mysql_query($sql) or die(mysql_error());
  // if successful, redirect to list of existing records
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
        <input type="submit" name="insert" value="Insert new entry" />
    </p>
</form>
</body>
</html>
