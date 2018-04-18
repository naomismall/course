<?php
include('includes/title.inc.php');
// include MySQL connector function (use the right version!)
if (! @include('includes/conn_mysql.inc.php')) {
  echo 'Sorry, page unavailable';
  exit;
  }
// connect to the database
$conn = dbConnect('query');
// check for article_id in query string
if (isset($_GET['article_id']) && is_numeric($_GET['article_id'])) {
  $article_id = $_GET['article_id'];
  }
else {
  $article_id = 0;
  }
// prepare SQL query
$sql = "SELECT title, article, filename, caption
        FROM journal LEFT JOIN images USING (image_id)
		WHERE journal.article_id = $article_id";
// process query
$result = mysql_query($sql) or die (mysql_error());
$row = mysql_fetch_assoc($result);
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
        <h2><?php if ($row) {
		  echo $row['title'];
		  }
		else {
		  echo 'No record found';
		  }
		?>
		</h2>
        <?php
		if ($row && !empty($row['filename'])) {
		  $filename = "images/{$row['filename']}";
		  $imageSize = getimagesize($filename);
		?>
		<div id="pictureWrapper">
		<img src="<?php echo $filename; ?>"
		alt="<?php echo $row['caption']; ?>"
		<?php echo $imageSize[3];?> />
		</div>
		<?php } ?>
		<p>
        <?php
		if ($row) {
		  echo nl2br($row['article']);
		  }
		else {
		?>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<?php }?>
		</p>
        <p><a href="journal.php">Back to the journal </a></p>
    </div>
    <?php include('includes/footer.inc.php'); ?>
</div>
</body>
</html>
