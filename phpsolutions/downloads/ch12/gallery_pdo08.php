<?php
include('includes/title.inc.php');
// include MySQL connector function (use the right version!)
if (! @include('includes/conn_pdo.inc.php')) {
  echo 'Sorry, page unavailable';
  exit;
  }
// define number of columns in table
define('COLS', 2);
// create a connection to MySQL
$conn = dbConnect('query');
// set maximum number of records per page
define('SHOWMAX', 6);
// create a connection to MySQL
$conn = dbConnect('query');
// prepare SQL to get total records
$getTotal = 'SELECT COUNT(*) FROM images';
// submit query and store result as $totalPix
$total = $conn->query($getTotal);
$row = $total->fetchColumn();
$totalPix = $row[0];
$total->closeCursor();
// set the current page
$curPage = isset($_GET['curPage']) ? $_GET['curPage'] : 0;
// calculate the start row of the subset
$startRow = $curPage * SHOWMAX;
// prepare SQL to retrieve subset of image details
$sql = "SELECT * FROM images LIMIT $startRow,".SHOWMAX;
// submit the query (PDO)
$result = $conn->query($sql);
// get any error messages
$error = $conn->errorInfo();
if (isset($error[2])) die($error[2]);
// extract the first record as an array
$row = $result->fetch();
// get the name for the main image
if (isset($_GET['image'])) {
  $mainImage = $_GET['image'];
  }
else {
  $mainImage = $row['filename'];
  }
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
        <p id="picCount">Displaying <?php echo $startRow+1;
		  if ($startRow+1 < $totalPix) {
		    echo ' to ';
			if ($startRow+SHOWMAX < $totalPix) {
			  echo $startRow+SHOWMAX;
			  }
			else {
			  echo $totalPix;
			  }
			}
		  echo " of $totalPix";
		  ?></p>
        <div id="gallery">
            <table id="thumbs">
                <tr>
                    <!--This row needs to be repeated-->
                    <?php
					// initialize cell counter outside loop
					$pos = 0;
		            do {
					  // set caption if thumbnail is same as main image
		              if ($row['filename'] == $mainImage) {
		                $caption = $row['caption'];
			            }
		             ?>
                    <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?image=<?php echo $row['filename']; ?>&amp;curPage=<?php echo $curPage; ?>"><img src="images/thumbs/<?php echo $row['filename']; ?>" alt="<?php echo $row['caption']; ?>" width="80" height="54" /></a></td>
                    <?php
					$row = $result->fetch();
					// increment counter after next row extracted
		 			$pos++;
		  			// if at end of row and records remain, insert tags
					if ($pos%COLS === 0 && is_array($row)) {
		    		  echo '</tr><tr>';
					  }
		  			} while($row);  // end of loop
		  			// new loop to fill in final row
					while ($pos%COLS) {
		    		  echo '<td>&nbsp;</td>';
					  $pos++;
				      }
		 			 ?>
                </tr>
                <!-- Navigation link needs to go here -->
                <tr>
                    <td><?php
		            // create a back link if current page greater than 0
				    if ($curPage > 0) {
					  echo '<a href="'.$_SERVER['PHP_SELF'].'?curPage='.($curPage-1).'">&lt; Prev</a>';
					  }
				    // otherwise leave the cell empty
				    else {
					  echo '&nbsp;';
					  }
				     ?>
					</td>
					<?php
				    // pad the final row with empty cells if more than 2 columns
				    if (COLS-2 > 0) {
					  for ($i = 0; $i < COLS-2; $i++) {
					    echo '<td>&nbsp;</td>';
					    }
					  }
				    ?>
					<td><?php
				    // create a forwards link if more records exist
				    if ($startRow+SHOWMAX < $totalPix) {
					  echo '<a href="'.$_SERVER['PHP_SELF'].'?curPage='.($curPage+1).'">Next &gt;</a>';
					  }
				    // otherwise leave the cell empty
				    else {
					  echo '&nbsp;';
					  }
				    ?>
                    </td>
                </tr>
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
