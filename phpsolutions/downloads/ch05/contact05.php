<?php
include('includes/title.inc.php');
include('includes/corefuncs.php');
if (function_exists('nukeMagicQuotes')) {
  nukeMagicQuotes();
  }

// process the email
if (array_key_exists('send', $_POST)) {
  $to = 'me@example.com'; // use your own email address
  $subject = 'Feedback from Japan Journey site';
  
  // list expected fields
  $expected = array('name', 'email', 'comments');
  // set required fields
  $required = array('name', 'comments');
  // create empty array for any missing fields
  $missing = array();
  
  // process the $_POST variables
  foreach ($_POST as $key => $value) {
    // assign to temporary variable and strip whitespace if not an array
    $temp = is_array($value) ? $value : trim($value);
	// if empty and required, add to $missing array
	if (empty($temp) && in_array($key, $required)) {
	  array_push($missing, $key);
	  }
	// otherwise, assign to a variable of the same name as $key
	elseif (in_array($key, $expected)) {
	  ${$key} = $temp;
	  }
	}
 
  // go ahead only if all required fields OK
  if (empty($missing)) {
    // build the message
    $message = "Name: $name\n\n";
    $message .= "Email: $email\n\n";
    $message .= "Comments: $comments";

    // limit line length to 70 characters
    $message = wordwrap($message, 70);
  
    // send it  
    $mailSent = mail($to, $subject, $message);
	if ($mailSent) {
	  // $missing is no longer needed if the email is sent, so unset it
	  unset($missing);
	  }
    }
  }
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
        <h1>Contact us</h1>
		<?php
		if ($_POST && isset($missing)) {
		?>
		<p class="warning">Please complete the missing item(s) indicated.</p>
		<?php
		  }
		elseif ($_POST && !$mailSent) {
		?>
		  <p class="warning">Sorry, there was a problem sending your message. Please try later.</p>
		<?php
		  }
		elseif ($_POST && $mailSent) {
		?>
		  <p><strong>Your message has been sent. Thank you for your feedback.</strong></p>
		<?php } ?>
        <p>Ut enim ad minim veniam, quis nostrud exercitation consectetur adipisicing elit. Velit esse cillum dolore ullamco laboris nisi in reprehenderit in voluptate. Mollit anim id est laborum. Sunt in culpa duis aute irure dolor excepteur sint occaecat.</p>
        <form id="feedback" method="post" action="">
            <p>
                <label for="name">Name: <?php
				if (isset($missing) && in_array('name', $missing)) { ?>
				<span class="warning">Please enter your name</span><?php } ?>
				</label>
                <input name="name" id="name" type="text" class="formbox" />
            </p>
            <p>
                <label for="email">Email:</label>
                <input name="email" id="email" type="text" class="formbox" />
            </p>
            <p>
                <label for="comments">Comments: <?php
				if (isset($missing) && in_array('comments', $missing)) { ?>
				<span class="warning">Please enter your comments</span><?php } ?>
				</label>
                <textarea name="comments" id="comments" cols="60" rows="8"></textarea>
            </p>
            <p>
                <input name="send" id="send" type="submit" value="Send message" />
            </p>
        </form>
	</div>
    <?php include('includes/footer.inc.php'); ?>
</div>
</body>
</html>
