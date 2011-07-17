<?php get_header(); ?>

	<div id="content" class="grid_8">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="page">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
			</div><!-- end entry -->
			
		</div><!-- end post -->
		
		<?php endwhile; endif; ?>
		
	</div><!-- end content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>