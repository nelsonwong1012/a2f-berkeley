<link rel="stylesheet" type="text/css" href="style.css" />
<script src="http://www.google.com/jsapi"></script>
<script>
google.load('jquery', '1.3.2');
</script>

<?php
  // created by: abe yang 9/17/06
  // testing page for gcal class

require('gcalweb.class.php');

// $dir = getcwd();
//$cal = 'churchwide,college,ya,youth,joyland,csueb,ism';
$cal = 'riverside';
//$cal = 'churchwide';
$shows = 'normal';
//$tags = 'kairos-kairos2-kairos4';

$startdate = '';
//$startdate = '2006-09-13';
$numdays = 90;

$gcal = new gCalWeb($cal, array(
				'debug' => 0,
				'shows' => $shows,
				'tags' => $tags,
				'startdate' => $startdate,
				'numdays' => $numdays
				));


echo $gcal->widgetDisplay_steel();
?>

