<?php
include('includes/title.inc.php'); 
include('includes/random_image.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Japan Journey<?php if (isset($title)) {echo "&#8212;{$title}";} ?></title>
<link href="assets/journey.css" rel="stylesheet" type="text/css" media="screen" />
<?php
if (isset($imageSize)) {
?>
<style type="text/css">
p#caption {
  width: <?php echo $imageSize[0];?>px;
  }
</style>
<?php } ?>
</head>

<body>
<div id="header">
    <h1>Japan Journey </h1>
</div>
<div id="wrapper">
    <?php include('includes/menu.inc.php'); ?>
    <div id="maincontent">
        <h1>A journey through Japan with PHP </h1>
		<p>Ut enim ad minim veniam, quis nostrud exercitation consectetur adipisicing elit. Velit esse cillum dolore ullamco laboris nisi in reprehenderit in voluptate. Mollit anim id est laborum. Sunt in culpa duis aute irure dolor excepteur sint occaecat.</p>
		<?php if (isset($imageSize)) { ?>
		<div id="pictureWrapper">
		  <img src="<?php echo $selectedImage; ?>" alt="Random image" class="picBorder" <?php echo $imageSize[3]; ?> />
		  <p id="caption"><?php echo $caption; ?></p>
		</div>
		<?php } ?>
        <p>Eu fugiat nulla pariatur. Ut labore et dolore magna aliqua. Cupidatat non proident, quis nostrud exercitation ut enim ad minim veniam.</p>
        <p>Consectetur adipisicing elit, duis aute irure dolor. Lorem ipsum dolor sit amet, ut enim ad minim veniam, consectetur adipisicing elit. Duis aute irure dolor ut aliquip ex ea commodo consequat.</p>
        <p>Quis nostrud exercitation eu fugiat nulla pariatur. Ut labore et dolore magna aliqua. Sed do eiusmod tempor incididunt velit esse cillum dolore ullamco laboris nisi.</p>
    </div>
    <?php include('includes/footer.inc.php'); ?>
</div>
</body>
</html>
