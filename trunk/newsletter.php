<?php
/* Abe Yang 10/7/2010
 *
 * Newsletter grabs the latest UPCOMING post, and shows the n latest side posts
 *
 * Manual controls: n = number of recent side posts (defaults to 2)
 * Ex: http://acts2fellowship.org/riverside/newsletter.php?n=6
 *
 * Refer to: http://www.campaignmonitor.com/css/
 * Check this out: http://www.wilsonweb.com/wmt5/html-email-multi.htm
 *
 * This belongs in the theme directory, but in order to use it, there must
 * be a symbolic link from the wp/root directory. This can be done with 
 * this command (from wp directory):
 *
 * ln -s wp-content/themes/a2f/newsletter.php 
 * ************************************************************************ */

require('wp-blog-header.php');

// variables
$groupname = 'acts2fellowship';
$campus = 'Riverside';
$websiteurl = 'http://acts2fellowship.org/riverside';

$mainpostcat = 'Upcoming';				// cateogory name = UPCOMING
$sidepostcat = 'Memories';                       // category name = MEMORIES
$recentsideposts = ($_GET['n']) ? $_GET['n'] : 2;		// number of most recent side posts


$featured = news_post('Signup for Course 101 and Life Groups (Spring Quarter)', 'http://www.acts2fellowship.org/riverside/2011/03/16/sign-up-for-course-101-and-life-groups-for-spring-quarter/', 'http://farm3.static.flickr.com/2462/3888678212_211466ed0d_m.jpg');

$misc = "
	<p>Remember to check out the <a href=\"$websiteurl\">$groupname $campus website</a> throughout the week for updated news. Feel free to comment there as well!</p>
   	<p>Let me know if you're having issues viewing this newsletter. Oh, and if you'd like to unsubscribe to the $groupname mailing list, shoot me an email as well.</p>
";

$css = array(
	'body' => 'background-color: #fff; margin: 0; padding: 0; font-family: Helvetica, Arial; color: #333333;',
	'table' => 'font-size: 12px; line-height: 14px;',
	'td' => 'font-family: Helvetica, Arial; color: #333333;',
	'header' => 'background-color: #0057a4; margin-bottom: 15px;',
	'h1' => 'font-family: Georgia; color: #ffffff; padding: 10px 5px 0;',
	'h2' => 'line-height: 18px;',
	'h3' => 'font-size: 18px; font-weight: normal; color: #000000; text-transform: uppercase; margin: 0 0 8px 0; border-top: 1px solid #000000; border-bottom: 1px solid #dddddd; padding: 10px 0;',
	'img' => 'border: 0; margin-bottom: 10px;',
	'strong' => 'color:#000000;',
	'a' => 'color: #ff9c00; text-decoration: none;'
	);

/* DO NOT MODIFY BELOW */

// helper functions
function style($index) {
	global $css;
	return 'style="' . $css[$index] . '"';
}

function parsetag($index, $content) {
	global $css;
	$tag = '<' . $index;
	return str_replace($tag, $tag . ' ' . style($index), $content);
}

function parsetagattr($index, $attr, $content) {
    $tag = '<' . $index;
	return str_replace($tag, $tag . ' ' . $attr, $content);
}

function parse($content) {
	$content = apply_filters('the_content', $content);
	$content = parsetag('h2', $content);
	$content = parsetag('a', $content);
	$content = parsetag('img', $content);
	$content = parsetag('strong', $content);
	$content = parsetagattr('table', 'width="100%" border="1"', $content);
	return $content;
}

// outputs post title & thumbnail (with permalink) in the sidebar
function news_post($title, $link, $thumb = '') {
    // insert title with link
    $content = '<h2>' . linkto($title, $link) . '</h2>';
	// insert thumbnail (if it exists)
    if ($thumb) {
    	$content .= linktoimage(resizeimage($thumb), $link);	
	}
	
	return $content;
}

// render: main post
query_posts('category_name='.$mainpostcat.'&showposts=1');
if (have_posts()) : while (have_posts()) : the_post(); 
	$title = get_the_title();
	$content = '<h2>' . linkto($title, get_permalink()) . '</h2>';
	$content .= get_the_content();
	
	// parsing time
	$content = parse($content);
endwhile; 
else : 
	$title = 'acts2fellowship newsletter';
	$content = 'No post found';
endif; 

// render: side posts
$sidecontent = '';
query_posts('category_name=' . $sidepostcat . '&caller_get_posts=1&showposts=' . $recentsideposts);
if (have_posts()) : while (have_posts()) : the_post(); 
	$thumbnail = get_post_custom_values('thumbnail');
    if ($thumbnail) $thumbnail = $thumbnail[0];
	
    $sidecontent .= news_post(get_the_title(), get_permalink(), $thumbnail);
	
endwhile; 
endif;

if ($sidecontent) {
	$sidecontent = parse($sidecontent);
}

// get current user info
get_currentuserinfo();
global $user_level;
// admin is 10
// editor is 7
// author is 2
// contributor is 1
// subscriber is 0

$submitted = $_POST['send_email'];

// start email body
$page_html="";
$page_html="
<html>
<head>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
	<title>$title</title>
	
	<style>
	   .FacebookLikeButton { display: none; }
	   #console input[type=\"text\"], #console input[type=\"email\"] { 
	       background: transparent; 
	       border: none;
	       border-bottom: 1px dotted #999; 
	       font-size: 13px;
	       color: #eee;
       }
	   #console td { font-size: 11px; color: #666; }
	</style>

</head>
<body ".style('body').">

  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"". style('body').">
   <tr>
      <td align=\"center\">
                  
         <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"" . style('header') . ">
            <tr>
               <td align=\"center\">
                  
                  <table width=\"760\" height=\"50\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                     <tr>
                        <td ".style('td').">
                        	<h1 ".style('h1').">$groupname $campus Newsletter</h1>
                        </td>
                     </tr>
                  </table>
                  
               </td>
            </tr>
         </table>
         
         <table width=\"760\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
            <tr>
               <td width=\"500\" align=\"left\" valign=\"top\">
                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" ".style('table').">
                     <tr>
                        <td align=\"left\" class=\"mainbar\" ".style('td').">
                           
                           <h3 ".style('h3').">Upcoming</h3>
                           
                           $content
                            
                        </td>
                     </tr>
                  </table>
                  
               </td>

			   <td width=\"20\">&nbsp;</td>
               
               <td width=\"240\" align=\"center\" valign=\"top\" class=\"sidebar\">
                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" ".style('table').">
                     <tr>
                        <td align=\"left\" ".style('td').">

                           	<h3 ".style('h3').">Featured</h3>
    						".parse($featured)."

							<h3 ".style('h3').">Recent Posts</h3>
							
							$sidecontent
                           
                           	<h3 ".style('h3').">Etcetera</h3>
							".parse($misc)."
                           
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
         
      </td>
   </tr>
</table>

</body>
</html>";
// end email body

// start admin console
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000">
    <tr><td align="center">
            
       <table width="760" border="0" cellspacing="0" cellpadding="0">
          <tr>
             <td align="center">
<?php
if ($user_level > 2) {
    // logged in & has the right priviledges
    if (!isset($submitted)) {
        // form has NOT been submitted yet
?>
                <form method="post">
                <table id="console" width="760" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                       <td width="25%">From <br/><input type="email" name="from" style="width: 180px;" value="<?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname . ' <'. $current_user->user_email . '>' ?>" /></td>
                       <td width="25%">BCC <br /><input type="email" name="bcc" style="width: 180px;" value="" /></td>
                       <td width="50%">Subject <br /><input type="text" name="subject" style="width: 280px;" value="<?php echo $title ?>" />
                           <input type="submit" name="send_email" value="Send Email" /></td>
                    </tr>
                </table>
                </form>
<?php
    }
    else {
        // form has been submitted
        $from = $_POST['from'];
        $bcc = $_POST['bcc'];
        $subject = $_POST['subject'];

    	date_default_timezone_set('America/Los_Angeles');   // Abe: is this necessary?
    	$headers = "From: $from\r\n";
    	$headers .= "BCC: $bcc\r\n";
    	$headers .= "Content-Type: text/html";
    	if ( mail('',$subject,$page_html,$headers) ) {
    		echo "The email has been sent!";
    	} else {
    		echo "The email has failed!";
    	}
    }
}
else {
    // NOT logged in yet
    echo "Please log in first";
}
?>
             </td>
          </tr>
       </table>
   </td></tr>
</table>

<?php 
echo $page_html;
?>

