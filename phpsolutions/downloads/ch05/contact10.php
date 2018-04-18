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
  $expected = array('name', 'email', 'comments', 'subscribe', 'interests', 'howhear', 'characteristics');
  // set required fields
  $required = array('name', 'email', 'comments');
  // create empty array for any missing fields
  $missing = array();
  
  // assume that there is nothing suspect
  $suspect = false;
  // create a pattern to locate suspect phrases
  $pattern = '/Content-Type:|Bcc:|Cc:/i';
  
  // function to check for suspect phrases
  function isSuspect($val, $pattern, &$suspect) {
    // if the variable is an array, loop through each element
	// and pass it recursively back to the same function
	if (is_array($val)) {
      foreach ($val as $item) {
	    isSuspect($item, $pattern, $suspect);
	    }
	  }
    else {
      // if one of the suspect phrases is found, set Boolean to true
	  if (preg_match($pattern, $val)) {
        $suspect = true;
	    }
	  }
    }
  
  // check the $_POST array and any sub-arrays for suspect content
  isSuspect($_POST, $pattern, $suspect);
  
  if ($suspect) {
    $mailSent = false;
	unset($missing);
	}
  else {
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
	}
  
  // validate the email address
  if (!empty($email)) {
    // regex to ensure no illegal characters in email address 
	$checkEmail = '/^[^@]+@[^\s\r\n\'";,@%]+$/';
	// reject the email address if it doesn't match
	if (!preg_match($checkEmail, $email)) {
	  array_push($missing, 'email');
	  }
	}
  
  // go ahead only if not suspect and all required fields OK
  if (!$suspect && empty($missing)) {
    // set default values for variables that might not exist
	$subscribe = isset($subscribe) ? $subscribe : 'Nothing selected';
	$interests = isset($interests) ? $interests : array('None selected');
	$characteristics = isset($characteristics) ? $characteristics : array('None selected');
	
    // build the message
    $message = "Name: $name\n\n";
    $message .= "Email: $email\n\n";
    $message .= "Comments: $comments\n\n";
	$message .= "Subscribe: $subscribe\n\n";
	$message .= 'Interests: '.implode(', ', $interests)."\n\n";
	$message .= "How heard of Japan Journey: $howhear\n\n";
	$message .= 'Characteristics associated with Japan: '.implode(', ', $characteristics);

    // limit line length to 70 characters
    $message = wordwrap($message, 70);
    
	// create additional headers
	$additionalHeaders = 'From: Japan Journey<feedback@example.com>';
	if (!empty($email)) {
	  $additionalHeaders .= "\r\nReply-To: $email";
	  }
	
    // send it  
    $mailSent = mail($to, $subject, $message, $additionalHeaders);
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
                <input name="name" id="name" type="text" class="formbox" 
				<?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['name']).'"';} ?>
				/>
            </p>
            <p>
                <label for="email">Email: <?php
				if (isset($missing) && in_array('email', $missing)) { ?>
				<span class="warning">Please enter a valid email address</span><?php } ?>
				</label>
                <input name="email" id="email" type="text" class="formbox" 
				<?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['email']).'"';} ?>
				/>
            </p>
            <p>
                <label for="comments">Comments: <?php
				if (isset($missing) && in_array('comments', $missing)) { ?>
				<span class="warning">Please enter your comments</span><?php } ?>
				</label>
                <textarea name="comments" id="comments" cols="60" rows="8"><?php 
				if (isset($missing)) {
				  echo htmlentities($_POST['comments']);
				  } ?></textarea>
            </p>
			<fieldset id="subscribe">
			<h2>Subscribe to newsletter?</h2>
			<p>
				<input name="subscribe" type="radio" value="Yes" id="subscribe-yes" 
				<?php
				$OK = isset($_POST['subscribe']) ? true : false;
				if ($OK && isset($missing) && $_POST['subscribe'] == 'Yes') { ?>
				checked="checked"
				<?php } ?>
				/>
				<label for="subscribe-yes">Yes</label>
				<input name="subscribe" type="radio" value="No" id="subscribe-no" 
				<?php
				if ($OK && isset($missing) && $_POST['subscribe'] == 'No') { ?>
				checked="checked"
				<?php } ?>
				/>
				<label for="subscribe-no">No</label>
			</p>
			</fieldset>
			<fieldset id="interests">
			<h2>Interests in Japan</h2>
			<div>
			<p>
				<input type="checkbox" name="interests[]" value="Anime/manga" id="anime" 
				<?php
				$OK = isset($_POST['interests']) ? true : false;
				if ($OK && isset($missing) && in_array('Anime/manga', $_POST['interests'])) { ?>
				checked="checked"
				<?php } ?>
				/>
				<label for="anime">Anime/manga</label>
			</p>
			<p>
				<input type="checkbox" name="interests[]" value="Arts & crafts" id="art" 
				<?php
				if ($OK && isset($missing) && in_array('Arts & crafts', $_POST['interests'])) { ?>
				checked="checked"
				<?php } ?>
				/>
				<label for="art">Arts &amp; crafts</label>
			</p>
			<p>
				<input type="checkbox" name="interests[]" value="Judo, karate, etc" id="judo" 
				<?php
				if ($OK && isset($missing) && in_array('Judo, karate, etc', $_POST['interests'])) { ?>
				checked="checked"
				<?php } ?>
				/>
				<label for="judo">Judo, karate, etc</label>
			</p>
			</div>
			<div>
			<p>
				<input type="checkbox" name="interests[]" value="Language/literature" id="lang_lit" 
				<?php
				if ($OK && isset($missing) && in_array('Language/literature', $_POST['interests'])) { ?>
				checked="checked"
				<?php } ?>
				/>
				<label for="lang_lit">Language/literature</label>
			</p>
			<p>
				<input type="checkbox" name="interests[]" value="Science & technology" id="scitech" 
				<?php
				if ($OK && isset($missing) && in_array('Science & technology', $_POST['interests'])) { ?>
				checked="checked"
				<?php } ?>
				/>
				<label for="scitech">Science &amp; technology</label>
			</p>
			<p>
				<input type="checkbox" name="interests[]" value="Travel" id="travel" 
				<?php
				if ($OK && isset($missing) && in_array('Travel', $_POST['interests'])) { ?>
				checked="checked"
				<?php } ?>
				/>
				<label for="travel">Travel</label>
			</p>
			</div>
			</fieldset>
            <p>
				<label for="select">How did you hear of Japan Journey?</label>
				<select name="howhear" id="howhear">
					<option value="No reply" 
					<?php
					if (!$_POST || $_POST['howhear'] == 'No reply') { ?>
					selected="selected"
					<?php } ?>
					>Select one</option>
					<option value="foED"
					<?php
					if (isset($missing) && $_POST['howhear'] == 'foED') { ?>
					selected="selected"
					<?php } ?>
					>friends of ED</option>
					<option value="recommended by friend"
					<?php
					if (isset($missing) && $_POST['howhear'] == 'recommended by friend') { ?>
					selected="selected"
					<?php } ?>
					>Recommended by a friend</option>
					<option value="search engine"
					<?php
					if (isset($missing) && $_POST['howhear'] == 'search engine') { ?>
					selected="selected"
					<?php } ?>
					>Search engine</option>
				</select>
			</p>
			<p>
				<label for="select">What characteristics do you associate with Japan?</label>
				<select name="characteristics[]" size="6" multiple="multiple" id="characteristics">
					<option value="Dynamic"
					<?php
					$OK = isset($_POST['characteristics']) ? true : false;
					if ($OK && isset($missing) && in_array('Dynamic', $_POST['characteristics'])) { ?>
					selected="selected"
					<?php } ?>
					>Dynamic</option>
					<option value="Honest"
					<?php
					if ($OK && isset($missing) && in_array('Honest', $_POST['characteristics'])) { ?>
					selected="selected"
					<?php } ?>
					>Honest</option>
					<option value="Pacifist"
					<?php
					if ($OK && isset($missing) && in_array('Pacifist', $_POST['characteristics'])) { ?>
					selected="selected"
					<?php } ?>
					>Pacifist</option>
					<option value="Devious"
					<?php
					if ($OK && isset($missing) && in_array('Devious', $_POST['characteristics'])) { ?>
					selected="selected"
					<?php } ?>
					>Devious</option>
					<option value="Inscrutable"
					<?php
					if ($OK && isset($missing) && in_array('Inscrutable', $_POST['characteristics'])) { ?>
					selected="selected"
					<?php } ?>
					>Inscrutable</option>
					<option value="Warlike"
					<?php
					if ($OK && isset($missing) && in_array('Warlike', $_POST['characteristics'])) { ?>
					selected="selected"
					<?php } ?>
					>Warlike</option>
				</select>
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
