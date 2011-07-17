<?php
header("Content-Type: application/xml; charset=UTF-8"); 
// created by: abe yang 9/21/08
// gcal rss
echo '<?xml version="1.0"?>';
require('gcalweb.class.php');
$dir = getcwd();
//$cal = 'churchwide,college,ya,youth,joyland,csueb,ism';
$cal = $_GET['cal'];
$tags = $_GET['tags'];
$numdays = $_GET['numdays'];

// rss feed info
$title = $_GET['title'];
$desc = $_GET['desc'];
$link = $_GET['link'];

if (!$cal) echo 'Calendar not specified!';
if (!$title) $title = 'Upcoming Events';
if (!$desc) $desc = 'Christian Fellowship';
if (!$link) $link = 'http://gracepointonline.org';

$gcal = new gCalWeb($cal, array(
	'debug' => 0,
	'shows' => $shows,
	'tags' => $tags,
	'startdate' => $startdate,
	'numdays' => $numdays,
	'title' => $title,
	'desc' => $desc,
	'link' => $link
));
echo $gcal->rssDisplay();
?>

