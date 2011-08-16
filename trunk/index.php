<?php
get_header(); ?>

  	<?php if (have_posts()) : ?>

  		<?php while (have_posts()) : the_post(); ?>
	            <?php //calculate age of post (in days)
                          $post_age_in_days = (time('U') - get_the_time('U'))/(60*60*24); ?>
		    <?php //filter week-old announcements
		          if ($post_age_in_days > 7.0 && in_category(6)) :
                              continue; 
                          endif; ?>
  			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
  				<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
  				
  				<div class="post-header grid_8 alpha">
				    <div class="entry-date">
				        <?php the_time('D, M jS') ?>
				    </div>
					<div class="author">
						by <?php the_author_meta('first_name') ?>

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
  				

  				<div class="entry clearfix grid_8 alpha">
                    <?php
                        // $thumbnail = get_post_custom_values('thumbnail');
                        // $isupcoming = in_category('Upcoming') || in_category('Shorts');
                        //         
                        //  if ($thumbnail && !$isupcoming) {
                        //   echo '<div class="photo large grid_12">' . linktoimage(resizeimage($thumbnail[0], ''), get_permalink()) . '</div>';
                        //  }
                    ?>
  				  <?php
					if ($isupcoming)
						the_content();
					else
						//the_excerpt();
						the_content('');
				  ?>
  				  
  				  <div class="entry-footer grid_8 alpha">
    				<?php if ($isupcoming) { ?>
					<span class="read-more grid_4 alpha">Fin</span>
					<?php } else { ?>
					<a href="<?php the_permalink() ?>" class="read-more grid_4 alpha"><span>Continue reading</span></a>
					<?php } ?>
					<a href="<?php comments_link(); ?>" class="comments grid_4 omega"><span><?php comments_number('&nbsp;', '1', '%'); ?></span> <?php comments_number('Be the first to comment!', 'Comment', 'Comments'); ?></a>
    				</div><!-- end .entry-footer -->
  				</div><!-- end entry -->
  				
  				
  			</div><!-- end post -->

  		<?php endwhile; ?>

  		<?php else : ?>

  		<h2 class="center">Not Found</h2>
  		<p class="center">Sorry, but you are looking for something that isn't here.</p>
  		<?php get_search_form(); ?>

  	<?php endif; ?>

  	</div><!-- end #content -->
  </div><!-- end #home -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>
