<?php
/* 
 * gCal "Web" Extension
 * Abe Yang <abeyang@cal.berkeley.edu> (c) 2006  
 * http://code.google.com/p/gcal-php-framework/
/* ---------------------------------------------------------------------------------- */

// custom functions used for displaying gcal events
// precondition: events (array) must be fed in to desired function
// postcondition: string to be displayed will be concatenated with all events

/* Standard Display
 * Used for most websites (including main website)
 *
 * =Additional Params=
 * 'displaytag' = displays tag in subject line (default = 0)
 *
 * Blog Display
 * Display events in blog style
/* ---------------------------------------------------------------------------------- */
require_once('gcal.class.php');
require_once(GCAL_PATH . '../textile.php');

class gCalWeb extends gCal {
	// global var
	var $textile;
	
	// rss feeds
	var $rsstitle;
	var $rssdesc;
	var $rsslink;

	function gCalWeb($cals, $options = array()) {
		parent :: gCal($cals, $options);
		
		$this->rsstitle = $options['title'];
		$this->rssdesc = $options['desc'];
		$this->rsslink = $options['link'];
		
		$this->textile = new Textile;
	} // end gCalWeb()

	function standardDisplay() {
		$events = $this->events;
		if (!$events) return '';
		foreach($events as $event) {
			$this_id = $event['cal'].'_'.$event['id'];

			// display tag?
			if ( $_GET['displaytag'] && $event['tag'] ) {
				$displaytag = ucwords($event['tag']);
				// create space b/n word and number
				// ex: "Kairos2" => "Kairos 2"
				// however, checks only the last number
				// so "A2F" does NOT become "A 2F"; "A2F1" => "A2F 1"
				if (is_numeric(substr($displaytag, -1, 1)))
					$displaytag = substr($displaytag, 0, -1).' '.substr($displaytag, -1, 1);
				// add space
				$displaytag .= ' ';
			}
			else $displaytag = '';

			// construct content
			// TODO: USE $this->textile->TextileThis($event['content']) ?
			if ($event['content']) {
				$title = '<a href="javascript:;" onclick="ToggleSlide(\'block'.$this_id.'\')">'.$displaytag.$event['title'].'</a>';
				$content = '<div id="block'.$this_id.'" style="display: none;"><div><blockquote class="medFont">'.$this->textile->TextileThis($event['content']).'</blockquote></div></div>';
			}
			else {
				$title = $displaytag.$event['title'];
			}

			// display event title and extra info
			$tagtext = $event['tag'] == '' ? '' : ' class="cal-'.strtolower($event['tag']).'"';
			$displaystring .= '<li'.$tagtext.'><strong class="medFont">'.$title.'</strong>';
			$displaystring .= $content;

			// display date/time
			$displaystring .= '<div class="medFont">';
			$displaystring .= $this->displayTime($event);
			$displaystring .= '</div>';

			// display location & map (if it exists)
			$displaystring .= '<div class="medFont">' . $event['location'] . $this->displayMap($event['address']) . '</div>';

			if ($this->debug) {
				$displaystring .= '<div class="medFont">Public: '.$event['public'].'</div>';
				$displaystring .= '<div class="medFont">Important: '.$event['important'].'</div>';
				$displaystring .= '<div class="medFont">Address: '.$event['address'].'</div>';
				$displaystring .= '<div class="medFont">Cal: '.$event['cal'].'</div>';
				$displaystring .= '<div class="medFont">Tag: '.$event['tag'].'</div>';
			}

			$displaystring .= '</li>';
		} //end foreach
	
		return $displaystring;
	} // end standardDisplay()

	function blogDisplay() {
		$events = $this->events;
		if (!$events) return '';
		foreach($events as $event) {
			$displaystring .= '<h2>' . $event['title'] . '</h2>';
			$displaystring .= '<div class="gcal-time">When: ' . $this->displayTime($event) . '</div>';
			if ($event['location']) {
				$displaystring .= '<div class="gcal-location">Where: ' . $event['location'] . $this->displayMap($event['address']) . '</div>';
			}
			$displaystring .= '<div class="gcal-content">' . $this->textile->TextileThis($event['content']) .'</div>';
		} // end foreach
		
		return $displaystring;
	} // end blogDisplay()
	
	// requires:
	// jquery - http://jquery.com
	function widgetDisplay() {
		$events = $this->events;
		if (!$events) return '';
		$olddate = '';
		$displaystring .= '<div class="gcal-widget-post">';

		foreach($events as $event) {
			$this_id = $event['cal'].'_'.$event['id'];
			$start = $event['starttime'];
			// check for new dates
			$newdate = date('l, F j', $start);
			if (strcmp($newdate, $olddate)) {
				// $newdate != $olddate
				$displaystring .= '<div class="gcal-widget-date">' . $newdate . '</div>';
				$olddate = $newdate;
			}
			$displaystring .= '<div class="gcal-widget-event"><span class="gcal-widget-time">' . date('g:ia', $start) . '</span><div class="gcal-widget-title">';
			if ($event['location'] || $event['content']) {
				$displaystring .= '<a href="javascript:;" onclick="$(\'#block'. $this_id .'\').slideToggle(\'slow\');">' . $event['title'] . '</a></div>'; // close .gcal-widget-title
                                $displaystring .= '<div id="block' . $this_id . '" class="gcal-widget-block" style="display:none;">';

				if ($event['location']) {
					$displaystring .= '<div class="gcal-widget-location">' . $event['location'] . $this->displayMap($event['address']) . '</div>';
				}
				$displaystring .= '<div class="gcal-widget-content">' . $this->textile->TextileThis($event['content']) .'</div>';
				$displaystring .= '</div>'; // close .gcal-widget-block
			}
			else $displaystring .= $event['title'] . '</div>'; // close .gcal-widget-title
			$displaystring .= '</div>'; // close (.gcal-widget-date or .gcal-widget-event) 
			

		} // end foreach
		
		$displaystring .= '</div>'; // close .gcal-widget-post
		return $displaystring;
	} // end widgetDisplay()
		

	// requires:
	// jquery - http://jquery.com
	// tiptip - http://code.drewwilson.com/entry/tiptip-jquery-plugin
	function widgetDisplay_steel() {
		$events = $this->events;
		if (!$events) return '';
		$olddate = '';
		$oldmonth = '';
		$displaystring .= '<div class="gcal-widget-post">';

		foreach($events as $event) {
			$this_id = $event['cal'].'_'.$event['id'];
			$start = $event['starttime'];
			// check for new dates
			$newdate = date('D, F j', $start);
			$date_day = date('D', $start);
			$date_num = date('j', $start);
			$date_month = date('F', $start);
			if (strcmp($date_month, $oldmonth)) {
				$displaystring .= '<div class="gcal-widget-month">' . $date_month . '</div>';
				$oldmonth = $date_month;
			}
			
			// .featured (or .entry)
			$entryclass = ($event['isfeatured']) ? 'featured' : 'entry';
			$displaystring .= '<div class="gcal-widget-' . $entryclass . ' clearfix class="tooltip" title="' . $event['content'] . '">';
            
			if ($event['content'] || $event['post_link']) {
			    if ($event['post_link']) {
                    $class = 'gcal-tip linkable';
                    $href = $event['post_link'];
                }
                else {
                    $class = 'gcal-tip';
                    $href = '#';
                }
                
			    $displaystring .= '<a href="' . $href . '" class="' . $class . '"><span class="hide">';
			    if ($event['content']) {
                    $displaystring .= $this->textile->TextileThis($event['content']);
			    }
                if ($event['post_link']) {
                    $displaystring .= '<p class="gcal-important">Click the blue icon for more info</p>';
                }

                $displaystring .= '</span></a>';
            }
			
			$displaystring .= '<div class="gcal-widget-day">' . $date_day . '</div>';	// "Tuesday"
			
			// .date-time
			$displaystring .= '<div class="gcal-widget-datetime">';
			$displaystring .= '<div class="gcal-widget-date">' . $date_num . '</div>';
			if (strcmp(date('g:ia', $start), '12:00am')) {
				$am_pm = substr(date('a', $start), 0, 1);
				$displaystring .= '<span class="gcal-widget-time">' . date('g:i', $start) . $am_pm . '</span>';
			}
			$displaystring .= '</div>'; // end .date-time
			
			// .event
			$displaystring .= '<div class="gcal-widget-event">';
			$displaystring .= '<div class="gcal-widget-title">';
			$displaystring .= $event['title'];
			$displaystring .= '</div>'; // end .gcal-widget-title

           	if ($event['location']) {
				$displaystring .= '<span class="gcal-widget-location">' . $event['location'] . '</span>';
			}
			// $displaystring .= '<div class="gcal-widget-content">' . $this->textile->TextileThis($event['content']) .'</div>';
			$displaystring .= '</div>'; // end (.gcal-widget-date or .gcal-widget-event) 
			$displaystring .= '</div>'; // end .featured (or .entry)

   		} // end foreach

		$displaystring .= '</div>'; // end .gcal-widget-post
		return $displaystring;
	} // end widgetDisplay_steel()


	function calendarDisplay() {
		$events = $this->events;
		if (!$events) return '';
		foreach($events as $event) {
			// specialized time/date format
			$start = $event['starttime'];
			$end = $event['endtime'];
			$featured = $event['isfeatured'] ? ' gcal-calendar-featured' : '';
			$timestring = '<div class="gcal-calendar-date">' . "\n";
			
			$timestring .= '<div class="gcal-calendar-day">' . date('l', $start) . '</div>';
			if ($event['allday']) {
				$timestring .= '<h3>' . date('M', $start) . '</h3>';

				if ($start != $end)
					$timestring .= '<h3>' . date('j', $start) . ' - ' . date('j', $end) . '</h3>';
				else $timestring .= '<h2>' . date('j', $start) . '</h2>';
			}
			else {
				$timestring .= '<h3>' . date('M j', $start) . '</h3>';
				if ($start == $end) 
					$timestring .= date('g:ia', $start);
				else if (date('D n/j', $start) == date('D n/j', $end)) 
					$timestring .= date('g:i', $start) . '-' . date('g:ia', $end);
				else $timestring .= '<h3>' . date('j', $start) . ' - ' . date('j', $end) . '</h3>';
				// the above is incorrect
			}
			$timestring .= '</div>' . "\n\n";
			
			// event
			$displaystring .= '<div class="gcal-calendar clearfix' . $featured . '">';
			$displaystring .= $timestring;
			$displaystring .= '<div class="gcal-calendar-prose">';
			$displaystring .= '<h2>' . $event['title'] . '</h2>';
			//$displaystring .= '<div class="gcal-time">When: ' . $this->displayTime($event) . '</div>';
			if ($event['location']) {
				$displaystring .= '<div class="gcal-calendar-location">at ' .  $this->displayMap($event['address'], $event['location'], '', '', true) . '</div>';
			}
			$displaystring .= '<div class="gcal-calendar-content">' . $this->textile->TextileThis($event['content']) .'</div>';
			$displaystring .= '</div></div>';
		} // end foreach
		
		return $displaystring;
	} // end calendarDisplay()
	
	/* prereq: must be wrapped b/n <?xml version="1.0"?> */
	function rssDisplay() {
		$displaystring .='<rss version="2.0"><channel><language>en-us</language>';
		$displaystring .= '<title>' . $this->rsstitle . '</title><link>' . $this->rsslink . '</link><description>' . $this->rssdesc . '</description><pubDate>Fri, 19 Sep 2008 04:43:11 +0000</pubDate>';
		
		$events = $this->events;
		if (!$events) return '';
		foreach($events as $event) {
			$location = $event['location'];
			if ($location) $location = ' @ ' . $location;
			
			$displaystring .= '<item>';
			$displaystring .= '<title>' . $this->rssDate($event['starttime'], 'dateonly') . $event['title'] . '</title>';
			$displaystring .= '<description>' . $this->rssDate($event['starttime'], 'timeonly') . $location . '</description>';
			$displaystring .= '<pubDate>' . $this->rssDate($event['starttime']) . '</pubDate>';
			$displaystring .= '</item>';
		}
		$displaystring .= '</channel></rss>';
		
		return $displaystring;
	} // end rssDisplay()
	
	// ----------------------------------------------------------------------------------
	// helper functions
	// ----------------------------------------------------------------------------------
	
	function displayTime($event, $dayformat = 'D n/j', $timeformat = 'g:ia') {
		$str = '';
		$start = $event['starttime'];
		$end = $event['endtime'];
		
		if ($event['allday']) {
			$str .= date($dayformat, $start);
			if ($start != $end)
				$str.= ' - '.date($dayformat, $end);
		}
		else if ($start == $end) 
			$str .= date($dayformat .', ' . $timeformat, $start);
		else if (date($dayformat, $start) == date($dayformat, $end)) 
			$str .= date($dayformat .', ' . $timeformat, $start).date('-' . $timeformat, $end);
		else 	$str .= date($dayformat, $start).' - '.date($dayformat, $end).', '.date($timeformat, $start);
		
		return $str;
	} // end displayTime()
	
	function displayMap($address, $maptext = 'map', $prefix = '(', $suffix = ')', $alwaysshowtext = false) {
		$str = '';
		
		if ($address)  {
			$str .= ' <span class="gcal-map">' . $prefix . '<a href="http://maps.google.com/maps?f=q&hl=en&q=';
			$str .= urlencode($address).'" title="'.$address;
			$str .= '" target="_new">' . $maptext . '</a>' . $suffix . '</span>';
		}
		else if ($alwaysshowtext) $str = $maptext;
		
		return $str;
	} // end displayMap()
	
	// for rss: returns something like
	// Sun, 28 Sep 2008 07:22:50 -1900
	function rssDate($time, $type = 'pubdate') {
		if ($type == 'timeonly') $str = 'g:ia';
		else if ($type == 'dateonly') $str = '[D, M j]';
		else $str = 'D, j M Y h:i:s -1900';
		return date($str, $time);
	} // end pubDate()
} // end gCalWeb
?>

