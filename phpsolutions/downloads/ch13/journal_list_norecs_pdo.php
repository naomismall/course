<?php
include('../includes/conn_pdo.inc.php');
// create database connection
$conn = dbConnect('query');
###################################
# Get the number of records found #
###################################
$sql = 'SELECT COUNT(*) FROM journal';
// submit the query and capture the result
$result = $conn->query($sql);
$error = $conn->errorInfo();
if (isset($error[2])) die($error[2]);
// find out how many records were retrieved
$numRows = $result->fetchColumn();
// free the database resources
$result->closeCursor();
// prepare second SQL query
$sql = 'SELECT * FROM journal ORDER BY created DESC';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Journal entries</title>
<link href="../assets/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Journal entries</h1>
<p><a href="journal_insert.php">Insert new entry</a> </p>
<?php
#######################################
# Display message if no records found #
#######################################
if ($numRows == 0) {
?>
<p>No records found</p>
<?php
  }
##################################
# Otherwise, display the results #
##################################
else {
?>
<table>
    <tr>
        <th scope="col">Created</th>
        <th scope="col">Title</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
    </tr>
	<?php
	foreach ($conn->query($sql) as $row) {
	?>
    <tr>
        <td><?php echo $row['created']; ?></td>
        <td><?php echo $row['title']; ?></td>
		<td><a href="journal_update_pdo.php?article_id=<?php echo $row['article_id']; ?>">EDIT</a></td>
		<td><a href="journal_delete_pdo.php?article_id=<?php echo $row['article_id']; ?>">DELETE</a></td>
    </tr>
	<?php } ?>
</table>
<?php
####################################################
# Close the else clause wrapping the results table #
####################################################
  }
?>
</body>
</html>
