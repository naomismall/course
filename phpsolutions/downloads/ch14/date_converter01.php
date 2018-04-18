<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Convert date to MySQL format</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
<p>
  <label for="select">Month:</label>
  <select name="month" id="month">
    <option value=""></option>
  </select> 
  <label for="day">Date:</label>
  <input name="day" type="text" id="day" size="2" maxlength="2" />
  <label for="year">Year:</label>
  <input name="year" type="text" id="year" size="4" maxlength="4" />
</p>
<p>
  <input type="submit" name="convert" id="convert" value="Convert" />
</p>
</form>
</body>
</html>
