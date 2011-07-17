<?php
/*
 * API connector to gCal class
 * 
 * =Examples=
 * 1.) Grab all exclusive Churchwide events:
 *	$url/api/gcal/grabevents.php?cal=churchwide
 * 2.) Grab all exclusive Churchwide events and only 'featured' events from Koinonia and YA calendars:
 *	$url/api/gcal/grabevents.php?cal=churchwide,koinonia,ya&shows=,featured,featured
 * 3.) Grab all exclsive events from Kairos calendar:
 *	$url/api/gcal/grabevents.php?cal=kairos
 * 4.) Grab Kairos 2 & 3 events from Kairos calendar and PM times from Churchwide calendar:
 *	$url/api/gcal/grabevents.php?cal=kairos,churchwide&tags=kairos2-kairos3,pm
/* ---------------------------------------------------------------------------------- */

require('gcalweb.class.php');

$gcal = new gCalWeb($_GET['cal'], array(
	'shows' => $_GET['shows'],
	'tags' => $_GET['tags'],
	'startdate' => $_GET['startdate'],
	'numdays' => $_GET['numdays']
));

$displaytype = $_GET['displaytype'];
if (!$displaytype) $displaytype = 'standard';
eval('echo $gcal->' . $displaytype . 'Display();');

?>

