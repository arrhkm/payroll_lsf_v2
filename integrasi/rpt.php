<?php
//include('../calendar/');
include('calendar/tc_calendar.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../themes/orange/css/style.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-1.3.2.min.js" type="text/javascript"></script>    	
<script type="text/javascript" src="../js/scripts-pack.js"></script>
</head>

<body>
<?php include ("menu.txt"); ?>
<table width="562" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td width="558" align="center">
	<form name="form1" id="form1" method="post" action="list_rpt_day.php">
      <?php
	  $thisweek = date('W');
		$thisyear = date('Y');

		function getDaysInWeek ($weekNumber, $year, $dayStart = 1) {
		  // Count from '0104' because January 4th is always in week 1
		  // (according to ISO 8601).
		  $time = strtotime($year . '0104 +' . ($weekNumber - 1).' weeks');
		  // Get the time of the first day of the week
		  $dayTime = strtotime('-' . (date('w', $time) - $dayStart) . ' days', $time);
		  // Get the times of days 0 -> 6
		  $dayTimes = array ();
		  for ($i = 0; $i < 1; ++$i) {
			$dayTimes[] = strtotime('+' . $i . ' days', $dayTime);
		  }
		  // Return timestamps for mon-sun.
		  return $dayTimes;
		}

		$dayTimes = getDaysInWeek($thisweek, $thisyear);
		//----------------------------------------

		$date4_default = date('Y-m-d', $dayTimes[0]);
		$date5_default = date('Y-m-d', $dayTimes[(sizeof($dayTimes)-1)]);
	
	  $myCalendar = new tc_calendar("date4", true, false);
	  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
	  $myCalendar->setDate(date('d', strtotime($date4_default)), date('m', strtotime($date4_default)), date('Y', strtotime($date4_default)));
	  $myCalendar->setPath("calendar/");
	  $myCalendar->setYearInterval(2011, 2025);
	  //$myCalendar->dateAllow('2009-02-20', "", false);
	  $myCalendar->setAlignment('left', 'bottom');
	  $myCalendar->setDatePair('date4', 'date5', $date5_default);
	  $myCalendar->writeScript();
	  ?>
      <?php
	  /*$myCalendar = new tc_calendar("date5", true, false);
	  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
	  $myCalendar->setDate(date('d', strtotime($date5_default)), date('m', strtotime($date5_default)), date('Y', strtotime($date5_default)));
	  $myCalendar->setPath("calendar/");
	  $myCalendar->setYearInterval(2012, 2025);
	  //$myCalendar->dateAllow("", '2009-11-03', false);
	  $myCalendar->setAlignment('right', 'bottom');
	  $myCalendar->setDatePair('date4', 'date5', $date4_default);
	  $myCalendar->writeScript();*/
	  
	  ?>
      <input name="rd_btn" type="radio" value="S" checked>
Staff
<input name="rd_btn" type="radio" value="P">
DW
      <input name="submit" type="submit" value="submit" />
      </form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
