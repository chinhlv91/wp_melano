<?php
							$options = get_option('ct_coo_options');
							$enable_backtotop = $options['enable_backtotop'];
							$enable_footer = $options['enable_footer'];
							$enable_footer_divider = $options['enable_footer_divider'];
							$enable_copyright = $options['enable_copyright'];
							$enable_copyright_divider = $options['enable_copyright_divider'];
							$show_backlink = $options['show_backlink'];
							$page_layout = $options['page_layout'];
							$footer_config = $options['footer_layout'];
							$copyright_text = __($options['footer_copyright_text'], 'cootheme');
							$enable_footer_promo_bar = $options['enable_footer_promo_bar'];
							$footer_promo_bar_type = $options['footer_promo_bar_type'];
							$footer_promo_bar_text = $options['footer_promo_bar_text'];
							$footer_promo_bar_button_color = $options['footer_promo_bar_button_color'];
							$footer_promo_bar_button_text = $options['footer_promo_bar_button_text'];
							$footer_promo_bar_button_link = $options['footer_promo_bar_button_link'];
							$footer_promo_bar_button_target = $options['footer_promo_bar_button_target'];
							
							global $post, $ct_include_infscroll;
							$remove_promo_bar = false;
							if ($post) {
							$remove_promo_bar = get_post_meta($post->ID, 'ct_remove_promo_bar', true);
							}
							
							$footer_class = $copyright_class = "";
							
							if ($enable_footer_divider) { $footer_class = "footer-divider"; }
							if ($enable_copyright_divider) { $copyright_class = "copyright-divider"; }
						?>
					
					<!--// CLOSE #page-wrap //-->			
					</div>
				
				<!--// CLOSE .container //-->
				</div>





<?php if ($enable_footer_promo_bar && !$remove_promo_bar) { ?>
				<!--// OPEN #base-promo //-->
				<div id="base-promo" class="footer-promo-<?php echo $footer_promo_bar_type; ?>">
					<?php if ($footer_promo_bar_type == "button") { ?>
						<p><?php echo $footer_promo_bar_text; ?></p>
						<a href="<?php echo $footer_promo_bar_button_link; ?>" target="<?php echo $footer_promo_bar_button_target; ?>" class="ct-button dropshadow <?php echo $footer_promo_bar_button_color; ?>"><?php echo $footer_promo_bar_button_text; ?></a>
					<?php } else if ($footer_promo_bar_type == "arrow") { ?>
						<a href="<?php echo $footer_promo_bar_button_link; ?>" target="<?php echo $footer_promo_bar_button_target; ?>"><?php echo $footer_promo_bar_text; ?><i class="ss-navigateright"></i></a>
					<?php } else { ?>
						<a href="<?php echo $footer_promo_bar_button_link; ?>" target="<?php echo $footer_promo_bar_button_target; ?>"><?php echo $footer_promo_bar_text; ?></a>
					<?php } ?>
				<!--// CLOSE #base-promo //-->
				</div>
				<?php } ?>
				
			<!--// CLOSE #main-container //-->
			</div>
						
			<div id="footer-wrap">
			
			<?php if ($enable_footer) { ?>
			
			<!--// OPEN #footer //-->
			<section id="footer" class="<?php echo $footer_class; ?>">
				<div class="container">
					<div id="footer-widgets" class="row clearfix">
						<?php if ($footer_config == "footer-1") { ?>
						<div class="col-sm-3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('footer-column-1'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 3'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 4'); ?>
						<?php } ?>
						</div>
						
						<?php } else if ($footer_config == "footer-2") { ?>
						
						<div class="col-sm-6">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 3'); ?>
						<?php } ?>
						</div>
						
						<?php } else if ($footer_config == "footer-3") { ?>
						
						<div class="col-sm-3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-6">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 3'); ?>
						<?php } ?>
						</div>
						
						<?php } else if ($footer_config == "footer-4") { ?>
						
						<div class="col-sm-6">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-6">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						
						<?php } else if ($footer_config == "footer-5") { ?>
						
						<div class="col-sm-4">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-4">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-4">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 3'); ?>
						<?php } ?>
						</div>
						
						<?php } else if ($footer_config == "footer-6") { ?>
						
						<div class="col-sm-4">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-8">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						
						<?php } else if ($footer_config == "footer-7") { ?>
						
						<div class="col-sm-8">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-4">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						
						<?php } else if ($footer_config == "footer-8") { ?>
						
						<div class="col-sm-3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-6">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						<div class="col-sm-3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 3'); ?>
						<?php } ?>
						</div>
						
						<?php } else { ?>
												
						<div class="col-sm-12">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						
						</div>
						<?php } ?>
						
					</div>
				</div>
			<!--// CLOSE #footer //-->
			</section>	
			<?php } ?>
			
			<?php
				$cootheme_backlink = "";
				if ($show_backlink) {			
				$cootheme_backlink =	apply_filters("cootheme_link", " <a href='http://www.cootheme.com'>Premium WordPress Themes by Cootheme</a>");
				}
			
			if ($enable_copyright) { ?>
			
			<!--// OPEN #copyright //-->
			<footer id="copyright" class="<?php echo $copyright_class; ?>">
				<div class="container">
					<p><?php echo do_shortcode(stripslashes($copyright_text)); ?><?php echo $cootheme_backlink; ?></p>
					<nav class="footer-menu std-menu">
						<?php 
							$footer_menu_args = array(
								'echo'            => true,
								'theme_location' => 'footer_menu',
								'fallback_cb' => ''
							);
							wp_nav_menu( $footer_menu_args );
						?>
					</nav>
				</div>
			<!--// CLOSE #copyright //-->
			</footer>
			
			<?php } ?>
			
			</div>
		
		<!--// CLOSE #container //-->
		</div>

		<?php if ($enable_backtotop) { ?>
		<!--// BACK TO TOP //-->
		<div id="back-to-top" class="animate-top"><i class="fa-angle-up"></i></div>
		<?php } ?>
		
		<!--// FULL WIDTH VIDEO //-->
		<div class="fw-video-area"><div class="fw-video-close"><i class="ss-delete"></i></div></div><div class="fw-video-spacer"></div>
		
		<?php if ($ct_include_infscroll) { ?>
		<div id="inf-scroll-params" data-loadingimage="<?php echo get_template_directory_uri(); ?>/images/loader.gif" data-msgtext="<?php _e("Loading", "cootheme");
		?>" data-finishedmsg="<?php _e("All posts loaded", "cootheme"); ?>"></div>
		<?php } ?>
						
		<!--// FRAMEWORK INCLUDES //-->
		<div id="ct-included" class="<?php echo ct_global_include_classes(); ?>"></div>
		
		<?php if ($options['google_analytics'] != "") {
			echo $options['google_analytics'];
		} ?>
			
		<!--// WORDPRESS FOOTER HOOK //-->
		<?php wp_footer(); ?>

	
	<!--// CLOSE BODY //-->
	</body>


<!--// CLOSE HTML //-->
</html>