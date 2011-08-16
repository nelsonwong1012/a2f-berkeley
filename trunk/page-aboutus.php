<?php
/*
Template Name: AboutUs
*/
get_header();
?>

    <div><h2 class="grid_16"><?php the_title(); ?></h2></div>
	<div id="content" class="grid_16">
	<div id="about_us">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="page">

				<p class="subtitle grid_16 alpha"><?php outputcustom('subtitle'); ?></p>
            
            	<div class="grid_10 alpha">
					<?php 
					$main_img = getcustom('main_img'); 
					if ($main_img) { ?>
                	<img id="hero" src="<?php echo $main_img; ?>"/>
					<?php }?>
                	<p><?php outputcustom('main'); ?></p>
                    
                	<div class="grid_5 alpha">
                    	<h3>Looking for a church?</h3>
                        <p class="shortinfo"><?php outputcustom('church'); ?></p>
                    </div>
	<!--
                    <div class="grid_5 omega">
                    	<h3>The Staff</h3>
                        <p class="shortinfo"><?php outputcustom('staff'); ?></p>
                    </div>
	-->
                    <h3 class="grid_10 alpha">Our Alumni Advisors</h3>
                    <div class="grid_5 alpha">
						<?php 
						$advisors_img = getcustom('advisors_img'); 
						if ($advisors_img) { ?>
                    	<img class="advisor" src="<?php echo $advisors_img; ?>"/>
						<?php }?>
                    	<p><?php outputcustom('advisors'); ?></p>
                    </div>
		<!--
                    <div class="grid_5 omega">
                    	<h3 class="advisor">Rick Yi</h3>
                        
                       	<div class="info clearfix">
                       		<span class="grid_2 alpha info-label">Major</span>
				<span class="grid_3 omega info-desc">Cognitive Science</span>
                       	</div>
			<div class="info clearfix">
                       		<span class="grid_2 alpha info-label">Hometown</span>
				<span class="grid_3 omega info-desc">Hawaii</span>
                       	</div>
			<div class="info clearfix">
                       		<span class="grid_2 alpha info-label">Likes</span>
				<span class="grid_3 omega info-desc">Indian food</span>
                       	</div>
			<div class="info clearfix">
                       		<span class="grid_2 alpha info-label">Special Traits</span>
				<span class="grid_3 omega info-desc">Awesomeness</span>
                       	</div>
                      
                            
			<h3 class="advisor">Sue Yi</h3>
					
			<div class="info clearfix">
                       		<span class="grid_2 alpha info-label">Major</span>
				<span class="grid_3 omega info-desc">Sociology</span>
                       	</div>
			<div class="info clearfix">
                       		<span class="grid_2 alpha info-label">Hometown</span>
				<span class="grid_3 omega info-desc">West LA, CA</span>
                       	</div>
			<div class="info clearfix">
				<span class="grid_2 alpha info-label">Likes</span>
				<span class="grid_3 omega info-desc">Dark chocolate, warm weather</span>
			</div>
			<div class="info clearfix">
                       		<span class="grid_2 alpha info-label">Special Traits</span>
				<span class="grid_3 omega info-desc">Sneezes real loud</span>
                       	</div>
                        
                    </div>
-->
				</div>
                <div class="grid_6 omega">
                	<h3 id="contact-header">Contact Us</h3>
                    
					<?php
					$submitted = $_POST['send_email'];
					if (!isset($submitted)) {
                        // form has NOT been submitted yet
					?>
					<p><?php outputcustom('contact'); ?></p>

					<div id="form">
						<?//php the_content(); ?>
						

						<form method="post" id="msgform">
						  <p><label for="your-name">Name</label>
						      <br /><input type="text" name="your-name" value="" id="your-name" class="required"></p>
						  <p><label for="your-email">Email <small>(for us to contact you)</small></label>
						      <br /><input type="text" name="your-email" value="" id="your-email" class="required email"></p>
						  <p><label for="your-phone">Phone <small>(optional)</small></label>
						      <br /><input type="text" name="your-phone" value="" id="your-phone"></p>
						  <p><label for="your-message">Comments or questions?</label>
						      <br /><textarea name="your-message" id="your-message" rows="10" cols="40" class="required"></textarea></p>

						  <p><input type="submit" name="send_email" value="Contact Us"></p>
						</form>
						
            		</div>
            		
            		<?php
				    }
				    else {
				        // form has been submitted
			            $from = $_POST['your-name'] . '<' . $_POST['your-email'] . '>';
                        $to = 'michael.shuh@gmail.com';
                        $subject = 'message from a2f Berkeley website';
                        $msg = $_POST['your-message'] . "\r\n\r\n" . 'Phone: ' . $_POST['your-phone'];

                    	date_default_timezone_set('America/Los_Angeles');   // Abe: is this necessary?
                    	$headers = "From: $from\r\n";
                    	$headers .= "To: $to\r\n";
                    	$headers .= "Content-Type: text/html";
                    	if ( mail('',$subject,$msg,$headers) ) {
                    		echo "The message has been sent!";
                    	} else {
                    		echo "The message has failed!";
                    	}
				    }
					?>
					
                </div>

			</div><!-- end entry -->
			
		</div><!-- end post -->
		</div class="clear"></div>
		
		<?php endwhile; endif; ?>
	</div>	
	</div><!-- end content -->

<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    $("#msgform").validate();
</script>

<?php get_footer(); ?>
