<?php
/*
Plugin Name: GP Shortcoder
Plugin URI: http://www.kairosfellowship.org/riverside
Description: Shortcode generator with tinyMCE plugins to allow for easier styling and editing for fellowship sites
Version: 1.0
Author: Brian Wang
Author URI: http://www.kairosfellowship.org/riverside
*/

/*
*	Caption position = left, right, bottom
*/

function location_parser ($location) {
	$maplink = null;
	if ($atpos = strpos($location, '@')) {
		$maplink = trim(substr($location, $atpos+1));
		$location = trim(substr($location, 0, $atpos));
	}
	return array($location, $maplink);
}

function resizeflickrimage($imgurl, $tosize = '_m') {
	if (strpos($imgurl, 'flickr')) {
		// $imgurl can be smtg like: 
		//	* http://farm3.static.flickr.com/2584/3926130749_52dd4b2f5b_x.jpg, where 'x' is {t,m,b,o}
		//	* http://farm3.static.flickr.com/2584/3926130749_52dd4b2f5b.jpg

		if (substr($imgurl, -6, 1) == '_') $index = -6; // if there's an underscore
		else $index = -4;

		if (substr($imgurl, -6, 2) == '_b') $imgurl = $imgurl;
		else $imgurl = substr($imgurl, 0, $index) . $tosize . '.jpg'; // change the suffix
	}
	return $imgurl;
}

function photo_large_image($url, $caption) {
	$code = "";
	if ($caption == "") {
		$caption = "&nbsp;";
	}
	
	$code .= "<div class=\"photo xl grid_12\">";
	$code .= "	<img title=\"${caption}\" src=\"${url}\" alt=\"\" width=\"1024\" height=\"681\" />";
	$code .= "	<span class=\"caption grid_12 alpha\">${caption}</span>";
	$code .= "</div>";
	return $code;
}

function photo_single_image($url, $caption, $type) {
	$code = "";
	$url = resizeflickrimage($url, '');
	if ($caption == "") {
		$caption = "&nbsp;";
	}
	
	// switch($type) {
	// 	case 'left':
	// 		$code .= "<div class=\"photo large grid_12\">";
	// 		$code .= 	"<span class=\"caption grid_4 alpha\">${caption}</span>";
	// 		$code .= 	"<div class=\"grid_8 omega\">";
	// 		$code .= 		"<img title=\"${caption}\" src=\"${url}\" alt=\"\" width=\"500\" height=\"333\" />";
	// 		$code .= 	"</div>";
	// 		$code .= "</div>";
	// 		return $code;
	// 	default: // bottom
	// 		$code .= "<div class=\"photo large grid_12\">";
	// 		$code .= "	<div class=\"grid_8 alpha prefix_4\">";
	// 		$code .= "		<img title=\"${caption}\" src=\"${url}\" alt=\"\" width=\"500\" height=\"333\" />";
	// 		$code .= "		<span class=\"caption\">${caption}</span>";
	// 		$code .= "	</div>";
	// 		$code .= "</div>";
	// 		return $code;
	// }
	
	$code .= "<div class=\"photo\">";
	$code .= "	<div>";
	$code .= "		<img title=\"${caption}\" src=\"${url}\" alt=\"\" width=\"500\" height=\"333\" />";
	$code .= "		<span class=\"caption\">${caption}</span>";
	$code .= "	</div>";
	$code .= "</div>";
	return $code;
	
}

function photo_multi_image($url, $url2, $caption) {
	$code = "";
	$url = resizeflickrimage($url, '');
	if ($caption == "") {
		$caption = "&nbsp;";
	}

	$code .= "<div class=\"photo double grid_12\">";
	$code .= "	<div class=\"grid_6 alpha\">";
	$code .= "		<img title=\"${caption}\" src=\"${url}\" alt=\"\" width=\"500\" height=\"333\" />";
	$code .= "	</div>";
	$code .= "	<div class=\"grid_6 omega\">";
	$code .= "		<img title=\"${caption}\" src=\"${url2}\" alt=\"\" width=\"500\" height=\"333\" />";
	$code .= "	</div>";
	$code .= "	<span class=\"caption grid_12 alpha\">${caption}</span>";
	$code .= "</div>";
	return $code;
}


/*
 * cpos (caption position: left, right), type (multi, large),
 *
 */
function shortcode_photo($attr, $content) {	
	extract(shortcode_atts(array(
		'type' => 'singlebottom',
	), $atts));
	
	$url = $attr['url'];
	$url2 = $attr['url2'];
	$type = $attr['type'];
	
	// switch ($attr['type']) {
	//     case 'multi':
	//       	return photo_multi_image($url, $url2, $content);
	// 	case 'large':
	// 		return photo_large_image($url, $content);
	// 	case 'singleleft':
	// 		return photo_single_image($url, $content, 'left');
	// 	default: // singlebottom
			return photo_single_image($url, $content, 'bottom');
	// }
}
add_shortcode('photo', 'shortcode_photo');

function shortcode_event($attr, $content) {
	extract(shortcode_atts(array(
		'title' => 'Please Supply A Valid Title',
	), $attr));
	$code = "";
	$date = $attr['date'];
	$time = $attr['time'];
	$location = $attr['location'];
	$info = $attr['info'];
	
	
	$code .= "<h3>${content}</h3>";
	$code .= "<div class=\"upcoming-block\">";
	$code .= "	<div class=\"upcoming clearfix\">";
	if(!is_null($date)) {
		if(is_null($time)) {
			$code .= "		<div class=\"grid_8 alpha\">";
		}
		else {
			$code .= "		<div class=\"grid_4 alpha\">";
		}
		$code .= "			<div class=\"date\">${date}</div>";
		$code .= "		</div>";
	}
	if(!is_null($time)) {
		$code .= "		<div class=\"grid_4 omega\">";
		$code .= "			<div class=\"time\">${time}</div>";
		$code .= "		</div>";
	}
	if(!is_null($location)) {
		$locarr = location_parser($location);
		$location = $locarr[0];
		$maplink = $locarr[1];
		
		$code .= "		<div class=\"grid_8 alpha\">";
		$code .= "			<div class=\"location\">${location}";
		if(!is_null($maplink)) {
			$code .=	"			<br /><a href=\"http://maps.google.com/?q=${maplink}\" target=\"new\">${maplink}</a>";
		}
		$code .=		"			</div>";
		$code .= "		</div>";
	}
	if(!is_null($info)) {
		$code .= "		<div class=\"grid_8 alpha\">";
		$code .= "			<div class=\"otherinfo\">${info}</div>";
		$code .= "		</div>";
	}
	$code .= "	</div>";
	$code .= "</div>";
	return $code;
}
add_shortcode('event', 'shortcode_event');


/*
*  plugins - Extend the MCE editor
*/

function gpphoto_addbuttons() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", 'add_gpphoto_tinymce_plugin');
     add_filter("mce_buttons", 'register_gpphoto_button');
   }
}
 
function register_gpphoto_button($buttons) {
   array_splice($buttons, 3, 0, array('|', 'gpphoto', 'gpevent', 'hr'));
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_gpphoto_tinymce_plugin($plugin_array) {
   $plugin_array['gpphoto'] = get_bloginfo('wpurl') . '/wp-content/plugins/gpphoto/editor_plugin.js';
   $plugin_array['gpevent'] = get_bloginfo('wpurl') . '/wp-content/plugins/gpevent/editor_plugin.js';
   return $plugin_array;
}
 
// init process for button control
add_action('init', 'gpphoto_addbuttons');

?>
