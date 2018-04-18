<?php
include('includes/title.inc.php');
// include MySQL connector function (use the right version!)
if (! @include('includes/conn_mysql.inc.php')) {
  echo 'Sorry, page unavailable';
  exit;
  }
// create database connection
$conn = dbConnect('query');
$sql = 'SELECT article_id, title, LEFT(article, 100) AS first100
        FROM journal ORDER BY created DESC';
$result = mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Japan Journey<?php if (isset($title)) {echo "&#8212;{$title}";} ?></title>
<link href="assets/journey.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
<div id="header">
    <h1>Japan Journey </h1>
</div>
<div id="wrapper">
    <?php include('includes/menu.inc.php'); ?>
    <div id="maincontent">
	<?php
	while ($row = mysql_fetch_assoc($result)) {
	?>
        <h2><?php echo $row['title']; ?></h2>
		<p>
		<?php
		$extract = $row['first100'];
		// find position of last space in extract
		$lastSpace = strrpos($extract, ' ');
		// use $lastSpace to set length of new extract and add ...
		echo substr($extract, 0, $lastSpace).'... ';
		echo '<a href="details.php?article_id='.$row['article_id'].'"> More</a>';
		?></p>
	<?php } ?>
    </div>
    <?php include('includes/footer.inc.php'); ?>
</div>
</body>
</html>