<?php
if (array_key_exists('convert', $_POST)) {
  $m = $_POST['month'];
  $d = trim($_POST['day']);
  $y = trim($_POST['year']);
  if (empty($d) || empty($y)) {
    $error = 'Please fill in all fields';
    }
  elseif (!is_numeric($d) || !is_numeric($y)) {
    $error = 'Please use numbers only';
    }
  elseif (($d <1 || $d > 31) || ($y < 1000 || $y > 9999)) {
    $error = 'Please use numbers within the correct range';
    }
  elseif (!checkdate($m,$d,$y)) {
    $error = 'You have used an invalid date';
    }
  else {
    $d = $d < 10 ? '0'.$d : $d;
    $mysqlFormat = "$y-$m-$d";
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Convert date to MySQL format</title>
</head>

<body>
<?php
if ($_POST) { 
  echo '<p>';
  if (isset($error)) {
    echo $error;
    }
  elseif (isset($mysqlFormat)) {
    echo $mysqlFormat;
    }
  echo '</p>';
  }
?>
<form id="form1" name="form1" method="post" action="">
<p>
  <label for="select">Month:</label>
  <select name="month" id="month">
    <?php
    $months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
	ini_set('date.timezone', 'Europe/London');
    $thisMonth = date('n');
    for ($i=1;$i<=12;$i++) { ?>
      <option value="<?php echo $i < 10 ? '0'.$i : $i; ?>"
      <?php if ($i == $thisMonth) {
      echo ' selected="selected"'; } ?>><?php echo $months[$i-1]; ?></option>
    <?php } ?>
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
