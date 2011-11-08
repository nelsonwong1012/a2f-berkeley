<?php
$frontpage_title = 'Christian Fellowship @ UC Berkeley';
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
     Remove this if you use the .htaccess -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php if (is_front_page()) {
    		echo $frontpage_title;
            $id = 'home';
		} elseif (is_search()) {
		    bloginfo('name');?> &raquo; Search Results for: <?php echo wp_specialchars($s, 1);
		} else {
		    wp_title('',true); ?> &#8212; <?php bloginfo('name');
            if (is_page() || is_category()) $id = 'page';
            elseif (is_single()) $id = 'single';
		} ?></title>

<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico?1" />

<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/1120_16_col.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/tipTip.css" />

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.tipTip.js"></script>
<!-- <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.countdown.min.js"></script> -->
<!--
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.mousewheel.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/mwheelIntent.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.jscrollpane.min.js" type="text/javascript" charset="utf-8"></script>
-->

<!-- <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.simplemodal-1.4.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.flickrGallery.js"></script> -->

<!-- <script type="text/javascript">
    $(document).ready(function(){
        $('.buttonrow').click(function() {
            $(this).next().slideDown();
            $(this).next().addClass('grid_8');
            $(this).hide();
        });
        
        $(function(){
            console.log('gcal tiptip');
            $('.gcal-tip').tipTip({
                maxWidth: 500, 
                defaultPosition: 'left', 
                // keepAlive: true,
                delay: 100
            });
        });
        
        if ($('#flickrGallery')) {
            $('#flickrGallery').flickrGallery({
                 api_key: '3ffcc310a6c352bbd6ade08c6c2b7682',
                 photoset_ids: $('#flickrGallery').attr('data-name').split(',')
            });
        }
    });
</script> -->

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' );?>
<!-- wp_head -->
<?php 
    wp_deregister_script('jquery');
    wp_head();
?>

</head>
<body id="<?php echo $id; ?>">
<div id="outer">

    <?php if ($id == 'page') { ?>
            <h1 id="header">
        	    <a href="<?php echo get_option('home'); ?>/"><img src="<?php bloginfo('template_url'); ?>/images/a2f_logo_ppl_460.png" width="460" height="197" alt="<?php bloginfo('name'); ?>" /></a>
            </h1>
        </a>
    <?php } //endif is_page ?>

	<div id="wrapper" class="container_16 clearfix">
        <?php if ($id != 'page') { ?>
	    <!-- left section -->
        <div id="photo-sidebar" class="grid_3">
            <h2 class="header_section">
                <!--We are a <br /><strong>Christian group</strong> on the Berkeley campus. We have fun together, take trips, ask the tough questions, and study the Bible.
                <div style="height:40px;">&nbsp;</div>-->
        		<div id="navlinks">
            		<a href="<?php echo get_permalink( 3158 ); ?>">About Us &#183;</a>
        			<a href="<?php echo get_permalink(3839); ?>">Signups &#183;</a>
        			<a href="<?php echo get_permalink(3142); ?>">Past Posts &#183;</a>
        		</div>
            </h2>
            
            <div id="facebook-icon">
        		<a href="http://www.facebook.com/acts2fellowship" target="_blank">
        			<img src="<?php bloginfo('template_url'); ?>/images/facebook-button.png" alt="Visit Our Facebook Page!"/>
        		</a>
        	</div>
        	
        	<div class="section">
            	<h3>Get Connected</h3>
            	<ul>
            	    <li><a href="/berkeley/office-hours"><img src="<?php bloginfo('template_url'); ?>/images/office-hours-button.png" width="200" alt="Office Hours with Rick & Sue" /></a></li>
            	    <li><a href="<?php echo get_permalink( 3250 ); ?>"><img src="<?php bloginfo('template_url'); ?>/images/life-groups-btn.png" width="200" alt="Life Groups" /></a></li>
            	    <li><a href="https://spreadsheets.google.com/viewform?hl=en&formkey=dHBsYXpSOVluRHhrbmY0WFZEQnBuZ3c6MQ&ndplr=1" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/c101-btn.png" width="200" alt="Course 101" /></a></li>
            	</ul>
        	</div>
            
            <!--<a href="http://www.facebook.com/acts2fellowship" class="featured-sidebar-button" target="_blank">
                <img src="http://www.acts2fellowship.org/berkeley/wp-content/uploads/2011/08/5154716553_73f45a3f00_o.png" alt="Visit us on Facebook!" />
            </a>-->

            <!--<a href="/berkeley/thrive" class="featured-sidebar-button" target="_blank">
                <img src="http://www.acts2fellowship.org/berkeley/wp-content/themes/a2f-berkeley-2011/images/Thrive_web_button.jpg" alt="Thrive!" />
            </a>-->
            
            <!-- <a href="" class="featured-sidebar-button" target="_blank">
                <img src="http://www.acts2fellowship.org/berkeley/wp-content/themes/a2f-berkeley-2011/images/tabling-signup.jpg" alt="Signup!" />
            </a> -->

            <!-- <a id="nswn-countdown-wrapper" href="http://www.newstudentwelcomenight.com/" target="_blank">
                <h3>NSWN Countdown!</h3>
                <div id="nswn-countdown"></div>
            </a>
            
            <script type="text/javascript" charset="utf-8">
                $(function () {
                    var nswn = new Date(2011, 7, 25);
                    nswn.setHours(17, 00);
                    $('#nswn-countdown').countdown({
                        until: nswn,
                        labels: ['Years', 'Months', 'Weeks', 'Days', 'Hrs', 'Mins', 'Secs'],
                        labels1: ['Year', 'Month', 'Week', 'Day', 'Hr', 'Min', 'Sec']
                    });
                });
            </script> -->
            
            <ul id="left-sidebar-widgets">
            	<?php
            		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('left_sidebar_widget') ) : ?>
            	<?php endif; ?>
            </ul>
            
            <?php #echo sidebar_thumbnails() ?>
        </div>
        <!-- main section -->
        <div class="grid_10">
            <h1 id="header">
                <a href="<?php echo get_option('home'); ?>/">
                    <img src="<?php bloginfo('template_url'); ?>/images/a2f_logo_ppl_460.png" width="460" height="197" alt="<?php bloginfo('name'); ?>" />
                </a>
            </h1>
      	<div id="content" class="grid_8 prefix_1 suffix_1 alpha">
      <?php } //endif !is_page?>
