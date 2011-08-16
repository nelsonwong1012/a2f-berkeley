<?php
/**
 * @package WordPress
 * @subpackage Kairos_Riverside
 */
 
add_filter('comments_template', 'legacy_comments');
function legacy_comments($file) {
	if ( !function_exists('wp_list_comments') ) 
		$file = TEMPLATEPATH . '/legacy.comments.php';
	return $file;
}

function gp_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
    <li id="li-comment-<?php comment_ID() ?>" class="comment sadf sdf">
    <div id="comment-<?php comment_ID(); ?>">
    	<div>
    		<div class="comment-author vcard">
    		   <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?> says:
    		</div>
    		<?php if ($comment->comment_approved == '0') : ?>
    		   <em><?php _e('Your comment is awaiting moderation.') ?></em>
    		   <br />
    		<?php endif; ?>

    	</div>

    	<div>
    		<div class="comment-text">
    		    <?php comment_text() ?>
            </div>
            
    		<div class="comment-meta commentmetadata"><?php printf(__('%1$s @ %2$s'), get_comment_date(),  get_comment_time()) ?></div>		

    		<div class="reply">
    		   <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    		</div>

    	</div>
    </div> <!-- end #comment-xyz -->
    </li>

<?php } 

// prints out thumbnails
function sidebar_thumbnails() {
    $str = '<h3>Photos</h3>';
    $query_args = array('category_name' => 'Memories',
			'showposts'     => 5);
	query_posts($query_args);
	$first_thumbnail = 0;
	if (have_posts()) : while (have_posts()) : the_post();
		$custom_fields = get_post_custom();
		$my_custom_field = $custom_fields['thumbnail'];
		if ($my_custom_field)
		{
		  foreach ($my_custom_field as $key => $thumbnail) {
		    $str .= linktoimage(resizeimage($thumbnail), get_permalink());
		  }
		}
//		$thumbnail = getcustom('thumbnail');
//		if ($thumbnail) {
//			echo linktoimage(resizeimage($thumbnail), get_permalink());
//		}
	endwhile; else:
	endif;
	wp_reset_query();
	return $str;
}

// custom functions
function trimstr($str, $limit = 25) {
	if (strlen($str) > $limit) {
		return substr($str, 0, $limit) . '...';
	}
	else return $str;
}

function image($url, $alt='') {
	return '<img src="' . $url . '" alt="' . $alt . '" />';
}

function linkto($name, $link = '#') {
	return '<a href="' . $link . '">' . $name . '</a>';
}

function linktoimage($imgurl, $link, $alt='') {
	return linkto(image($imgurl, $alt), $link);
}

function resizeimage($imgurl, $tosize = '_m') {
	if (strpos($imgurl, 'flickr')) {
		// $imgurl can be smtg like: 
		//	* http://farm3.static.flickr.com/2584/3926130749_52dd4b2f5b_x.jpg, where 'x' is {t,m,b,o}
		//	* http://farm3.static.flickr.com/2584/3926130749_52dd4b2f5b.jpg
		
		if (substr($imgurl, -6, 1) == '_') $index = -6; // if there's an underscore
		else $index = -4;
		
		$imgurl = substr($imgurl, 0, $index) . $tosize . '.jpg'; // change the suffix
	}
	return $imgurl;
	// $display .= '<p>' . linktoimage($thumbnail, get_permalink(), get_the_title()) . '</p>';
}

function getcustom($name) {
	$name = get_post_custom_values($name);
	if ($name) return $name[0];
	else return false;
}
function outputcustom($name) {
	$output = getcustom($name);
	echo $output;
}

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'left_sidebar_widget',
        //'id' => 'top_sidebar',
        'before_widget' => '<li>',
        'after_widget' => '</li>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'right_sidebar_widget',
        //'id' => 'top_sidebar',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}
    
// for making the "read more" link to the post
function new_excerpt_more($post) {
	return;
}
add_filter('excerpt_more', 'new_excerpt_more');
add_filter('login_errors',create_function('$a', "return null;"));
remove_action('wp_head', 'wp_generator');

?>
