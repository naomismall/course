<?php
include('../includes/conn_mysqli.inc.php');
$conn = dbConnect('query');
$sql = 'SELECT * FROM images';
$result = $conn->query($sql) or die(mysqli_error($conn));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>List of images</title>
<link href="../assets/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>List of images</h1>
<table>
  <tr>
    <th scope="col">filename</th>
    <th scope="col">Caption</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
  </tr>
  <?php
  while ($row = $result->fetch_assoc()) {
  ?>
  <tr>
    <td><?php echo $row['filename']; ?></td>
    <td><?php echo $row['caption']; ?></td>
    <td><a href="image_update.php?image_id=<?php echo $row['image_id']; ?>">EDIT</a></td>
    <td><a href="image_delete.php?image_id=<?php echo $row['image_id']; ?>">DELETE</a></td>
  </tr>
  <?php } ?>
</table>
<p>&nbsp; </p>
</body>
</html>
