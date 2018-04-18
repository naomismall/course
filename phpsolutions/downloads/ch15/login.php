<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>
</head>

<body>
<?php
if (isset($error)) {
  echo "<p>$error</p>";
  }
?>
<form id="form1" name="form1" method="post" action="">
    <p>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" />
    </p>
    <p>
        <label for="textfield">Password</label>
        <input type="password" name="pwd" id="pwd" />
    </p>
    <p>
        <input name="login" type="submit" id="login" value="Log in" />
    </p>
</form>
</body>
</html>
