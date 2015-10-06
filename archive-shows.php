<?php
/*
Template Name: Template - Shows
*/
?>

<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<!-- Content Information -->
<div class="container-fluid" id="content">
    <!-- Top Information -->
    <div class="row" id="top-content">
        <!-- Sidebar Information -->
        <div class="col-md-4 visible-lg" id="posts-sidebar">
			<?php dynamic_sidebar( 'posts-sidebar' ); ?>
            <aside class="events-list content-box hidden">
                <h3 class="widget-title">Upcoming Events</h3>
				<?php // Display show posts on any page
				$args = array(
					 'post_type' => array('shows') ,
					 'orderby' => 'post_date',
					 'post_status' => 'future',
					 'posts_per_page' => 5,
					 'order' => 'ASC',
				);
				$loop = new WP_Query($args);
				if($loop->have_posts()): while ($loop->have_posts()) : $loop->the_post(); 
				$att_args = array(
					'post_type' => 'attachment',
					'numberposts' => -1,
					'post_status' => null,
					'post_parent' => $post->ID,
				);
				$attachments = get_posts( $att_args ); ?>
                <div class="listing">
                    <div class="row">
                        <div class="eventname col-md-12">
                            <span class="has-text"><?php the_title(); ?></span>
                        <!-- end .eventdate --></div>
                        <div class="eventdate col-md-12">
                            <span class="has-text"><?php the_date(); ?></span>
                        <!-- end .eventname --></div>
                        <div class="eventvenue col-md-12">
                            <span class="has-text"><?php echo get_post_meta($post->ID, "_location", true); ?></span>
                        <!-- end .eventvenue --></div>
                        <div class="col-md-12">
                            <div class="eventposter pull-left">
                                <?php if(has_post_thumbnail()): ?>
                                <a href="<?php echo $attachments[0]->guid; ?>" class="fancybox"><?php _e('View Flyer', THEME_NAME); ?></a>
                                <?php else : ?>
                                <?php _e('No Flyer', THEME_NAME); ?>
                                <?php endif; ?>
                            <!-- end .eventposter --></div>
                            <div class="eventinfo pull-left">
                            	<a href="<?php the_permalink(); ?>" title="Read more" class="post-link">View Info</a>
                            <!-- end .eventinfo --></div>
                            <div class="eventpay pull-left">
                                <?php if(get_post_meta($post->ID, "tickets", true)): { ?>
                                <?php $field_name="tickets"; $field_value = get_post_meta($post->ID, $field_name, true); ?>
                                <a href="<?php echo $field_value; ?>" target="_blank" class="center-block">Tickets</a>
                                <?php ; } endif ?>
                            <!-- end .eventposter --></div>
                        <!-- end .col-md-12 --></div>
                	<!-- end .row --></div>
                <!-- end .listing --></div>
				<?php endwhile; endif; ?>
                <div class="eventmore">
                    <a href="/shows"><span class="has-text">More Shows</span></a>
                <!-- end .eventmore --></div>
            <!-- end .events-list --></aside>
            <aside class="widget widget-inner col-md-12" id="social-widget">
                <div class="widget_execphp">
                    <h3 class="widget-title pull-left">Social</h3>
                    <!-- Tabs Info -->
                    <ul class="pull-right nav nav-tabs" role="tablist" id="social-tabs">
                        <li role="presentation" class="active">
                            <a href="#twitter" class="twitter" aria-controls="twitter" data-toggle="tab"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social-tw.png" alt="" class="img-responsive"></a>
                        <!-- end .presentation --></li>
                        <li role="presentation">
                            <a href="#facebook" class="facebook" aria-controls="facebook" data-toggle="tab"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social-fb.png" alt="" class="img-responsive"></a>
                        <!-- end .presentation --></li>
                        <li role="presentation">
                            <a href="#instagram" class="instagram" aria-controls="instagram" data-toggle="tab"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social-ig.png" alt="" class="img-responsive"></a>
                        <!-- end .presentation --></li>
                        <li role="presentation">
                            <a href="#soundcloud" class="soundcloud" aria-controls="soundcloud" data-toggle="tab"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social-sc.png" alt="" class="img-responsive"></a>
                        <!-- end .presentation --></li>
                    <!-- end #social-tabs --></ul>
                    <!-- Tab Content Info -->
                    <div class="tab-content pull-left">
                        <div role="tabpanel" class="tab-pane fade in active" id="twitter">
                            <a class="twitter-timeline" href="https://twitter.com/delmarrecords" data-chrome="noheader nofooter noborders transparent" data-widget-id="555874098652266498">Tweets by @delmarrecords</a>
                        <!-- end #twitter --></div>
                        <div role="tabpanel" class="tab-pane fade" id="facebook">
                            <div class="facebook-like-box">
                                <div class="fb-like-box" data-href="https://www.facebook.com/pages/Delmar-Records/771111839623270" data-width="370" data-height="350" data-colorscheme="dark" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
                            <!-- end .facebook-like-box --></div>
                        <!-- end #facebook --></div>
                        <div role="tabpanel" class="tab-pane fade" id="instagram">
                            <?php echo do_shortcode('[alpine-phototile-for-instagram id=272 user="delmarrecords" src="user_recent" imgl="instagram" style="vertical" size="M" num="1" align="center" max="100" nocredit="1"]') ?>
                        <!-- end #instagram --></div>
                        <div role="tabpanel" class="tab-pane fade" id="soundcloud">
                            <?php echo do_shortcode('[soundcloud url="https://api.soundcloud.com/users/115515302" params="auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&visual=true" width="100%" height="350" iframe="true" /]') ?>
                        <!-- end #soundcloud --></div>
                    <!-- end .tab-content --></div>            
                <!-- end .widget --></div>
            <!-- end .widget-inner --></aside>
        <!-- end .col-md-4 --></div>
        <!-- Main Content Information -->
    	<div class="col-md-8" id="main-content">
        	<div class="content-box">
				<?php // Get Future and Past Posts
				$future_args = array(
					'post_type' => 'shows',
					'post_status' => 'any'
				);
				$the_query = new WP_Query( $future_args ); ?>
				<?php if ( $the_query->have_posts() ): ?>
                <h2 class="has-title">Shows</h2>	
                <ol class="row isotope">
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <li class="col-md-4 isotope-item transition" id="news-post" data-category="transition">
                        <article class="post">
                            <h3 class="has-title"><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                            <div class="album-thumbnail">
                                <?php the_post_thumbnail( 'large', array('class'=>"img-responsive attachment-post-thumbnail")); ?>
                            <!-- end .thumbnail --></div>
                            <div class="has-text">
                                <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time> <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?>
                                <?php the_content('<div class="btn center-block">Continue Reading</div>'); ?>
                            <!-- end .has-text --></div>
                        <!-- end .post --></article>
                    <!-- end #news-post --></li>
                <?php endwhile; ?>
                <!-- end .row --></ol>
                <?php else: ?>
                <h4 class="has-title">No posts to display</h4>
                <?php endif; ?>
            <!-- end .content-box --></div>
        <!-- end .col-md-8 --></div>
    <!-- end .row --></div>
<!-- end .container-fluid --></div>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>