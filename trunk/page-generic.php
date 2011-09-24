<?php
/*
Template Name: Generic Page
*/
?>

<?php get_header(); ?>
	<div id="content">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	    <h2 class="grid_16"><?php outputcustom('title'); ?></h2>
	    <div class="post" id="post-<?php the_ID(); ?>">
	        <div class="page">
		    <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
		</div><!-- end entry -->
	    
            </div><!-- end post -->
	    <?php endwhile; endif; ?>
	</div><!-- end #content -->

<?php get_footer(); ?>
