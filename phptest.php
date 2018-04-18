<head>
</head>
<body>
	<div id="header">
		<h1>Japan Journey</h1>
	</div>
	<div id="wrapper">
		<ul id="nav">
			<li><a href="index.php" id="here">Home</a></li>
			<li><a href="journal.php">Journal</a></li>
			<li><a href="gallery.php">Gallery</a></li>
			<li><a href="contact.php">Contact</a></li>
		</ul>
		<div id="maincontent">
			<h1>A journey through Japan with PHP </h1>
			<p>Ut fjelrjwlr jerweklr klsrlejwrk jkerjklew rlsdk jfksljfk fdsjdfljsd fkl;fjslfj lslfdjs sjadflskd </p>
			<div id="pictureWrapper">
				<img src="images/water_basin.jpg" alt="Water basin at Ryoanji temple" width="350" height="237" class="picBorder" />
			</div>
			<p>elrkjwe jewrjwekl rwer;welkr werjwe;r werjwer;elw </p>
			<p>Ut fjelrjwlr jerweklr klsrlejwrk jkerjklew rlsdk jfksljfk fdsjdfljsd fkl;fjslfj lslfdjs sjadflskd </p>
			<p>elrkjwe jewrjwekl rwer;welkr werjwe;r werjwer;elw </p>
		</div>
		<div id="footer">
			<p>&copy; 2006 David Powers</p>
		</div>
	</div>                
	</body>

<?php

function doubleIt($number) {

	$number *= 2;
	echo "$number<br />";

}

$number = 4;
doubleIt($number);
echo $number;

?>