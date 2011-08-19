<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
?>

<div id="sidebar_wrapper">
	
	<div id="sidebar" class="grid_3">
		
        <?php
		require('php/gcal/gcalweb.class.php');
        	$cal = 'a2f';
	        $gcal = new gCalWeb($cal, array(
                'debug' => 0,
      	        	'shows' => 'normal',
              		'numdays' => 7
               ));

       		echo $gcal->widgetDisplay_steel();
        ?>
		
		<h3>Recent Posts</h3>
		<?php

		//The Query
		query_posts('posts_per_page=5&cat=-6&offset=1&ignore_sticky_posts=1'); //cat=-6 to exclude announcements, offset=1 to exclude most recent post, ignore_sticky_post=1 to not show sticky posts

		//The Loop
		if ( have_posts() ) : while ( have_posts() ) : the_post();
		?>
            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="recent-post">
                <h4><?php the_title(); ?></h4>

                <?php
                    $thumbnail = getcustom('thumbnail');

                    if ($thumbnail) {
                        //echo linktoimage(resizeimage($thumbnail), get_permalink());
                        echo image(resizeimage($thumbnail));
                    }
                ?>

                <!-- <div class="cats-comments-bar clearfix">
                    <ul class="categories">
                    <?php
                        // foreach((get_the_category()) as $category) { 
                        //     echo '<li class=\'' . $category->cat_name . '\'><a href=\'' . get_category_link($category->cat_ID) . '\' title=\'' . $category->cat_name . '\'>&nbsp;</a></li>'; 
                        // } 
                    ?>
                    </ul>
                </div> -->
                <span href="<?php comments_link(); ?>" class="comments"><span>&nbsp;</span><?php comments_number('0', '1', '%'); ?></span>
            </a>
		
		<?php
		endwhile; else:

		endif;

		//Reset Query
		wp_reset_query();
		?>
		
		<ul id="right-sidebar-widgets">
			<?php
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('right_sidebar_widget') ) : ?>
			<?php endif; ?>
		</ul>
	</div><!-- end #sidebar -->
</div><!-- end #sidebar_wrapper -->
<div class="clear">&nbsp;</div>

