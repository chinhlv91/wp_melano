<?php
	
	/*
	*
	*	Coo Functions
	*	------------------------------------------------
	*	Cootheme
	* 	http://www.cootheme.com
	*
	*	VARIABLE DEFINITIONS
	*	PLUGIN INCLUDES
	*	THEME UPDATER
	*	THEME SUPPORT
	*	THUMBNAIL SIZES
	*	CONTENT WIDTH
	*	LOAD THEME LANGUAGE
	*	ct_custom_content_functions()
	*	ct_include_framework()
	*	ct_enqueue_styles()
	*	ct_enqueue_scripts()
	*	ct_load_custom_scripts()
	*	ct_admin_scripts()
	*	ct_layerslider_overrides()
	*
	*/
	
	
	/* VARIABLE DEFINITIONS
	================================================== */ 
	define('CT_TEMPLATE_PATH', get_template_directory());
	define('CT_INCLUDES_PATH', CT_TEMPLATE_PATH . '/includes');
	define('CT_FRAMEWORK_PATH', CT_TEMPLATE_PATH . '/coo-theme');
	define('CT_WIDGETS_PATH', CT_INCLUDES_PATH . '/widgets');
	define('CT_LOCAL_PATH', get_template_directory_uri());
	
	
	/* PLUGIN INCLUDES
	================================================== */
	$options = get_option('ct_coo_options');
	$disable_loveit = false;
	if (isset($options['disable_loveit']) && $options['disable_loveit'] == 1) {
	$disable_loveit = true;
	}
	require_once(CT_INCLUDES_PATH . '/plugins/aq_resizer.php');
	include_once(CT_INCLUDES_PATH . '/plugin-includes.php');
	
	if (!$disable_loveit) {
	include_once(CT_INCLUDES_PATH . '/plugins/love-it-pro/love-it-pro.php');
	}
	
	

	/* THEME UPDATER FRAMEWORK
	================================================== */  
	require_once(CT_INCLUDES_PATH . '/wp-updates-theme.php');
	new WPUpdatesThemeUpdater_445( 'http://wp-updates.com/api/2/theme', basename(get_template_directory()));	
	

	/* THEME SUPPORT
	================================================== */  			
	add_theme_support( 'structured-post-formats', array('audio', 'gallery', 'image', 'link', 'video') );
	add_theme_support( 'post-formats', array('aside', 'chat', 'quote', 'status') );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	
	
	/* THUMBNAIL SIZES
	================================================== */  	
	set_post_thumbnail_size( 220, 150, true);
	add_image_size( 'widget-image', 94, 70, true);
	add_image_size( 'thumb-square', 250, 250, true);
	add_image_size( 'thumb-image', 600, 450, true);
	add_image_size( 'thumb-image-twocol', 900, 675, true);
	add_image_size( 'thumb-image-onecol', 1800, 1200, true);
	add_image_size( 'blog-image', 1280, 9999);
	add_image_size( 'full-width-image-gallery', 1280, 720, true);
	
	
	/* CONTENT WIDTH
	================================================== */
	if ( ! isset( $content_width ) ) $content_width = 1140;
	
	
	/* LOAD THEME LANGUAGE
	================================================== */
	load_theme_textdomain('cootheme', CT_TEMPLATE_PATH.'/language');


	/* CONTENT FUNCTIONS
	================================================== */
	if (!function_exists('ct_custom_content')) {
		function ct_custom_content_functions() {
			include_once(CT_INCLUDES_PATH . '/ct-header.php');
			include_once(CT_INCLUDES_PATH . '/ct-blog.php');
			include_once(CT_INCLUDES_PATH . '/ct-portfolio.php');
			include_once(CT_INCLUDES_PATH . '/ct-products.php');
			include_once(CT_INCLUDES_PATH . '/ct-post-formats.php');
		}
		add_action('init', 'ct_custom_content_functions', 0);
	}
	
	
	/* Cootheme
	================================================== */ 
	if (!function_exists('ct_include_framework')) {
		function ct_include_framework() {
			require_once(CT_INCLUDES_PATH . '/ct-theme-functions.php');
			require_once(CT_INCLUDES_PATH . '/ct-comments.php');
			require_once(CT_INCLUDES_PATH . '/ct-formatting.php');
			require_once(CT_INCLUDES_PATH . '/ct-media.php');
			require_once(CT_INCLUDES_PATH . '/ct-menus.php');
			require_once(CT_INCLUDES_PATH . '/ct-pagination.php');
			require_once(CT_INCLUDES_PATH . '/ct-sidebars.php');
			require_once(CT_INCLUDES_PATH . '/ct-customizer-options.php');
			include_once(CT_INCLUDES_PATH . '/ct-custom-styles.php');
			include_once(CT_INCLUDES_PATH . '/ct-stylecootheme/ct-stylecootheme.php');
			require_once(CT_FRAMEWORK_PATH . '/coo-theme.php');
		}
		add_action('init', 'ct_include_framework', 0);
	}
	
	
	/* THEME OPTIONS FRAMEWORK
	================================================== */  
	require_once(CT_INCLUDES_PATH . '/ct-colour-scheme.php');
	if (!function_exists('ct_include_theme_options')) {
		function ct_include_theme_options() {
			require_once(CT_INCLUDES_PATH . '/ct-options.php');
		}
		add_action('after_setup_theme', 'ct_include_theme_options', 0);
	}
	
	
	/* LOAD STYLESHEETS
	================================================== */
	if (!function_exists('ct_enqueue_styles')) {
		function ct_enqueue_styles() {
			
			$options = get_option('ct_coo_options');
			$enable_responsive = $options['enable_responsive'];		
		
		    wp_register_style('bootstrap', CT_LOCAL_PATH . '/css/bootstrap.min.css', array(), NULL, 'all');
		    wp_register_style('fontawesome', CT_LOCAL_PATH .'/css/font-awesome.min.css', array(), NULL, 'all');
		    wp_register_style('ssgizmo', CT_LOCAL_PATH .'/css/ss-gizmo.css', array(), NULL, 'all');
		    wp_register_style('ct-main', get_stylesheet_directory_uri() . '/style.css', array(), NULL, 'all');
		    wp_register_style('ct-responsive', CT_LOCAL_PATH . '/css/responsive.css', array(), NULL, 'screen');
			
		    wp_enqueue_style('bootstrap');  
		    wp_enqueue_style('ssgizmo');
		    wp_enqueue_style('fontawesome'); 
		    wp_enqueue_style('ct-main');
		    
		    if ($enable_responsive) {
		    	wp_enqueue_style('ct-responsive');
		    }
		
		}		
		add_action('wp_enqueue_scripts', 'ct_enqueue_styles', 99);
	}
	
	
	/* LOAD FRONTEND SCRIPTS
	================================================== */
	if (!function_exists('ct_enqueue_scripts')) {
		function ct_enqueue_scripts() {
			
			global $is_IE;
		    
		    wp_register_script('ct-bootstrap-js', CT_LOCAL_PATH . '/js/bootstrap.min.js', 'jquery', NULL, TRUE);
		    wp_register_script('ct-flexslider', CT_LOCAL_PATH . '/js/jquery.flexslider-min.js', 'jquery', NULL, TRUE);
		    wp_register_script('ct-isotope', CT_LOCAL_PATH . '/js/jquery.isotope.min.js', 'jquery', NULL, TRUE);
		    wp_register_script('ct-imagesLoaded', CT_LOCAL_PATH . '/js/imagesloaded.js', 'jquery', NULL, TRUE);
		    wp_register_script('ct-easing', CT_LOCAL_PATH . '/js/jquery.easing.js', 'jquery', NULL, TRUE);
		    wp_register_script('ct-carouFredSel', CT_LOCAL_PATH . '/js/jquery.carouFredSel.min.js', 'jquery', NULL, TRUE);
			wp_register_script('ct-jquery-ui', CT_LOCAL_PATH . '/js/jquery-ui-1.10.2.custom.min.js', 'jquery', NULL, TRUE);
			wp_register_script('ct-viewjs', CT_LOCAL_PATH . '/js/view.min.js?auto', 'jquery', NULL, TRUE);
		    wp_register_script('ct-fitvids', CT_LOCAL_PATH . '/js/jquery.fitvids.js', 'jquery', NULL , TRUE);
		    wp_register_script('ct-maps', 'http://maps.google.com/maps/api/js?sensor=false', 'jquery', NULL, TRUE);
		    wp_register_script('ct-respond', CT_LOCAL_PATH . '/js/respond.min.js', '', NULL, FALSE);
		    wp_register_script('ct-html5shiv', CT_LOCAL_PATH . '/js/html5shiv.js', '', NULL, FALSE);
		    wp_register_script('ct-excanvas', CT_LOCAL_PATH . '/js/excanvas.compiled.js', '', NULL, FALSE);
		    wp_register_script('ct-elevatezoom', CT_LOCAL_PATH . '/js/jquery.elevateZoom.min.js', 'jquery', NULL, TRUE);
		    wp_register_script('ct-infinite-scroll',  CT_LOCAL_PATH . '/js/jquery.infinitescroll.min.js', 'jquery', NULL, TRUE);
		    wp_register_script('ct-theme-scripts', CT_LOCAL_PATH . '/js/theme-scripts.js', 'jquery', NULL, TRUE);
		    wp_register_script('ct-functions', CT_LOCAL_PATH . '/js/functions.js', 'jquery', NULL, TRUE);
			
			if ( $is_IE ) {
				wp_enqueue_script('ct-respond');
				wp_enqueue_script('ct-html5shiv');
				wp_enqueue_script('ct-excanvas');
			}
			
		    wp_enqueue_script('jquery');
			wp_enqueue_script('ct-bootstrap-js');
		    wp_enqueue_script('ct-jquery-ui');
		    wp_enqueue_script('ct-flexslider');
			wp_enqueue_script('ct-easing');
		    wp_enqueue_script('ct-fitvids');
	   	    wp_enqueue_script('ct-carouFredSel');
		    wp_enqueue_script('ct-theme-scripts');
		    
		    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		    	if (!is_account_page()) {
		    		wp_enqueue_script('ct-viewjs');
		    	}
		    } else {
		   		wp_enqueue_script('ct-viewjs');
		    }
		   	
	   	    wp_enqueue_script('ct-maps');
	   	    wp_enqueue_script('ct-isotope');
	   	    wp_enqueue_script('ct-imagesLoaded');
	   	    wp_enqueue_script('ct-infinite-scroll');
	   	
	   		$options = get_option('ct_coo_options');
	   		
	   		if (isset($options['enable_product_zoom'])) {	
	   			$enable_product_zoom = $options['enable_product_zoom'];	
	   			if ($enable_product_zoom) {
	   				wp_enqueue_script('ct-elevatezoom');
	   			}
	   		}
		   	
		    if (!is_admin()) {
		    	wp_enqueue_script('ct-functions');
		    }
		    
		   	if (is_singular() && comments_open()) {
		    	wp_enqueue_script('comment-reply');
		    }
		}
		add_action('wp_enqueue_scripts', 'ct_enqueue_scripts');
	}
	
	
	/* LOAD BACKEND SCRIPTS
	================================================== */
	function ct_admin_scripts() {
	    wp_register_script('admin-functions', get_template_directory_uri() . '/js/ct-admin.js', 'jquery', '1.0', TRUE);
		wp_enqueue_script('admin-functions');
	}
	add_action('admin_init', 'ct_admin_scripts');
	
	
	/* LAYERSLIDER OVERRIDES
	================================================== */
	function ct_layerslider_overrides() {
		// Disable auto-updates
		$GLOBALS['lsAutoUpdateBox'] = false;
	}
	add_action('layerslider_ready', 'ct_layerslider_overrides');

    /* Custom */
    function woocommerce_price_filter($filtered_posts) {
        global $wpdb;

        if ( isset( $_GET['max_price'] ) && isset( $_GET['min_price'] ) ) {

            $matched_products = array();
            $min 	= floatval( $_GET['min_price'] );
            $max 	= floatval( $_GET['max_price'] );

            $matched_products_query = $wpdb->get_results( $wpdb->prepare("
                SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
                INNER JOIN $wpdb->postmeta ON ID = post_id
                WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish' AND meta_key = %s AND meta_value BETWEEN %d AND %d
            ", '_price', $min, $max ), OBJECT_K );

            if ( $matched_products_query ) {
                foreach ( $matched_products_query as $product ) {
                    if ( $product->post_type == 'product' )
                        $matched_products[] = $product->ID;
                    if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) )
                        $matched_products[] = $product->post_parent;
                }
            }

            // Filter the id's
            if ( sizeof( $filtered_posts ) == 0) {
                $filtered_posts = $matched_products;
                $filtered_posts[] = 0;
            } else {
                $filtered_posts = array_intersect( $filtered_posts, $matched_products );
                $filtered_posts[] = 0;
            }

        }

        return (array) $filtered_posts;
    }

    function woocommerce_layered_nav_query( $filtered_posts ) {
        global $_chosen_attributes, $woocommerce, $wp_query;

        if ( sizeof( $_chosen_attributes ) > 0 ) {

            $matched_products = array();
            $filtered_attribute = false;

            foreach ( $_chosen_attributes as $attribute => $data ) {

                $matched_products_from_attribute = array();
                $filtered = false;

                if ( sizeof( $data['terms'] ) > 0 ) {
                    foreach ( $data['terms'] as $value ) {

                        $posts = get_posts(
                            array(
                                'post_type' 	=> 'product',
                                'numberposts' 	=> -1,
                                'post_status' 	=> 'publish',
                                'fields' 		=> 'ids',
                                'no_found_rows' => true,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' 	=> $attribute,
                                        'terms' 	=> $value,
                                        'field' 	=> 'id'
                                    )
                                )
                            )
                        );

                        // AND or OR
                        if ( $data['query_type'] == 'or' ) {

                            if ( ! is_wp_error( $posts ) && ( sizeof( $matched_products_from_attribute ) > 0 || $filtered ) )
                                $matched_products_from_attribute = array_merge($posts, $matched_products_from_attribute);
                            elseif ( ! is_wp_error( $posts ) )
                                $matched_products_from_attribute = $posts;

                        } else {

                            if ( ! is_wp_error( $posts ) && ( sizeof( $matched_products_from_attribute ) > 0 || $filtered ) )
                                $matched_products_from_attribute = array_intersect($posts, $matched_products_from_attribute);
                            elseif ( ! is_wp_error( $posts ) )
                                $matched_products_from_attribute = $posts;
                        }

                        $filtered = true;

                    }
                }

                if ( sizeof( $matched_products ) > 0 || $filtered_attribute )
                    $matched_products = array_intersect( $matched_products_from_attribute, $matched_products );
                else
                    $matched_products = $matched_products_from_attribute;

                $filtered_attribute = true;

            }

            if ( $filtered ) {

                $woocommerce->query->layered_nav_post__in = $matched_products;
                $woocommerce->query->layered_nav_post__in[] = 0;

                if ( sizeof( $filtered_posts ) == 0 ) {
                    $filtered_posts = $matched_products;
                    $filtered_posts[] = 0;
                } else {
                    $filtered_posts = array_intersect( $filtered_posts, $matched_products );
                    $filtered_posts[] = 0;
                }

            }
        }

        return (array) $filtered_posts;
    }
?>