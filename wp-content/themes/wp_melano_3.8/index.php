<?php get_header(); ?>

<?php 

	$options = get_option('ct_coo_options');
	$default_page_heading_bg_alt = $options['default_page_heading_bg_alt'];
	$sidebar_config = $options['archive_sidebar_config'];
	$left_sidebar = $options['archive_sidebar_left'];
	$right_sidebar = $options['archive_sidebar_right'];
	$blog_type = $options['archive_display_type'];
	
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
	
	$list_class = $item_class = '';
	
	if ($blog_type == "mini") {
		$item_class = $width;
	} else if ($blog_type == "masonry") {
		if ($sidebar_config == "both-sidebars") {
		$item_class = "col-sm-3";
		} else {
		$item_class = "col-sm-4";
		}
	} else {
		$item_class = $width;
	}
	
	if ($blog_type == "masonry") {
	$list_class .= 'masonry-items first-load grid effect-1';
	} else if ($blog_type == "mini") {
	$list_class .= 'mini-items';
	} else {
	$list_class .= 'standard-items';
	}
	
	if ($blog_type == "masonry") {
	global $ct_include_imagesLoaded;
	$ct_include_imagesLoaded = true;
	}
	
	global $ct_has_blog;
	$ct_has_blog = true;
	
	ct_set_sidebar_global($sidebar_config);

?>

<?php if ( is_front_page() || is_home() ) : ?>

	<div class="inner-page-wrap <?php echo $page_wrap_class; ?> clearfix">
	
		<!-- OPEN page -->
		<?php if ($sidebar_config == "left-sidebar" || $sidebar_config == "right-sidebar") { ?>
		<div class="archive-page col-sm-8 clearfix">
		<?php } else if ($sidebar_config == "both-sidebars") { ?>
		<div class="archive-page col-sm-9 clearfix">
		<?php } else { ?>
		<div class="archive-page clearfix">
		<?php } ?>
		
			<?php if ($sidebar_config == "both-sidebars") { ?>
			<div class="row">
				<div class="page-content col-sm-8 clearfix">
				
					<?php if(have_posts()) : ?>
						
						<div class="blog-wrap">
						
							<!-- OPEN .blog-items -->
							<ul class="blog-items row <?php echo $list_class; ?> clearfix" id="blogGrid">
					
							<?php while (have_posts()) : the_post(); ?>
					
								<?php 
									$post_format = get_post_format($post->ID);
									if ( $post_format == "" ) {
										$post_format = 'standard';
									} 
								?>
								<li <?php post_class('blog-item '.$item_class.' format-'.$post_format); ?>>
									<?php echo ct_get_post_item($post->ID, $blog_type); ?>
								</li>
					
							<?php endwhile; ?>
									
							<!-- CLOSE .blog-items -->
							</ul>
						
						</div>
						
					<?php else: ?>
					
					<h3><?php _e("Sorry, there are no posts to display.", "cootheme"); ?></h3>
						
					<?php endif; ?>
					
					<div class="pagination-wrap">
						<?php echo pagenavi($wp_query); ?>									
					</div>
					
				</div>
				
				<aside class="sidebar left-sidebar col-sm-4">
					<?php dynamic_sidebar($left_sidebar); ?>
				</aside>
			</div>
			<?php } else { ?>
			
			<div class="page-content clearfix">
	
				<?php if(have_posts()) : ?>
					
					<div class="blog-wrap">
					
						<!-- OPEN .blog-items -->
						<ul class="blog-items row <?php echo $list_class; ?> clearfix" id="blogGrid">
				
						<?php while (have_posts()) : the_post(); ?>
				
							<?php 
								$post_format = get_post_format($post->ID);
								if ( $post_format == "" ) {
									$post_format = 'standard';
								} 
							?>
							<li <?php post_class('blog-item '.$item_class.' format-'.$post_format); ?>>
								<?php echo ct_get_post_item($post->ID, $blog_type); ?>
							</li>
				
						<?php endwhile; ?>
								
						<!-- CLOSE .blog-items -->
						</ul>
						
					</div>
				
				<?php else: ?>
				
				<h3><?php _e("Sorry, there are no posts to display.", "cootheme"); ?></h3>
			
				<?php endif; ?>
				
				<div class="pagination-wrap">
					<?php echo pagenavi($wp_query); ?>									
				</div>
				
			</div>
			
			<?php } ?>	
		
		<!-- CLOSE page -->
		</div>
		
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