<?php
include('includes/title.inc.php');
include('includes/getFirst.inc.php');
include('includes/conn_mysql.inc.php');
// create database connection
$conn = dbConnect('query');
$sql = 'SELECT * FROM journal ORDER BY created DESC';
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
          <p><?php $extract = getFirst($row['article']);
            echo $extract[0];
            if ($extract[1]) {
              echo '<a href="details.php?article_id='.$row['article_id'].'"> More</a>';
              } ?></p>
      <?php } ?>
    </div>
    <?php include('includes/footer.inc.php'); ?>
</div>
</body>
</html>
