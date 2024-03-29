<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
	echo 'This post is password protected. Enter the password to view comments.';
	return;
}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<div id="comments" class="grid_8 alpha">
		<h3 class="grid_3 alpha">Comments</h3>
		<p class="grid_5 omega"><?php comments_number('Be the first to comment!', '1 comment so far.', '% comments so far.' );?>
		<a href="#respond">Enter yours below</a>.</p>
	</div>

	<ol class="commentlist grid_8 alpha">
	<?php wp_list_comments('type=comment&callback=gp_comments'); ?>
	</ol>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<a name="respond"> </a>
<div id="respond" class="grid_8 alpha">

<h3 class="grid_3 alpha"><?php comment_form_title( 'Your Voice' ); ?></h3>
<p class="grid_5 omega">Please be cordial.</p>

<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	<div id="the_form" class="grid_8 alpha">
		<div class="grid_4 alpha">
			<?php if ( $user_ID ) : ?>
			Name <small>(<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">log out</a>)</small>
			<br /><cite><?php echo $user_identity; ?></cite>

			<?php else : ?>

			<label for="author">Name</label>
			<br /><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" class="grid_8 alpha" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />

			<label for="email">E-mail <small>(won't be published)</small></label>
			<br /><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" class="grid_8 alpha" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />

			<label for="url">Website <small>(optional)</small></label>
			<br /><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" class="grid_8 alpha" tabindex="3" />
			
			<?php endif; ?>
			<!-- <p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p> -->
		</div>

		<div class="grid_8 alpha">
			<label for="comment">Comment</label>
			<textarea name="comment" id="comment" class="grid_8 alpha" rows="4" tabindex="4"></textarea>
			
			<div class="grid_8 alpha alignright">
				<input name="submit" type="submit" id="submit" tabindex="5" value="Send Comment" />				
			</div>
			<?php comment_id_fields(); ?>
		</div>

<?php do_action('comment_form', $post->ID); ?>

	</div> <!-- end #the_form -->
</form>

<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>
