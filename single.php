<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<h2><?php the_title(); ?></h2>

				<div class="post-header grid_8 alpha">
				    <div class="entry-date">
				        <?php the_time('D, M jS') ?>
				    </div>
					<div class="author">
						by <?php the_author_meta('first_name') ?> <?php the_author_meta('last_name') ?>

						<ul class="categories-lg alignright">
					    <?php
					    foreach((get_the_category()) as $category) { 
					        echo '<li class=\'' . $category->cat_name . '\'><a href=\'' . get_category_link($category->cat_ID) . '\' title=\'' . $category->cat_name . '\'>&nbsp;</a></li>'; 
					    } 
					    ?>
					  </ul>
					</div>

                    <!-- post header comments -->
					<div class="entry-comments alignright">
					    <a class="spch-bub-inside" href="<?php comments_link(); ?>">
                            <span class="point"></span>  
                            <em><?php comments_number('0', '1', '%'); ?></em>
                        </a>
					</div>
				</div> <!-- end .post-header -->

				<div class="entry grid_8 alpha">
                
					<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
					
					<?php // get flickr photo gallery, if it exists
					$gallery = getcustom( 'flickr_set' );
					
					if ($gallery) {
				    		echo do_shortcode("[galleria set=$gallery api_key='a23348bd8833108550a80f5f984aa92c']");
					}
					?>	

					<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>

				</div><!-- end .entry -->
			
			</div><!-- end #post -->

			<?php comments_template(); ?>

			<?php endwhile; else: ?>

				<p>Sorry, no posts matched your criteria.</p>

			<?php endif; ?>

	</div> <!-- end #content -->
  </div> <!-- end #single -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>
