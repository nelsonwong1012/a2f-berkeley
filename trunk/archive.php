<?php
/*
Template Name: Archive
*/
?>

<?php get_header(); ?>

	<div id="content">
		<div id="archives">
			<h2 class="grid_16">Archives</h2>
			<ul class="categories-lg clearfix">
			<?php if (single_cat_title('',false) == '') {
					query_posts('cat=-0'); 
					$active = "active";
				}
				else {
					$active = "";
			}
			?>
			<li class="All grid_4 <?php echo $active; ?>"><a href="<?php echo get_permalink(3142)?>"><span>&nbsp;</span>All Categories</a></li>
			<?php 
				$category_ids = get_all_category_ids(); 
				$holding_original_query = clone $wp_query;
				foreach($category_ids as $cat_id) {
					$my_query = new WP_Query("cat=$cat_id");
					if ($my_query->have_posts()) {
						$category_from_id = get_category( $cat_id );
						$cat_slug = $category_from_id->slug;
						$cat_name = $category_from_id->name;
						if (!strcmp($cat_name, single_cat_title('',false))) {
							$active = "active";
						}
						else {
							$active = "";
						}
						echo '<li class="' . $cat_name . ' grid_4 ' . $active . '"><a href="' . get_bloginfo('url') . '/archives/' . strtolower($cat_slug) . '" title="View all posts filed under ' . $cat_name . '"><span>&nbsp;</span>' . $cat_name . '</a> </li>';
					}
				}
				$wp_query = clone $holding_original_query;
				query_posts('cat='.$cat.'&posts_per_page=-1');
			?>
			</ul>

			<?php if (have_posts()) : ?>

			<div class="clear">&nbsp;</div>
			<?php while (have_posts()) : the_post(); ?>
		
			<div class="grid_4">
				<div <?php post_class() ?>>
					<h4 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title_attribute(); ?>"><?php echo trimstr(get_the_title(), 35); ?></a></h4>
					<div class="cats-comments-bar clearfix">
					  <ul class="categories">
      		    <?php
              foreach((get_the_category()) as $category) { 
                  echo '<li class=\'' . $category->cat_name . '\'><a href=\'' . get_category_link($category->cat_ID) . '\' title=\'' . $category->cat_name . '\'>&nbsp;</a></li>'; 
              } 
              ?>
            </ul>
						<span class="post-month"><?php the_time('F') ?></span><span class="post-day"><?php the_time('j') ?></span>
						<a href="<?php comments_link(); ?>" class="comments"><span>&nbsp;</span><?php comments_number('0', '1', '%'); ?></a>
					</div>

					<?php
					$thumbnail = get_post_custom_values('thumbnail');

					if ($thumbnail) {
						echo linktoimage(resizeimage($thumbnail[0]), get_permalink());
						$entryclass = ' small';
					}
					else $entryclass = '';
					?>
				
					<div class="entry<?php echo $entryclass; ?>">
						<?php the_excerpt('') ?>
					</div><!-- end .entry -->

					<p class="postmetadata"><?php the_category(', ') ?> <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>

				</div><!-- end .post -->
			</div><!-- end .grid_4 -->

			<?php endwhile; ?>
		
			<!-- This clears all floats -->
			<div class="clear">&nbsp;</div>

		<?php else :
			if ( is_category() ) { // If this is a category archive
				printf("<h3 class='center'>Sorry, but there aren't any posts in the %s category yet.</h3>", single_cat_title('',false));
			} else if ( is_date() ) { // If this is a date archive
				echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
			} else if ( is_author() ) { // If this is a category archive
				$userdata = get_userdatabylogin(get_query_var('author_name'));
				printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
			} else {
				echo("<h2 class='center'>No posts found.</h2>");
			}
			echo '<a href="' . get_option('home') . '">&larr; Go back to the homepage</a>';
		endif; ?>
		</div> <!-- end #archive -->
	</div><!-- end #content -->

<?php get_footer(); ?>
