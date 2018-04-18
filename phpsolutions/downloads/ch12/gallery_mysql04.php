<?php
include('includes/title.inc.php');
// include MySQL connector function (use the right version!)
if (! @include('includes/conn_mysql.inc.php')) {
  echo 'Sorry, page unavailable';
  exit;
  }
// create a connection to MySQL
$conn = dbConnect('query');
// prepare SQL to retrieve image details
$sql = 'SELECT * FROM images';
// submit the query (MySQL original)
$result = mysql_query($sql) or die(mysql_error());
// extract the first record as an array
$row = mysql_fetch_assoc($result);
// get the name and caption for the main image
$mainImage = $row['filename'];
$caption = $row['caption'];
// get the dimensions of the main image
$imageSize = getimagesize('images/'.$mainImage);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Japan Journey
<?php if (isset($title)) {echo "&#8212;{$title}";} ?>
</title>
<link href="assets/journey.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="header">
    <h1>Japan Journey </h1>
</div>
<div id="wrapper">
    <?php include('includes/menu.inc.php'); ?>
    <div id="maincontent">
        <h1>Images of Japan</h1>
        <p id="picCount">Displaying 1 to 6 of 8</p>
        <div id="gallery">
            <table id="thumbs">
                <tr>
					<!--This row needs to be repeated-->
					<?php do { ?>
                    <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?image=<?php echo $row['filename']; ?>"><img src="images/thumbs/<?php echo $row['filename']; ?>" alt="<?php echo $row['caption']; ?>" width="80" height="54" /></a></td>
					<?php
					$row = mysql_fetch_assoc($result);
					} while ($row);
					?>
                </tr>
				<!-- Navigation link needs to go here -->
            </table>
            <div id="main_image">
                <p><img src="images/<?php echo $mainImage; ?>" alt="<?php echo $caption; ?>" <?php echo $imageSize[3]; ?> /></p>
                <p><?php echo $caption; ?></p>
            </div>
        </div>
    </div>
    <?php include('includes/footer.inc.php'); ?>
</div>
</body>
</html>
