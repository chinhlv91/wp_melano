<?php
	
	/*
	*
	*	Cootheme Theme Functions
	*	------------------------------------------------
	*	Cootheme v2.0
	* 	http://www.cootheme.com
	*
	*	ct_theme_activation()
	*	ct_bwm_filter()
	*	ct_bwm_filter_script()
	*	ct_filter_wp_title()
	*	ct_maintenance_mode()
	*	ct_custom_login_logo()
	*	ct_breadcrumbs()
	*	ct_language_flags()
	*	ct_hex2rgb()
	*	ct_get_comments_number()
	*	ct_get_category_list()
	*	ct_get_category_list_key_array()
	*	ct_get_woo_product_filters_array()
	*	ct_add_nofollow_cat()
	*	ct_remove_head_links()
	*	ct_global_include_classes()
	*	ct_countdown_shortcode_locale()
	*	ct_admin_bar_menu()
	*	ct_admin_css()
	*
	*/
	
	/* THEME ACTIVATION
	================================================== */	
	if (!function_exists('ct_theme_activation')) {
		function ct_theme_activation() {
			global $pagenow;
			if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
				#set frontpage to display_posts
				update_option('show_on_front', 'posts');
				
				#provide hook so themes can execute theme specific functions on activation
				do_action('ct_theme_activation');
				
				#redirect to options page
				header( 'Location: '.admin_url().'admin.php?page=ct_theme_options&ct_welcome=true' ) ;
			}
		}
		add_action('admin_init', 'ct_theme_activation');
	}
	
	
	/* BETTER WORDPRESS MINIFY FILTER
	================================================== */	
	function ct_bwm_filter($excluded) {
		global $is_IE;
		
		$excluded = array('fontawesome', 'ssgizmo');
		
		if ($is_IE) {	
		$excluded = array('bootstrap', 'ct-main', 'ct-responsive', 'fontawesome', 'ssgizmo');
		}
				
		return $excluded;
	}
	add_filter('bwp_minify_style_ignore', 'ct_bwm_filter');
	
	function ct_bwm_filter_script($excluded) {
		
		global $is_IE;
		
		$excluded = array();
		
		if ($is_IE) {	
		$excluded = array('jquery', 'ct-bootstrap-js', 'ct-respond', 'ct-html5shiv', 'ct-functions');
		}
				
		return $excluded;
		
	}
	add_filter('bwp_minify_script_ignore', 'ct_bwm_filter_script');
	
	
	/* BETTER SEO PAGE TITLE
	================================================== */
	if (!function_exists('ct_filter_wp_title')) {
		function ct_filter_wp_title( $title ) {
			global $page, $paged;
		
			if ( is_feed() )
				return $title;
		
			$site_description = get_bloginfo( 'description' );
		
			$filtered_title = $title . get_bloginfo( 'name' );
			$filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' | ' . $site_description: '';
			$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( __( 'Page %s', 'cootheme' ), max( $paged, $page ) ) : '';
		
			return $filtered_title;
		}
		add_filter( 'wp_title', 'ct_filter_wp_title' );
	}
	
	
	/* MAINTENANCE MODE
	================================================== */
	if (!function_exists('ct_maintenance_mode')) {
		function ct_maintenance_mode() {
			$options = get_option('ct_coo_options');
			$custom_logo = $custom_logo_output = $maintenance_mode = "";
			if (isset($options['custom_admin_login_logo'])) {
			$custom_logo = $options['custom_admin_login_logo'];
			}
			if ($custom_logo) {		
			$custom_logo_output = '<img src="'. $custom_logo .'" alt="maintenance" style="margin: 0 auto; display: block;" />';
			} else {
			$custom_logo_output = '<img src="'. get_template_directory_uri() .'/images/custom-login-logo.png" alt="maintenance" style="margin: 0 auto; display: block;" />';
			}
	
			if (isset($options['enable_maintenance'])) {
			$maintenance_mode = $options['enable_maintenance'];
			} else {
			$maintenance_mode = false;
			}
			
			if ($maintenance_mode) {
			
			    if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {
			        wp_die($custom_logo_output . '<p style="text-align:center">'.__('We are currently in maintenance mode, please check back shortly.', 'cootheme').'</p>', get_bloginfo( 'name' ));
			    }
		    
		    }
		}
		add_action('get_header', 'ct_maintenance_mode');
	}
	
	
	/* CUSTOM LOGIN LOGO
	================================================== */
	if (!function_exists('ct_custom_login_logo')) {
		function ct_custom_login_logo() {
			$options = get_option('ct_coo_options');
			$custom_logo = "";
			if (isset($options['custom_admin_login_logo'])) {
			$custom_logo = $options['custom_admin_login_logo'];
			}
			if ($custom_logo) {		
			echo '<style type="text/css">
			    .login h1 a { background-image:url('. $custom_logo .') !important; height: 95px!important; width: auto !important; background-size: auto!important; }
			</style>';
			} else {
			echo '<style type="text/css">
			    .login h1 a { background-image:url('. get_template_directory_uri() .'/images/custom-login-logo.png) !important; height: 95px!important; width: auto !important; background-size: auto!important; }
			</style>';
			}
		}
		add_action('login_head', 'ct_custom_login_logo');
	}
	
	
	/* BREADCRUMBS
	================================================== */ 
	if (!function_exists('ct_breadcrumbs')) {
		function ct_breadcrumbs() {
			$breadcrumb_output = "";
			
			if ( function_exists('bcn_display') ) {
				$breadcrumb_output .= '<div id="breadcrumbs">'. "\n";
				$breadcrumb_output .= bcn_display(true);
				$breadcrumb_output .= '</div>'. "\n";
			} else if ( function_exists('yoast_breadcrumb') ) {
				$breadcrumb_output .= '<div id="breadcrumbs">'. "\n";
				$breadcrumb_output .= yoast_breadcrumb("","",false);
				$breadcrumb_output .= '</div>'. "\n";
			}
			
			return $breadcrumb_output;
		}
	}
	
	
	/* LANGUAGE FLAGS
	================================================== */
	function ct_language_flags() {
		
		$language_output = "";
		
		if (function_exists('icl_get_languages')) {
		    $languages = icl_get_languages('skip_missing=0&orderby=code');
		    if(!empty($languages)){
		        foreach($languages as $l){
		            $language_output .= '<li>';
		            if($l['country_flag_url']){
		                if(!$l['active']) {
		                	$language_output .= '<a href="'.$l['url'].'"><img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" /><span class="language name">'.$l['translated_name'].'</span></a>'."\n";
		                } else {
		                	$language_output .= '<div class="current-language"><img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" /><span class="language name">'.$l['translated_name'].'</span></div>'."\n";
		                }
		            }
		            $language_output .= '</li>';
		        }
		    }
	    } else {
	    	//echo '<li><div>No languages set.</div></li>';
	    	$flags_url = get_template_directory_uri() . '/images/flags';
	    	$language_output .= '<li><a href="#">DEMO - EXAMPLE PURPOSES</a></li><li><a href="#"><span class="language name">German</span></a></li><li><div class="current-language"><span class="language name">English</span></div></li><li><a href="#"><span class="language name">Spanish</span></a></li><li><a href="#"><span class="language name">French</span></a></li>'."\n";
	    }
	    
	    return $language_output;
	}
	
	
	/* HEX TO RGB COLOR
	================================================== */
	function ct_hex2rgb( $colour ) {
	        if ( $colour[0] == '#' ) {
	                $colour = substr( $colour, 1 );
	        }
	        if ( strlen( $colour ) == 6 ) {
	                list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
	        } elseif ( strlen( $colour ) == 3 ) {
	                list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
	        } else {
	                return false;
	        }
	        $r = hexdec( $r );
	        $g = hexdec( $g );
	        $b = hexdec( $b );
	        return array( 'red' => $r, 'green' => $g, 'blue' => $b );
	}


	/* GET COMMENTS COUNT TEXT
	================================================== */
	function ct_get_comments_number($post_id) {
		$num_comments = get_comments_number($post_id); // get_comments_number returns only a numeric value
		$comments_text = "";
		
		if ( $num_comments == 0 ) {
			$comments_text = __('0 Comments', 'cootheme');
		} elseif ( $num_comments > 1 ) {
			$comments_text = $num_comments . __(' Comments', 'cootheme');
		} else {
			$comments_text = __('1 Comment', 'cootheme');
		}
		
		return $comments_text;
	}
	
	
	/* GET CUSTOM POST TYPE TAXONOMY LIST
	================================================== */
	function ct_get_category_list( $category_name, $filter=0 ){
		
		if (!$filter) { 
		
			$get_category = get_categories( array( 'taxonomy' => $category_name	));
			$category_list = array( '0' => 'All');
			
			foreach( $get_category as $category ){
				if (isset($category->slug)) {
				$category_list[] = $category->slug;
				}
			}
				
			return $category_list;
			
		} else {
			
			$get_category = get_categories( array( 'taxonomy' => $category_name	));
			$category_list = array( '0' => 'All');
			
			foreach( $get_category as $category ){
				if (isset($category->cat_name)) {
				$category_list[] = $category->cat_name;
				}
			}
				
			return $category_list;	
		
		}
	}
	
	function ct_get_category_list_key_array($category_name) {
			
		$get_category = get_categories( array( 'taxonomy' => $category_name	));
		$category_list = array( 'all' => 'All');
		
		foreach( $get_category as $category ){
			if (isset($category->slug)) {
			$category_list[$category->slug] = $category->cat_name;
			}
		}
			
		return $category_list;
	}
	
	function ct_get_woo_product_filters_array() {
		
		global $woocommerce;
		
		$attribute_array = array();
		
		$transient_name = 'wc_attribute_taxonomies';

		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		
			if ( false === ( $attribute_taxonomies = get_transient( $transient_name ) ) ) {
				global $wpdb;
				
					$attribute_taxonomies = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies" );
					set_transient( $transient_name, $attribute_taxonomies );
			}
	
			$attribute_taxonomies = apply_filters( 'woocommerce_attribute_taxonomies', $attribute_taxonomies );
			
			$attribute_array['product_cat'] = __('Product Category', 'cootheme');
			$attribute_array['price'] = __('Price', 'cootheme');
					
			if ( $attribute_taxonomies ) {
				foreach ( $attribute_taxonomies as $tax ) {
					$attribute_array[$tax->attribute_name] = $tax->attribute_name;
				}
			}
		
		}
		
		return $attribute_array;	
	}
	
	/* CATEGORY REL FIX
	================================================== */
	function ct_add_nofollow_cat( $text) {
	    $text = str_replace('rel="category tag"', "", $text);
	    return $text;
	}
	add_filter( 'the_category', 'ct_add_nofollow_cat' );
	
	
	/* REMOVE CERTAIN HEAD TAGS
	================================================== */
	if (!function_exists('ct_remove_head_links')) {
		function ct_remove_head_links() {
			remove_action('wp_head', 'index_rel_link');
			remove_action('wp_head', 'rsd_link');
			remove_action('wp_head', 'wlwmanifest_link');
		}
		add_action('init', 'ct_remove_head_links');
	}
	
	
	/* DYNAMIC GLOBAL INCLUDE CLASSES
	================================================== */ 
	function ct_global_include_classes() {
	
		// INCLUDED FUNCTIONALITY SETUP
		global $post, $ct_has_portfolio, $ct_has_blog, $ct_has_products, $ct_include_maps, $ct_include_isotope, $ct_include_carousel, $ct_include_parallax, $ct_include_infscroll, $ct_has_progress_bar, $ct_has_chart, $ct_has_countdown, $ct_has_imagebanner, $ct_has_team, $ct_has_portfolio_showcase, $ct_has_gallery;
			
		$ct_inc_class = "";
		
		if ($ct_has_portfolio) {
			$ct_inc_class .= "has-portfolio ";
		}
		if ($ct_has_blog) {
			$ct_inc_class .= "has-blog ";
		}
		if ($ct_has_products) {
			$ct_inc_class .= "has-products ";
		}
		
		$content = $post->post_content;
		
		if (function_exists('has_shortcode')) {
			if (has_shortcode( $content, 'product_category' ) || has_shortcode( $content, 'featured_products' ) || has_shortcode( $content, 'products' )) {
				$ct_inc_class .= "has-products ";
				$ct_include_isotope = true;
			}
		}
		
		if ($ct_include_maps) {
			$ct_inc_class .= "has-map ";
		}
		if ($ct_include_carousel) {
			$ct_inc_class .= "has-carousel ";
		}
		if ($ct_include_parallax) {
			$ct_inc_class .= "has-parallax ";
		}
		if ($ct_has_progress_bar) {
			$ct_inc_class .= "has-progress-bar ";
		}
		if ($ct_has_chart) {
			$ct_inc_class .= "has-chart ";
		}
		if ($ct_has_countdown) {
			$ct_inc_class .= "has-countdown ";
		}
		if ($ct_has_imagebanner) {
			$ct_inc_class .= "has-imagebanner ";
		}
		if ($ct_has_team) {
			$ct_inc_class .= "has-team ";
		}
		if ($ct_has_portfolio_showcase) {
			$ct_inc_class .= "has-portfolio-showcase ";
		}
		if ($ct_has_gallery) {
			$ct_inc_class .= "has-gallery ";
		}
		
		if ($ct_include_infscroll) {
			$ct_inc_class .= "has-infscroll ";
		}
		
		$options = get_option('ct_coo_options');
		
		if (isset($options['enable_product_zoom'])) {	
			$enable_product_zoom = $options['enable_product_zoom'];	
			if ($enable_product_zoom) {
				$ct_inc_class .= "has-productzoom ";
			}
		}
		
		if (isset($options['sticky_header_mobile']) && $options['sticky_header_mobile']) {
			$ct_inc_class .= 'sticky-header-mobile ';
		}
		
		return $ct_inc_class;
	}
	
	
	/* COUNTDOWN SHORTCODE LOCALE
	================================================== */
	if (!function_exists('ct_countdown_shortcode_locale')) {
		function ct_countdown_shortcode_locale() {
			global $ct_has_countdown;
			if ($ct_has_countdown) { ?>
			<div id="countdown-locale" data-label_year="<?php _e('Year', 'cootheme'); ?>" data-label_years="<?php _e('Years', 'cootheme'); ?>" data-label_month="<?php _e('Month', 'cootheme'); ?>" data-label_months="<?php _e('Months', 'cootheme'); ?>" data-label_weeks="<?php _e('Weeks', 'cootheme'); ?>" data-label_week="<?php _e('Week', 'cootheme'); ?>" data-label_days="<?php _e('Days', 'cootheme'); ?>" data-label_day="<?php _e('Day', 'cootheme'); ?>" data-label_hours="<?php _e('Hours', 'cootheme'); ?>" data-label_hour="<?php _e('Hour', 'cootheme'); ?>" data-label_mins="<?php _e('Mins', 'cootheme'); ?>" data-label_min="<?php _e('Min', 'cootheme'); ?>" data-label_secs="<?php _e('Secs', 'cootheme'); ?>" data-label_sec="<?php _e('Sec', 'cootheme'); ?>"></div>
			<?php }
		}
		add_action('wp_footer', 'ct_countdown_shortcode_locale');
	}
	
	
	/* CUSTOM ADMIN MENU ITEMS
	================================================== */
	if(!function_exists('ct_admin_bar_menu')) {
		function ct_admin_bar_menu() {
		
			global $wp_admin_bar;
			
			if ( current_user_can( 'manage_options' ) ) {
			
				$theme_options = array(
					'id' => '1',
					'title' => __('Theme Options', 'cootheme'),
					'href' => admin_url('/admin.php?page=ct_theme_options'),
					'meta' => array('target' => 'blank')
				);
				
				$wp_admin_bar->add_menu($theme_options);
				
				$theme_customizer = array(
					'id' => '2',
					'title' => __('Color Customizer', 'cootheme'),
					'href' => admin_url('/customize.php'),
					'meta' => array('target' => 'blank')
				);
				
				$wp_admin_bar->add_menu($theme_customizer);
			
			}
			
		}
		add_action('admin_bar_menu', 'ct_admin_bar_menu', 99);
	}	
	
	
	/* ADMIN CUSTOM POST TYPE ICONS
	================================================== */
	if (!function_exists('ct_admin_css')) {
		function ct_admin_css() {
		    ?>	    
		    <style type="text/css" media="screen">
		        #menu-posts-portfolio .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/portfolio.png) no-repeat 6px 7px!important;
		        	background-size: 17px 15px;
                    text-indent: -999em;
		        }
		        #menu-posts-portfolio:hover .wp-menu-image, #menu-posts-portfolio.wp-has-current-submenu .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/portfolio_rollover.png) no-repeat 6px 7px!important;
                    text-indent: -999em;
		        }
		        #menu-posts-team .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/team.png) no-repeat 6px 11px!important;
		        	background-size: 18px 9px;
                    text-indent: -999em;
		        }
		        #menu-posts-team:hover .wp-menu-image, #menu-posts-team.wp-has-current-submenu .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/team_rollover.png) no-repeat 6px 11px!important;
                    text-indent: -999em;
		        }
		        #menu-posts-clients .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/clients.png) no-repeat 7px 6px!important;
		        	background-size: 15px 16px;
                    text-indent: -999em;
		        }
		        #menu-posts-clients:hover .wp-menu-image, #menu-posts-clients.wp-has-current-submenu .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/clients_rollover.png) no-repeat 7px 6px!important;
                    text-indent: -999em;
		        }
		        #menu-posts-testimonials .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/testimonials.png) no-repeat 8px 7px!important;
		        	background-size: 15px 14px;
                    text-indent: -999em;
		        }
		        #menu-posts-testimonials:hover .wp-menu-image, #menu-posts-testimonials.wp-has-current-submenu .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/testimonials_rollover.png) no-repeat 8px 7px!important;
                    text-indent: -999em;
		        }
		        #menu-posts-jobs .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/jobs.png) no-repeat 7px 8px!important;
		        	background-size: 16px 14px;
                    text-indent: -999em;
		        }
		        #menu-posts-jobs:hover .wp-menu-image, #menu-posts-jobs.wp-has-current-submenu .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/jobs_rollover.png) no-repeat 7px 8px!important;
                    text-indent: -999em;
		        }
		        #menu-posts-faqs .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/faqs.png) no-repeat 7px 7px!important;
		        	background-size: 15px 16px;
                    text-indent: -999em;
		        }
		        #menu-posts-faqs:hover .wp-menu-image, #menu-posts-faqs.wp-has-current-submenu .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/faqs_rollover.png) no-repeat 7px 7px!important;
                    text-indent: -999em;
		        }
		        #menu-posts-galleries .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/galleries.png) no-repeat 7px 7px!important;
		        	background-size: 15px 16px;
                    text-indent: -999em;
		        }
		        #menu-posts-galleries:hover .wp-menu-image, #menu-posts-galleries.wp-has-current-submenu .wp-menu-image {
		            background: url(<?php echo get_template_directory_uri(); ?>/images/wp/galleries_rollover.png) no-repeat 7px 7px!important;
                    text-indent: -999em;
		        }
		        #menu-posts-slide .wp-menu-image img {
		        	width: 16px;
		        }
		        #toplevel_page_ct_theme_options .wp-menu-image img {
		        	width: 11px;
		        	margin-top: -2px;
		        	margin-left: 3px;
		        }
		        .toplevel_page_ct_theme_options #adminmenu li#toplevel_page_ct_theme_options.wp-has-current-submenu a.wp-has-current-submenu, .toplevel_page_ct_theme_options #adminmenu #toplevel_page_ct_theme_options .wp-menu-arrow div, .toplevel_page_ct_theme_options #adminmenu #toplevel_page_ct_theme_options .wp-menu-arrow {
		        	background: #222;
		        	border-color: #222;
		        }
		        #wpbody-content {
		        	min-height: 815px;
		        }
		        .wp-list-table th#thumbnail, .wp-list-table td.thumbnail {
		        	width: 80px;
		        }
		        .wp-list-table td.thumbnail img {
		        	max-width: 100%;
		        	height: auto;
		        }
			</style>
		
		<?php }
		add_action( 'admin_head', 'ct_admin_css' );
	}
?>