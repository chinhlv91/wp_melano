<?php get_header(); ?>

<?php	
	
	$options = get_option('ct_coo_options');
	$default_show_page_heading = $options['default_show_page_heading'];
	$default_page_heading_bg_alt = $options['default_page_heading_bg_alt'];
	$default_sidebar_config = $options['default_sidebar_config'];
	$default_left_sidebar = $options['default_left_sidebar'];
	$default_right_sidebar = $options['default_right_sidebar'];
	
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
									
	if (!$fancy_title_image) {
		$fancy_title_image = get_post_thumbnail_id();
		$fancy_title_image_url = wp_get_attachment_url( $fancy_title_image, 'full' );
	}
	
	$full_width_display = get_post_meta($post->ID, 'ct_full_width_display', true);
	$show_author_info = get_post_meta($post->ID, 'ct_author_info', true);
	$show_social = get_post_meta($post->ID, 'ct_social_sharing', true);
	$show_related =  get_post_meta($post->ID, 'ct_related_articles', true);
	$remove_breadcrumbs = get_post_meta($post->ID, 'ct_no_breadcrumbs', true);
	
	if ($show_author_info == "") {
		$show_author_info = true;
	}
	if ($show_social == "") {
		$show_social = true;
	}
	
	$sidebar_config = get_post_meta($post->ID, 'ct_sidebar_config', true);
	$left_sidebar = get_post_meta($post->ID, 'ct_left_sidebar', true);
	$right_sidebar = get_post_meta($post->ID, 'ct_right_sidebar', true);
	
	if ($sidebar_config == "") {
		$sidebar_config = $default_sidebar_config;
	}
	if ($left_sidebar == "") {
		$left_sidebar = $default_left_sidebar;
	}
	if ($right_sidebar == "") {
		$right_sidebar = $default_right_sidebar;
	}
	
	ct_set_sidebar_global($sidebar_config);
	
	$page_wrap_class = '';
	if ($sidebar_config == "left-sidebar") {
	$page_wrap_class = 'has-left-sidebar has-one-sidebar row';
	} else if ($sidebar_config == "right-sidebar") {
	$page_wrap_class = 'has-right-sidebar has-one-sidebar row';
	} else if ($sidebar_config == "both-sidebars") {
	$page_wrap_class = 'has-both-sidebars row';
	} else {
	$page_wrap_class = 'has-no-sidebar';
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


<?php if (have_posts()) : the_post(); ?>
	
	<?php		
		$post_author = get_the_author_link();
		$post_date = get_the_date();
		$post_categories = get_the_category_list(', ');
		
		$media_type = $media_image = $media_video = $media_gallery = '';
				 
		$use_thumb_content = get_post_meta($post->ID, 'ct_thumbnail_content_main_detail', true);
		$post_format = get_post_format($post->ID);
		if ( $post_format == "" ) {
			$post_format = 'standard';
		}
		if ($use_thumb_content) {
		$media_type = get_post_meta($post->ID, 'ct_thumbnail_type', true);
		} else {
		$media_type = get_post_meta($post->ID, 'ct_detail_type', true);
		}
		
		if ((($sidebar_config == "left-sidebar") || ($sidebar_config == "right-sidebar") || ($sidebar_config == "both-sidebars")) && !$full_width_display) {
		$media_width = 770;
		$media_height = NULL;
		$video_height = 433;
		} else {
		$media_width = 1170;
		$media_height = NULL;
		$video_height = 658;
		}
		$figure_output = '';
				
		if ($full_width_display) {
			$figure_output .= '<figure class="media-wrap full-width-detail col-sm-12" itemscope>';
		} else {
			$figure_output .= '<figure class="media-wrap" itemscope>';
		}
		
		if ($post_format == "standard") {
						
			if ($media_type == "video") {
						
				$figure_output .= ct_video_post($post->ID, $media_width, $video_height, $use_thumb_content)."\n";
						
			} else if ($media_type == "slider") {
						
				$figure_output .= ct_gallery_post($post->ID, $use_thumb_content)."\n";
					
			} else if ($media_type == "layer-slider") {
						
				$figure_output .= '<div class="layerslider">'."\n";
							
				$figure_output .= do_shortcode('[rev_slider '.$media_slider.']')."\n";
						
				$figure_output .= '</div>'."\n";
						
			} else if ($media_type == "custom") {
												
				$figure_output .= $custom_media."\n";				
						
			} else {
							
				$figure_output .= ct_image_post($post->ID, $media_width, $media_height, $use_thumb_content)."\n";
						
			}
			
		} else {
			
			$figure_output .= ct_get_post_media($post->ID, $media_width, $media_height, $video_height, $use_thumb_content);
									
		}
							
		$figure_output .= '</figure>'."\n";
	?>
	
	<div class="inner-page-wrap <?php echo $page_wrap_class; ?> clearfix">
		
		<?php if ($full_width_display && $media_type != "none") {
			echo $figure_output;
		} ?>
		
		<!-- OPEN article -->
		<?php if ($sidebar_config == "left-sidebar") { ?>
		<article <?php post_class('clearfix col-sm-8'); ?> id="<?php the_ID(); ?>" itemscope itemtype="http://schema.org/BlogPosting">
		<?php } elseif ($sidebar_config == "right-sidebar") { ?>
		<article <?php post_class('clearfix col-sm-8'); ?> id="<?php the_ID(); ?>" itemscope itemtype="http://schema.org/BlogPosting">
		<?php } elseif ($sidebar_config == "both-sidebars")  { ?>
		<article <?php post_class('clearfix col-sm-9'); ?> id="<?php the_ID(); ?>" itemscope itemtype="http://schema.org/BlogPosting">
		<?php } else { ?>
		<article <?php post_class('clearfix row'); ?> id="<?php the_ID(); ?>" itemscope itemtype="http://schema.org/BlogPosting">
		<?php } ?>
			
		<div class="entry-title"><?php echo $page_title; ?></div>
		
		<?php if ($sidebar_config == "both-sidebars") { ?>
		<div class="row">
			<div class="page-content col-sm-8 clearfix">
		<?php } else if ($sidebar_config == "no-sidebars") { ?>
			<div class="page-content col-sm-12 clearfix">
		<?php } else { ?>
			<div class="page-content clearfix">
		<?php } ?>
				
				<ul class="post-pagination-wrap curved-bar-styling clearfix">
					<li class="prev"><?php next_post_link('%link', __('<i class="ss-navigateleft"></i> <span class="nav-text">%title</span>', 'cootheme'), FALSE); ?></li>
					<li class="next"><?php previous_post_link('%link', __('<span class="nav-text">%title</span><i class="ss-navigateright"></i>', 'cootheme'), FALSE); ?></li>
				</ul>
				
				<?php if (!$full_width_display && $media_type != "none") {
					echo $figure_output;
				} ?>
				
				<div class="post-info clearfix">
					<span class="vcard author"><?php echo sprintf(__('Posted by <a href="%2$s" itemprop="author" class="fn">%1$s</a> on <span class="date updated">%3$s</span> in %4$s', 'cootheme'), $post_author, get_author_posts_url(get_the_author_meta( 'ID' )), $post_date, $post_categories); ?></span>
					<?php if ( comments_open() ) { ?>
					<div class="comments-likes">
						<div class="comments-wrapper"><a href="#comments"><i class="ss-chat"></i><span><?php comments_number(__('0 Comments', 'cootheme'), __('1 Comment', 'cootheme'), __('% Comments', 'cootheme')); ?></span></a></div>
					</div>
					<?php } ?>
				</div>
															
				<section class="article-body-wrap">
					<div class="body-text clearfix" itemprop="articleBody">
						<?php the_content(); ?>
					</div>
	
					<div class="link-pages"><?php wp_link_pages(); ?></div>
													
					<div class="tags-link-wrap clearfix">
						<?php if (has_tag()) { ?>
						<div class="tags-wrap"><?php _e("Tags:", "cootheme"); ?><span class="tags"><?php the_tags(''); ?></span></div>
						<?php } ?>
					</div>
					
					<?php if ($show_social) { ?>
					<div class="share-links curved-bar-styling clearfix">
						<div class="share-text"><?php _e("Share this article:", "cootheme"); ?></div>
						<ul class="social-icons">
							<li class="ct-love">
							<div class="comments-likes">
							<?php if (function_exists( 'lip_love_it_link' )) {
								echo lip_love_it_link(get_the_ID(), '<i class="ss-heart"></i>', '<i class="ss-heart"></i>', false);
							} ?>				
							</div>
							</li>
						    <li class="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" class="post_share_facebook" onclick="javascript:window.open(this.href,
						      '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600');return false;"><i class="fa-facebook"></i><i class="fa-facebook"></i></a></li>
						    <li class="twitter"><a href="https://twitter.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
						      '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600');return false;" class="product_share_twitter"><i class="fa-twitter"></i><i class="fa-twitter"></i></a></li>   
						    <li class="googleplus"><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
						      '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa-google-plus"></i><i class="fa-google-plus"></i></a></li>
						    <li class="pinterest"><a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php if(function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&description=<?php echo get_the_title(); ?>"><i class="fa-pinterest"></i><i class="fa-pinterest"></i></a></li>
							<li class="mail"><a href="mailto:?subject=<?php the_title(); ?>&body=<?php echo strip_tags(get_the_excerpt()); ?> <?php the_permalink(); ?>" class="product_share_email"><i class="ss-mail"></i><i class="ss-mail"></i></a></li>
						</ul>						
					</div>					
					<?php } ?>


					<?php if ($show_author_info) { ?>
					
					<div class="author-info-wrap clearfix">
						<div class="author-avatar"><?php if(function_exists('get_avatar')) { echo get_avatar(get_the_author_meta('ID'), '140'); } ?></div>
						<div class="author-bio">
							<div class="author-name" itemprop="author" itemscope itemtype="http://schema.org/Person"><h3><?php _e("About", "cootheme"); ?> <span itemprop="name"><?php the_author_meta('display_name'); ?></span></h3></div>
							<div class="author-bio-text">
								<?php the_author_meta('description'); ?>
							</div>
						</div>
					</div>
					
					<?php } ?>
										
				</section>
				
				<?php if ($show_related) { ?>
				
				<div class="related-wrap">
				<?php
					$categories = get_the_category($post->ID);
					if ($categories) {
						$category_ids = array();
						foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
	
						$args=array(
							'category__in' => $category_ids,
							'post__not_in' => array($post->ID),
							'showposts'=> 4, // Number of related posts that will be shown.
							'orderby' => 'rand'
						);
					}
					$related_posts_query = new wp_query($args);
					if( $related_posts_query->have_posts() ) {	
						_e('<h3 class="spb-heading"><span>'.__("Related Articles", "cootheme").'</span></h3>');
						echo '<ul class="related-items row clearfix">';
						while ($related_posts_query->have_posts()) {
							$related_posts_query->the_post();
							$item_title = get_the_title();
							$thumb_image = "";
							$thumb_image = get_post_meta($post->ID, 'ct_thumbnail_image', true);
							if (!$thumb_image) {
								$thumb_image = get_post_thumbnail_id();
							}
							$thumb_img_url = wp_get_attachment_url( $thumb_image, 'full' );
							$image = aq_resize( $thumb_img_url, 300, 225, true, false);
							?>
							<li class="related-item col-sm-3 clearfix">
								<figure class="animated-overlay overlay-alt">
									<?php if ($image) { ?>
									<img itemprop="image" src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php echo $item_title; ?>" />
									<?php } else { ?>
									<div class="img-holder"><i class="ss-pen"></i></div>
									<?php } ?>
									<a href="<?php the_permalink(); ?>"></a>
									<figcaption>
										<div class="thumb-info thumb-info-alt">						
											<i class="ss-navigateright"></i>
										</div>
									</figcaption>
								</figure>
								<h5><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php echo $item_title; ?></a></h5>
							</li>
						<?php }
						echo '</ul>';
					}
												
					wp_reset_query();
				?>
				</div>
				
				<?php } ?>
				
				<?php if ( comments_open() ) { ?>
				<div id="comment-area">
					<?php comments_template('', true); ?>
				</div>
				<?php } ?>
			
			</div>
			
			<?php if ($sidebar_config == "both-sidebars") { ?>
			<aside class="sidebar left-sidebar col-sm-4">
				<?php dynamic_sidebar($left_sidebar); ?>
			</aside>
			</div>
			<?php } ?>
		
		<!-- CLOSE article -->
		</article>
	
		<?php if ($sidebar_config == "left-sidebar") { ?>
				
			<aside class="sidebar left-sidebar col-sm-4">
				<?php dynamic_sidebar($left_sidebar); ?>
			</aside>
	
		<?php } else if ($sidebar_config == "right-sidebar") { ?>
			
			<aside class="sidebar right-sidebar col-sm-4">
				<?php dynamic_sidebar($right_sidebar); ?>
			</aside>
			
		<?php } else if ($sidebar_config == "both-sidebars") { ?>
	
			<aside class="sidebar right-sidebar col-sm-3">
				<?php dynamic_sidebar($right_sidebar); ?>
			</aside>
		
		<?php } ?>
				
	</div>

<?php endif; ?>

<!--// WordPress Hook //-->
<?php get_footer(); ?>