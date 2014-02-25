<?php get_header(); ?>

<?php	
	$member_position = get_post_meta($post->ID, 'ct_team_member_position', true);
	$member_email = get_post_meta($post->ID, 'ct_team_member_email', true);
	$member_phone = get_post_meta($post->ID, 'ct_team_member_phone_number', true);
	$member_twitter = get_post_meta($post->ID, 'ct_team_member_twitter', true);
	$member_facebook = get_post_meta($post->ID, 'ct_team_member_facebook', true);
	$member_linkedin = get_post_meta($post->ID, 'ct_team_member_linkedin', true);
	$member_skype = get_post_meta($post->ID, 'ct_team_member_skype', true);
	$member_google_plus = get_post_meta($post->ID, 'ct_team_member_google_plus', true);
	$member_instagram = get_post_meta($post->ID, 'ct_team_member_instagram', true);
	$member_dribbble = get_post_meta($post->ID, 'ct_team_member_dribbble', true);
	$member_image_url = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
	
	$show_page_title = get_post_meta($post->ID, 'ct_page_title', true);
	$page_title_style = get_post_meta($post->ID, 'ct_page_title_style', true);
	$page_title = get_post_meta($post->ID, 'ct_page_title_one', true);
	$page_subtitle = get_post_meta($post->ID, 'ct_page_subtitle', true);
	$page_title_bg = get_post_meta($post->ID, 'ct_page_title_bg', true);
	$fancy_title_image = rwmb_meta('ct_page_title_image', 'type=image&size=full');
	$page_title_text_style = get_post_meta($post->ID, 'ct_page_title_text_style', true);
	$fancy_title_image_url = "";
	
	if ($show_page_title == "") {
		$show_page_title = $default_show_page_heading;
	}
	if ($page_title_bg == "") {
		$page_title_bg = $default_page_heading_bg_alt;
	}
	if ($page_title == "") {
		$page_title = get_the_title();
	}
	
	foreach ($fancy_title_image as $detail_image) {
		$fancy_title_image_url = $detail_image['url'];
		break;
	}
?>

<?php if ($show_page_title) { ?>	
	<div class="row">
		<?php if ($page_title_style == "fancy") { ?>
		<?php if ($fancy_title_image_url != "") { ?>
		<div class="page-heading fancy-heading col-sm-12 clearfix alt-bg <?php echo $page_title_text_style; ?>-style fancy-image" style="background-image: url(<?php echo $fancy_title_image_url; ?>);" data-stellar-background-ratio="0.5">
		<?php } else { ?>
		<div class="page-heading fancy-heading col-sm-12 clearfix alt-bg <?php echo $page_title_bg; ?>">
		<?php } ?>
			<div class="heading-text">
				<h1><?php echo $page_title; ?></h1>
				<?php if ($page_subtitle) { ?>
				<h3><?php echo $page_subtitle; ?></h3>
				<?php } ?>
			</div>
		</div>
		<?php } else { ?>
		<div class="page-heading col-sm-12 clearfix alt-bg <?php echo $page_title_bg; ?>">
			<div class="heading-text">
				<h1><?php echo $page_title; ?></h1>
			</div>
			<?php 
				// BREADCRUMBS
				if (!$remove_breadcrumbs) {
					echo ct_breadcrumbs();
				}
			?>
		</div>
		<?php } ?>
	</div>
<?php } ?>

<div class="inner-page-wrap clearfix">

	<?php if (have_posts()) : the_post(); ?>

		<!-- OPEN article -->
		<article <?php post_class('clearfix '); ?> id="<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Person">
			
			<div class="entry-title" itemprop="name"><?php echo $page_title; ?></div>
			
			<figure class="profile-image-wrap">
				<?php $detail_image = aq_resize( $member_image_url, 440, NULL, true, false); ?>
				
				<?php if ($detail_image) { ?>
					
				<img itemprop="image" src="<?php echo $detail_image[0]; ?>" width="<?php echo $detail_image[1]; ?>" height="<?php echo $detail_image[2]; ?>" />
					
				<?php } ?>
			</figure>			
			
			<section class="article-body-wrap">
				<div class="body-text">
					<h4 class="member-position" itemscope="jobTitle"><?php echo $member_position; ?></h4>
					<?php the_content(); ?>
					<ul class="member-contact">
						<?php if ($member_email) {?><li><i class="ss-mail"></i><span itemscope="email"><a href="mailto:<?php echo $member_email; ?>"><?php echo $member_email; ?></a></span></li><?php } ?>
						<?php if ($member_phone) {?><li><i class="ss-phone"></i><span itemscope="telephone"><?php echo $member_phone; ?></span></li><?php } ?>
					</ul>
					<ul class="social-icons">
						<?php if ($member_twitter) {?><li class="twitter"><a href="http://www.twitter.com/<?php echo $member_twitter; ?>" target="_blank"><i class="fa-twitter"></i><i class="fa-twitter"></i></a></li><?php } ?>
						<?php if ($member_facebook) {?><li class="facebook"><a href="<?php echo $member_facebook; ?>" target="_blank"><i class="fa-facebook"></i><i class="fa-facebook"></i></a></li><?php } ?>
						<?php if ($member_linkedin) {?><li class="linkedin"><a href="<?php echo $member_linkedin; ?>" target="_blank"><i class="fa-linkedin"></i><i class="fa-linkedin"></i></a></li><?php } ?>
						<?php if ($member_google_plus) {?><li class="googleplus"><a href="<?php echo $member_google_plus; ?>" target="_blank"><i class="fa-google-plus"></i><i class="fa-google-plus"></i></a></li><?php } ?>
						<?php if ($member_skype) {?><li class="skype"><a href="skype:<?php echo $member_skype; ?>" target="_blank"><i class="fa-skype"></i><i class="fa-skype"></i></a></li><?php } ?>
						<?php if ($member_instagram) {?><li class="instagram"><a href="<?php echo $member_instagram; ?>" target="_blank"><i class="fa-instagram"></i><i class="fa-instagram"></i></a></li><?php } ?>
						<?php if ($member_dribbble) {?><li class="dribbble"><a href="http://www.dribbble.com/<?php echo $member_dribbble; ?>" target="_blank"><i class="fa-dribbble"></i><i class="fa-dribbble"></i></a></li><?php } ?>
					</ul>
				</div>
			</section>
		
		<!-- CLOSE article -->
		</article>
		
		<ul class="post-pagination-wrap curved-bar-styling clearfix">
			<li class="prev"><?php next_post_link('%link', __('<i class="ss-navigateleft"></i> <span class="nav-text">%title</span>', 'cootheme'), FALSE); ?></li>
			<li class="next"><?php previous_post_link('%link', __('<span class="nav-text">%title</span><i class="ss-navigateright"></i>', 'cootheme'), FALSE); ?></li>
		</ul>

	<?php endif; ?>
	
</div>

<!--// WordPress Hook //-->
<?php get_footer(); ?>