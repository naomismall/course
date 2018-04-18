<?php
include('../includes/conn_mysqli.inc.php');
// connect to MySQL
$conn = dbConnect('query');
// prepare the SQL query
$sql = 'SELECT * FROM images';
// submit the query and capture the result
$result = $conn->query($sql) or die(mysqli_error($conn));
// find out how many records were retrieved
$numRows = $result->num_rows;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Connecting with MySQLI extension</title>
</head>

<body>
<p>A total of <?php echo $numRows; ?> records were found.</p>
</body>
</html>
