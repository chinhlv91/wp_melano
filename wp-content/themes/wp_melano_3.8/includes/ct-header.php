<?php
	/*
	*
	*	Header Functions
	*	------------------------------------------------
	*	Cootheme
	* 	http://www.cootheme.com
	*
	*	ct_top_bar()
	*	ct_header()
	*	ct_top_header()
	*	ct_logo()
	*	ct_main_menu()
	*	ct_mobile_menu()
	*	ct_woo_links()
	* 	ct_get_cart()
	*	ct_get_wishlist()
	*	ct_ajaxsearch()
	*
	*/
		
 	/* TOP BAR
 	================================================== */
 	if (!function_exists('ct_top_bar')) {
		function ct_top_bar() {
		
			// VARIABLES
			$options = get_option('ct_coo_options');
			$tb_config = $options['tb_config'];
			$tb_left_text = $options['tb_left_text'];
			$tb_right_text = $options['tb_right_text'];
			$tb_search_text = $options['tb_search_text'];
			
			$show_sub = $options['show_sub'];
			$show_translation = $options['show_translation'];
			$show_account = $options['show_account'];
			$show_cart = $options['show_cart'];
			$ss_mobile = $options['ss_mobile'];
			
			$tb_output = $tb_menu_output = $tb_left_output = $tb_right_output = $coo_search_output = $ss_enable = '';
			
			if (isset($options['ss_enable'])) {
				$ss_enable = $options['ss_enable'];
			} else {
				$ss_enable = false;
			}
			
			
			// TOP BAR MENU OUTPUT
			$tb_menu_args = array(
				'echo'            => false,
				'theme_location' => 'top_bar_menu',
				'fallback_cb' => ''
			);
			$tb_menu_output .= '<nav class="top-menu std-menu clearfix">'. "\n";	
			if(function_exists('wp_nav_menu')) {
				$tb_menu_output .= wp_nav_menu( $tb_menu_args );
			}
			$tb_menu_output .= '</nav>'. "\n";
			
			
			// TOP BAR COO SEARCH OUTPUT
			if ($ss_enable) {
				$coo_search_output .= '<div class="tb-text"><a class="coo-search-link" href="#"><i class="ss-zoomin"></i><span>'.do_shortcode($tb_search_text).'</span></a></div>';
			}
			
			// TOP BAR LEFT OUTPUT
			if ($tb_config == "tb-1") {
			
				$tb_left_output = '<div class="tb-text clearfix">'. do_shortcode($tb_left_text). '</div>' . "\n";
				$tb_right_output = '<div class="tb-text clearfix">'. do_shortcode($tb_right_text). '</div>' . "\n";
			
			} else if ($tb_config == "tb-2") {
			
				$tb_left_output = $tb_menu_output;
				$tb_right_output = '<div class="tb-text clearfix">'. do_shortcode($tb_right_text). '</div>' . "\n";
			
			} else if ($tb_config == "tb-3") {
			
				$tb_left_output = '<div class="tb-text clearfix">'. do_shortcode($tb_left_text). '</div>' . "\n";
				$tb_right_output = $tb_menu_output;
			
			} else if ($tb_config == "tb-4") {
				
				$tb_left_output = ct_woo_links('top-menu', $tb_config);
				$tb_right_output = ct_aux_links('top-menu');
			
			} else if ($tb_config == "tb-5") {
				
				$tb_left_output = ct_woo_links('top-menu', $tb_config);
				$tb_right_output = '<div class="tb-text clearfix">'. do_shortcode($tb_right_text). '</div>' . "\n";
			
			} else if ($tb_config == "tb-6") {
				
				$tb_left_output = ct_woo_links('top-menu', $tb_config);
				$tb_right_output = $tb_menu_output;
			
			} else if ($tb_config == "tb-7") {
				
				$tb_left_output = $coo_search_output;
				$tb_right_output = '<div class="tb-text clearfix">'. do_shortcode($tb_right_text). '</div>' . "\n";	
		
			} else {
				
				$tb_left_output = $coo_search_output;
				$tb_right_output = $tb_menu_output;
				
			}
	
	
			// TOP BAR OUTPUT
			$tb_output .= '<div id="top-bar" class="'.$tb_config.'">'. "\n";
			if ($ss_mobile) {
			$tb_output .= '<div class="tb-ss">'.$coo_search_output.'</div>'. "\n";
			}
			$tb_output .= '<div class="container">'. "\n";
			$tb_output .= '<div class="row">'. "\n";
			$tb_output .= '<div class="tb-left col-sm-6 clearfix">'. "\n";
			$tb_output .= $tb_left_output;
			$tb_output .= '</div> <!-- CLOSE .tb-left -->'. "\n";		
			$tb_output .= '<div class="tb-right col-sm-6 clearfix">'. "\n";
			$tb_output .= $tb_right_output;
			$tb_output .= '</div> <!-- CLOSE .tb-right -->'. "\n";
			$tb_output .= '</div> <!-- CLOSE .row -->'. "\n";
			$tb_output .= '</div> <!-- CLOSE .container -->'. "\n";
			$tb_output .= '</div> <!-- CLOSE #top-bar -->'. "\n";
			
				
			// TOP BAR RETURN		
			return $tb_output;
		}
	}
		
	
	/* HEADER
	================================================== */ 
	if (!function_exists('ct_header')) {
		function ct_header($header_layout) {
		
			// VARIABLES
			$options = get_option('ct_coo_options');
			$show_cart = $options['show_cart'];
			$show_wishlist = $options['show_wishlist'];
			$header_left_text = $options['header_left_text'];
			$header_output = $main_menu = '';
					
			if ($header_layout == "header-1") {
			
			$header_output .= '<header id="header" class="clearfix">'. "\n";
			$header_output .= '<div class="container">'. "\n";
			$header_output .= '<div class="row">'. "\n";
			$header_output .= '<div class="header-left col-sm-4">'.$header_left_text.'</div>'. "\n";
			$header_output .= ct_logo('col-sm-4 logo-center');
			$header_output .= '<div class="header-right col-sm-4">'.ct_aux_links('header-menu', TRUE, "header-1").'</div>'. "\n";
			$header_output .= '</div> <!-- CLOSE .row -->'. "\n";
			$header_output .= '</div> <!-- CLOSE .container -->'. "\n";
			$header_output .= '</header>'. "\n";
			$header_output .= '<div id="main-nav" class="sticky-header">'. "\n";
			$header_output .= ct_main_menu('main-navigation', 'full');
			$header_output .= '</div>'. "\n";
			
			} else if ($header_layout == "header-2") {
			
			$header_output .= '<header id="header" class="clearfix">'. "\n";
			$header_output .= '<div class="container">'. "\n";
			$header_output .= '<div class="row">'. "\n";
			$header_output .= ct_logo('col-sm-4 logo-left');
			$header_output .= '<div class="header-right col-sm-8">'.ct_aux_links('header-menu', FALSE, "header-1").'</div>'. "\n";
			$header_output .= '</div> <!-- CLOSE .row -->'. "\n";
			$header_output .= '</div> <!-- CLOSE .container -->'. "\n";
			$header_output .= '</header>'. "\n";
			$header_output .= '<div id="main-nav" class="sticky-header">'. "\n";
			$header_output .= ct_main_menu('main-navigation', 'full');
			$header_output .= '</div>'. "\n";
			
			} else if ($header_layout == "header-3") {
			
			$header_output .= '<header id="header" class="clearfix">'. "\n";
			$header_output .= '<div class="container header-container sticky-header">'. "\n";
			$header_output .= '<div class="row">'. "\n";
			$header_output .= ct_logo('logo-left');
			$header_output .= '<div class="header-right">';
			$header_output .= ct_main_menu('main-navigation', 'with-search');
			$header_output .= '</div>'. "\n";
			$header_output .= '</div> <!-- CLOSE .row -->'. "\n";
			$header_output .= '</div> <!-- CLOSE .container -->'. "\n";
			$header_output .= '</header>'. "\n";
			
			} else if ($header_layout == "header-4") {
			
			$header_output .= '<header id="header" class="clearfix">'. "\n";
			$header_output .= ct_top_header();
			$header_output .= '<div class="container header-container sticky-header">'. "\n";
			$header_output .= '<div class="row">'. "\n";
			$header_output .= ct_logo('logo-left');
			$header_output .= '<div class="header-right">';
			$header_output .= ct_main_menu('main-navigation', 'with-search');
			$header_output .= '</div>'. "\n";
			$header_output .= '</div> <!-- CLOSE .row -->'. "\n";
			$header_output .= '</div> <!-- CLOSE .container -->'. "\n";
			$header_output .= '</header>'. "\n";
			
			} else if ($header_layout == "header-5") {
			
			$header_output .= '<header id="header" class="clearfix">'. "\n";
			$header_output .= '<div class="container sticky-header">'. "\n";
			$header_output .= '<div class="row">'. "\n";
			$header_output .= ct_logo('logo-left');
			$header_output .= '<div class="header-right">';
			$header_output .= ct_main_menu('main-navigation', 'with-search');
			$header_output .= '</div>'. "\n";
			$header_output .= '</div> <!-- CLOSE .row -->'. "\n";
			$header_output .= '</div> <!-- CLOSE .container -->'. "\n";
			$header_output .= '</header>'. "\n";
			
			} else if ($header_layout == "header-6") {
			
			$header_output .= '<header id="header" class="sticky-header clearfix">'. "\n";
			$header_output .= '<div class="container">'. "\n";
			$header_output .= '<div class="row">'. "\n";
			$header_output .= ct_logo('logo-left');
			$header_output .= '<div class="header-right">'.ct_main_menu('main-navigation', 'with-search').'</div>'. "\n";
			$header_output .= '</div> <!-- CLOSE .row -->'. "\n";
			$header_output .= '</div> <!-- CLOSE .container -->'. "\n";
			$header_output .= '</header>'. "\n";
			
			} else {
			
			$header_output .= '<header id="header" class="clearfix">'. "\n";
			$header_output .= ct_top_header();
			$header_output .= '<div class="sticky-header">'. "\n";
			$header_output .= '<div class="container header-container">'. "\n";
			$header_output .= '<div class="row">'. "\n";
			$header_output .= ct_logo('logo-left');
			$header_output .= '<div class="header-right">'.ct_main_menu('main-navigation', 'with-search').'</div>'. "\n";
			$header_output .= '</div> <!-- CLOSE .row -->'. "\n";
			$header_output .= '</div> <!-- CLOSE .container -->'. "\n";
			$header_output .= '</div>'. "\n";
			$header_output .= '</header>'. "\n";
			
			}
			
			// HEADER RETURN
			return $header_output;
			
		}
	}
	
	
	/* TOP HEADER
	================================================== */ 
	if (!function_exists('ct_top_header')) {
		function ct_top_header() {
					
			$options = get_option('ct_coo_options');
			$header_left_text = $options['header_left_text'];
			$top_header_output = '';
	
			$top_header_output .= '<div id="top-header">';
			$top_header_output .= '<div class="container">'. "\n";
			$top_header_output .= '<div class="th-left col-sm-6 clearfix">'. "\n";
			$top_header_output .= $header_left_text;
			$top_header_output .= '</div> <!-- CLOSE .tb-left -->'. "\n";		
			$top_header_output .= '<div class="th-right col-sm-6 clearfix">'. "\n";
			$top_header_output .= ct_aux_links('top-header-menu');
			$top_header_output .= '</div> <!-- CLOSE .tb-right -->'. "\n";
			$top_header_output .= '</div> <!-- CLOSE .container -->'. "\n";
			$top_header_output .= '</div>';
		
			return $top_header_output;
		}
	}
	
		
	/* LOGO
	================================================== */ 
	if (!function_exists('ct_logo')) {
		function ct_logo($logo_class) {
			
			//VARIABLES
			global $woocommerce;
			$options = get_option('ct_coo_options');
			$show_cart = $options['show_cart'];
			$logo = $retina_logo = "";
			if (isset($options['logo_upload'])) {
			$logo = $options['logo_upload'];
			}
			if (isset($options['retina_logo_upload'])) {
			$retina_logo = $options['retina_logo_upload'];
			}
			if ($retina_logo == "") {
			$retina_logo = $logo;
			}
			$logo_output = "";		
			$logo_alt = get_bloginfo( 'name' );
			$logo_link_url = home_url();
			
			
			// LOGO OUTPUT
			$logo_output .= '<div id="logo" class="'.$logo_class.' clearfix">'. "\n";
			$logo_output .= '<a href="'.$logo_link_url.'">'. "\n";
			if ($logo != "") { 
			$logo_output .= '<img class="standard" src="'.$logo.'" alt="'.$logo_alt.'" />'. "\n";
			} else {
			$logo_output .= '<h1 class="standard">'.$logo_alt.'</h1>'. "\n";
			}
			if ($retina_logo != "") {
			$logo_output .= '<img class="retina" src="'.$retina_logo.'" alt="'.$logo_alt.'" />'. "\n";
			} else {
			$logo_output .= '<h1 class="retina">'.$logo_alt.'</h1>'. "\n";
			}
			$logo_output .= '</a>'. "\n";
			$logo_output .= '<a href="#" class="visible-sm visible-xs mobile-menu-show"><i class="ss-rows"></i></a>'. "\n";
			if ($show_cart && $woocommerce != "") {
			$logo_output .= '<a href="'.$woocommerce->cart->get_cart_url().'" class="visible-sm visible-xs mobile-cart-link"><i class="ss-cart"></i></a>'. "\n";
			}
			$logo_output .= '</div>'. "\n";
			
			
			// LOGO RETURN		
			return $logo_output;
		}
	}
		
	
	/* MENU
	================================================== */ 
	if (!function_exists('ct_main_menu')) {
		function ct_main_menu($id, $layout = "") {
		
			// VARIABLES
			$options = get_option('ct_coo_options');
			$show_cart = $options['show_cart'];
			$show_wishlist = $options['show_wishlist'];
			$header_search_type = "search-1";
			if (isset($options['header_search_type'])) {
				$header_search_type = $options['header_search_type'];
			}
			$menu_output = $menu_full_output = $menu_with_search_output = "";
			$main_menu_args = array(
				'echo'            => false,
				'theme_location' => 'main_navigation',
				'walker' => new ct_mega_menu_walker,
				'fallback_cb' => ''
			);
			
			
			// MENU OUTPUT
			$menu_output .= '<nav id="'.$id.'" class="mega-menu clearfix">'. "\n";		
			
			if(function_exists('wp_nav_menu')) {
				if (has_nav_menu('main_navigation')) {
					$menu_output .= wp_nav_menu( $main_menu_args );
				}
				else {
					$menu_output .= '<div class="no-menu">'.__("Please assign a menu to the Main Menu in Appearance > Menus", "cootheme").'</div>';
				}
			}
			$menu_output .= '</nav>'. "\n";
			
			
			// FULL WIDTH MENU OUTPUT
			if ($layout == "full") {	
				
				$menu_full_output .= '<div class="container">'. "\n";
				$menu_full_output .= '<div class="row">'. "\n";
				$menu_full_output .= '<div class="menu-left">'. "\n";
				$menu_full_output .= $menu_output . "\n";
				$menu_full_output .= '</div>'. "\n";
				$menu_full_output .= '<div class="header-right">'. "\n";
				$menu_full_output .= '<nav class="std-menu">'. "\n";			
				$menu_full_output .= '<ul class="menu">'. "\n";
				if ($header_search_type == "search-1") {
				$menu_full_output .= '<li class="menu-search parent"><a href="#" class="header-search-link"><i class="ss-search"></i></a></li>'. "\n";
				} else if ($header_search_type == "search-2") {
				$menu_full_output .= '<li class="menu-search parent"><a href="#" class="header-search-link-alt"><i class="ss-search"></i></a>'. "\n";
				$menu_full_output .= '<div class="ajax-search-wrap"><div class="ajax-loading"></div><form method="get" class="ajax-search-form" action="'.home_url().'/"><input type="text" placeholder="'.__("Search", "cootheme").'" name="s" autocomplete="off" /></form><div class="ajax-search-results"></div></div>'. "\n";
				$menu_full_output .= '</li>'. "\n";			
				}
				if ($show_cart) {
				$menu_full_output .= ct_get_cart();
				}
				if ( class_exists( 'YITH_WCWL_UI' ) && $show_wishlist)  {
				$menu_full_output .= ct_get_wishlist();
				}
				$menu_full_output .= '</ul>'. "\n";
				$menu_full_output .= '</nav>'. "\n";
				$menu_full_output .= '</div>'. "\n";
				$menu_full_output .= '</div>'. "\n";
				$menu_full_output .= '</div>'. "\n";
				
				$menu_output = $menu_full_output;
			
			} else if ($layout == "with-search") {
				
				$menu_with_search_output .= '<nav class="search-nav std-menu">'. "\n";			
				$menu_with_search_output .= '<ul class="menu">'. "\n";
				if ($header_search_type == "search-1") {
				$menu_with_search_output .= '<li class="menu-search parent"><a href="#" class="header-search-link"><i class="ss-search"></i></a></li>'. "\n";
				} else if ($header_search_type == "search-2") {
				$menu_with_search_output .= '<li class="menu-search parent"><a href="#" class="header-search-link-alt"><i class="ss-search"></i></a>'. "\n";
				$menu_with_search_output .= '<div class="ajax-search-wrap"><div class="ajax-loading"></div><form method="get" class="ajax-search-form" action="'.home_url().'/"><input type="text" placeholder="'.__("Search", "cootheme").'" name="s" autocomplete="off" /></form><div class="ajax-search-results"></div></div>'. "\n";
				$menu_with_search_output .= '</li>'. "\n";
				}
				$menu_with_search_output .= '</ul>'. "\n";
				$menu_with_search_output .= '</nav>'. "\n";
				$menu_with_search_output .= $menu_output . "\n";
				
				
				$menu_output = $menu_with_search_output; 
				
			}
			
			// MENU RETURN		
			return $menu_output;
		}
	}
		
	
	/* MOBILE MENU
	================================================== */
	if (!function_exists('ct_mobile_menu')) {
		function ct_mobile_menu() {
			
			$options = get_option('ct_coo_options');
			$show_translation = $options['show_translation'];
			
			$mobile_menu_args = array(
				'echo'            => false,
				'theme_location' => 'mobile_menu',
				'fallback_cb' => ''
			);
			
			$mobile_menu_output = "";
			
			$mobile_menu_output .= '<div id="mobile-menu-wrap">'. "\n";
			if ($show_translation) {	
			$mobile_menu_output .= '<ul class="mobile-language-select">'.ct_language_flags().'</ul>'. "\n";
			}
			$mobile_menu_output .= '<form method="get" class="mobile-search-form" action="'.home_url().'/"><input type="text" placeholder="'.__("Search", "cootheme").'" name="s" autocomplete="off" /></form>'. "\n";
			$mobile_menu_output .= '<a class="mobile-menu-close"><i class="ss-delete"></i></a>'. "\n";
			$mobile_menu_output .= '<nav id="mobile-menu" class="clearfix">'. "\n";		
			
			if(function_exists('wp_nav_menu')) {
				$mobile_menu_output .= wp_nav_menu( $mobile_menu_args );
			}
			$mobile_menu_output .= '</nav>'. "\n";
			$mobile_menu_output .= '</div>'. "\n";
			
			return $mobile_menu_output;
		}
	}
	
	
	/* WOO LINKS
	================================================== */
	if (!function_exists('ct_woo_links')) {
		function ct_woo_links($position, $config = "") {
			
			// VARIABLES
			$options = get_option('ct_coo_options');
			$tb_search_text = $options['tb_search_text'];
			$woo_links_output = $ss_enable = "";
			
			if (isset($options['ss_enable'])) {
				$ss_enable = $options['ss_enable'];
			} else {
				$ss_enable = true;
			}
			
			// WOO LINKS OUTPUT
			$woo_links_output .= '<nav class="'.$position.'">'. "\n";
			$woo_links_output .= '<ul class="menu">'. "\n";
			if (is_user_logged_in()) {
				global $current_user;
				get_currentuserinfo();
				$woo_links_output .= '<li class="tb-welcome">' . __("Welcome", "cootheme") . " " . $current_user->display_name . '</li>'. "\n";
			} else {
				$woo_links_output .= '<li class="tb-welcome">' . __("Welcome", "cootheme") . '</li>'. "\n";
			}
			if ($ss_enable) {
				if ($position == "top-menu") {
				$woo_links_output .= '<li class="tb-woo-custom clearfix"><a class="coo-search-link" href="#"><i class="ss-zoomin"></i><span>'.do_shortcode($tb_search_text).'</span></a></li>'. "\n";
				} else {
				$woo_links_output .= '<li class="hs-woo-custom clearfix"><a class="coo-search-link" href="#"><i class="ss-zoomin"></i><span>'.do_shortcode($tb_search_text).'</span></a></li>'. "\n";
				}
			}
			$woo_links_output .= '</ul>'. "\n";
			$woo_links_output .= '</nav>'. "\n";
			
			// RETURN
			return $woo_links_output;
		}
	}
		
	
	/* AUX LINKS
	================================================== */
	if (!function_exists('ct_aux_links')) {
		function ct_aux_links($position, $alt_version = FALSE, $header_version = "") {
		
			// VARIABLES
			$login_url = wp_login_url();
			$logout_url = wp_logout_url( home_url() );
			$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
			if ( $myaccount_page_id ) {
				$logout_url = wp_logout_url( get_permalink( $myaccount_page_id ) );
			  	$login_url = get_permalink( $myaccount_page_id );
			  	if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' ) {
			    	$logout_url = str_replace( 'http:', 'https:', $logout_url );
					$login_url = str_replace( 'http:', 'https:', $login_url );
				}
			}
			$options = get_option('ct_coo_options');
			$show_sub = $options['show_sub'];
			$show_translation = $options['show_translation'];
			$sub_code = $options['sub_code'];
			$show_account = $options['show_account'];
			$show_cart = $options['show_cart'];
			$show_wishlist = $options['show_wishlist'];
			$tb_search_text = $options['tb_search_text'];
			$aux_links_output = $ss_enable = "";
			
			if (isset($options['ss_enable'])) {
				$ss_enable = $options['ss_enable'];
			} else {
				$ss_enable = true;
			}
			
			// LINKS + SEARCH OUTPUT
			$aux_links_output .= '<nav class="std-menu '.$position.'">'. "\n";
			$aux_links_output .= '<ul class="menu">'. "\n";
			if ($show_account) {
				if (is_user_logged_in()) {
					$aux_links_output .= '<li><a href="'.wp_logout_url(home_url()).'"><i class="fa-unlock"></i>'. __("Sign Out", "cootheme") .'</a></li>'. "\n";
					if ( $myaccount_page_id ) {
					$aux_links_output .= '<li><a href="'.get_permalink( $myaccount_page_id ).'" class="admin-link"><i class="fa-user"></i>'. __("My Account", "cootheme") .'</a></li>'. "\n";
					} else {
					$aux_links_output .= '<li><a href="'.get_admin_url().'" class="admin-link"><i class="fa-user"></i>'. __("My Account", "cootheme") .'</a></li>'. "\n";
					}
				} else {
					$aux_links_output .= '<li><a href="'.$login_url.'"><i class="fa-users"></i>'. __("Login", "cootheme") .'</a></li>'. "\n";
				}
			}
			if ($show_sub) {
				$aux_links_output .= '<li class="parent"><a href="#"><i class="fa-umbrella"></i>'. __("Subscribe", "cootheme") .'</a>'. "\n";
				$aux_links_output .= '<ul class="sub-menu">'. "\n";
				$aux_links_output .= '<li><div id="header-subscribe" class="clearfix">'. "\n";
				$aux_links_output .= do_shortcode($sub_code) . "\n";
				$aux_links_output .= '</div></li>'. "\n";
				$aux_links_output .= '</ul>'. "\n";
				$aux_links_output .= '</li>'. "\n";
			}
			if ($show_translation) {
				$aux_links_output .= '<li class="parent aux-languages"><i class="fa-globe"></i><a href="#">'. __("Language", "cootheme") .'</a>'. "\n";
				$aux_links_output .= '<ul id="header-languages" class="sub-menu">'. "\n";
				if (function_exists( 'ct_language_flags' )) {
				$aux_links_output .= ct_language_flags();
				}
				$aux_links_output .= '</ul>'. "\n";
				$aux_links_output .= '</li>'. "\n";
			}
			if ($header_version != "header-1") {
				if ($show_cart) {
				$aux_links_output .= ct_get_cart();
				}
				if ( class_exists( 'YITH_WCWL_UI' ) && $show_wishlist)  {
				$aux_links_output .= ct_get_wishlist();
				}
			}
				if (($position == "header-menu" && !$alt_version) && $ss_enable) {
				$aux_links_output .= '<li><a class="coo-search-link" href="#"><i class="ss-zoomin"></i><span>'.do_shortcode($tb_search_text).'</span></a></li>'. "\n";
				}
			$aux_links_output .= '</ul>'. "\n";
			$aux_links_output .= '</nav>'. "\n";
		
		
			// RETURN
			return $aux_links_output;
		}
	}
		
	
	/* CART DROPDOWN
	================================================== */ 
	if (!function_exists('ct_get_cart')) {
		function ct_get_cart() {
		
			$cart_output = "";
			
			// Check if WooCommerce is active
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			
				global $woocommerce;
				
				$cart_total = $woocommerce->cart->get_cart_total();
				$cart_count = $woocommerce->cart->cart_contents_count;
				$cart_count_text = ct_product_items_text($cart_count);
				
				$cart_output .= '<li class="parent shopping-bag-item"><a class="cart-contents" href="'.$woocommerce->cart->get_cart_url().'" title="'.__("View your shopping cart", "cootheme").'"><i class="ss-cart111"></i>'.$cart_total.'</a>';
	            $cart_output .= '<ul class="sub-menu">';     
	            $cart_output .= '<li>';                                      
				$cart_output .= '<div class="shopping-bag">';
				
	            if ( $cart_count != "0" ) {
	            	
	            	$cart_output .= '<div class="bag-header">'.$cart_count_text.' '.__('in the shopping bag', 'cootheme').'</div>';
	            	
	            	$cart_output .= '<div class="bag-contents">';
	            	
	            	foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) {
	                
	                    $bag_product = $cart_item['data']; 
	                    $product_title = $bag_product->get_title();
	                    $product_short_title = (strlen($product_title) > 25) ? substr($product_title, 0, 22) . '...' : $product_title;
	                                                               
	                    if ($bag_product->exists() && $cart_item['quantity']>0) {                                            
	                        $cart_output .= '<div class="bag-product clearfix">';
	                      	$cart_output .= '<figure><a class="bag-product-img" href="'.get_permalink($cart_item['product_id']).'">'.$bag_product->get_image().'</a></figure>';                      
	                        $cart_output .= '<div class="bag-product-details">';
	                        $cart_output .= '<div class="bag-product-title"><a href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $product_short_title, $bag_product) . '</a></div>';
	                        $cart_output .= '<div class="bag-product-price">'.__("Unit Price:", "cootheme").'
	                        '.woocommerce_price($bag_product->get_price()).'</div>';
	                        $cart_output .= '<div class="bag-product-quantity">'.__('Quantity:', 'cootheme').' '.$cart_item['quantity'].'</div>';
	                        $cart_output .= '</div>';
	                        $cart_output .= apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'woocommerce') ), $cart_item_key );
	                        
	                        $cart_output .= '</div>';
	                	}
	                }
	                
	                $cart_output .= '</div>';
	                
	                $cart_output .= '<div class="bag-buttons">';
	                
	                $cart_output .= '<a class="ct-button standard ct-icon-reveal bag-button" href="'.esc_url( $woocommerce->cart->get_cart_url() ).'"><i class="ss-view"></i><span class="text">'. __('View shopping bag', 'cootheme').'</span></a>';
	                
	               	$cart_output .= '<a class="ct-button standard ct-icon-reveal checkout-button" href="'. esc_url( $woocommerce->cart->get_checkout_url() ).'"><i class="ss-creditcard"></i><span class="text">'.__('Proceed to checkout', 'cootheme').'</span></a>';
	                                
	               	$cart_output .= '</div>';
	                                                        
	            } else {
	           		
	           		$cart_output .= '<div class="bag-header">'.__("0 items in the shopping bag", "cootheme").'</div>';
	           		
	           		$cart_output .= '<div class="bag-empty">'.__('Unfortunately, your shopping bag is empty.','cootheme').'</div>';
	            	
	            	$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
	            	
	            	$cart_output .= '<div class="bag-buttons">';
	            	
	            	$cart_output .= '<a class="ct-button standard ct-icon-reveal shop-button" href="'.esc_url( $shop_page_url ).'"><i class="fa-shopping-cart"></i><span class="text">'.__('Go to the shop', 'cootheme').'</span></a>';
	            	            	                
	            	$cart_output .= '</div>';
	            		
	            }
	            
			    $cart_output .= '</div>';
	            $cart_output .= '</li>';                                                                                                          
	            $cart_output .= '</ul>';                                                                                                          
	            $cart_output .= '</li>';                                                                                                                      
	        
	        }
			
			return $cart_output;
		}
	}
	
	
	/* WISHLIST DROPDOWN
	================================================== */
	if (!function_exists('ct_get_wishlist')) {
		function ct_get_wishlist() {
			
			global $wpdb, $yith_wcwl, $woocommerce;
	
			$wishlist_output = "";
					
			if ( is_user_logged_in() ) {
			    $user_id = get_current_user_id();
			}
			
			$count = array();
			
			if( is_user_logged_in() ) {
			    $count = $wpdb->get_results( $wpdb->prepare( 'SELECT COUNT(*) as `cnt` FROM `' . YITH_WCWL_TABLE . '` WHERE `user_id` = %d', $user_id  ), ARRAY_A );
			    $count = $count[0]['cnt'];
			} elseif( yith_usecookies() ) {
			    $count[0]['cnt'] = count( yith_getcookie( 'yith_wcwl_products' ) );
			    $count = $count[0]['cnt'];
			} else {
			    $count[0]['cnt'] = count( $_SESSION['yith_wcwl_products'] );
			    $count = $count[0]['cnt'];
			}
			
			if (is_array($count)) {
				$count = 0;
			}
			
			$wishlist_output .= '<li class="parent wishlist-item"><a class="wishlist-link" href="'.$yith_wcwl->get_wishlist_url().'" title="'.__("View your wishlist", "cootheme").'"><i class="ss-star"></i><span>'.$count.'</span></a>';
			$wishlist_output .= '<ul class="sub-menu">';
			$wishlist_output .= '<li>';
			$wishlist_output .= '<div class="wishlist-bag">';
			
			$current_page = 1;
			$limit_sql = '';
			$count_limit = 0;
			
			if( is_user_logged_in() )
			    { $wishlist = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `" . YITH_WCWL_TABLE . "` WHERE `user_id` = %s" . $limit_sql, $user_id ), ARRAY_A ); }
			elseif( yith_usecookies() )
			    { $wishlist = yith_getcookie( 'yith_wcwl_products' ); }
			else
			    { $wishlist = isset( $_SESSION['yith_wcwl_products'] ) ? $_SESSION['yith_wcwl_products'] : array(); }
							  
			do_action( 'yith_wcwl_before_wishlist_title' );
			    
			$wishlist_title = get_option( 'yith_wcwl_wishlist_title' );
			if( !empty( $wishlist_title ) ) {		
			$wishlist_output .= '<div class="bag-header">'.$wishlist_title.'</div>';
			}
			$wishlist_output .= '<div class="bag-contents">';
			
			$wishlist_output .= do_action( 'yith_wcwl_before_wishlist' );
	          
	        if ( count( $wishlist ) > 0 ) :
	           	
	           	foreach( $wishlist as $values ) :   
	                
	                if ($count_limit < 4) {
	                
		                if( !is_user_logged_in() ) {
		    				if( isset( $values['add-to-wishlist'] ) && is_numeric( $values['add-to-wishlist'] ) ) {
		    					$values['prod_id'] = $values['add-to-wishlist'];
		    					$values['ID'] = $values['add-to-wishlist'];
		    				} else {
		    					$values['prod_id'] = $values['product_id'];
		    					$values['ID'] = $values['product_id'];
		    				}
		    			}
		                                 
		                $product_obj = get_product( $values['prod_id'] );
		                
		                if( $product_obj !== false && $product_obj->exists() ) : 
		                
		                $wishlist_output .= '<div id="wishlist-'.$values['ID'].'" class="bag-product clearfix">';
		                
		                if ( has_post_thumbnail($product_obj->id) ) {
		                	$image_link  		= wp_get_attachment_url( get_post_thumbnail_id($product_obj->id) );                        	
		                	$image = aq_resize( $image_link, 70, 70, true, false);
		                	
		                	if ($image) {
		                		$wishlist_output .= '<figure><a class="bag-product-img" href="'.esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $values['prod_id'] ) ) ).'"><img itemprop="image" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" /></a></figure>';                      
		                	}            			
		                } 
		               		                
		                $wishlist_output .= '<div class="bag-product-details">';
		                $wishlist_output .= '<div class="bag-product-title"><a href="'.esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $values['prod_id'] ) ) ).'">'. apply_filters( 'woocommerce_in_cartproduct_obj_title', $product_obj->get_title(), $product_obj ) .'</a></div>';
		                
		                if( get_option( 'woocommerce_display_cart_prices_excluding_tax' ) == 'yes' ) {
		                $wishlist_output .= '<div class="bag-product-price">'.apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_obj->get_price_excluding_tax() ), $values, '' ).'</div>';
		               	} else {
		               	$wishlist_output .= '<div class="bag-product-price">'.apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_obj->get_price() ), $values, '' ).'</div>';
		                }  
		                $wishlist_output .= '</div>';                  
		                $wishlist_output .= '</div>';
		                
		                endif;
						
						$count_limit++;
					}
									
	            endforeach;
	
	        else :
            $wishlist_output .= '<div class="wishlist-empty">'. __( 'Your wishlist is currently empty.', 'cootheme' ) .'</div>';
	        endif;
	        
	        $wishlist_output .= '</div>';
            if(count( $wishlist ) > 0){
	
			$wishlist_output .= '<div class="bag-buttons">';
			
			$wishlist_output .= '<a class="ct-button standard ct-icon-reveal wishlist-button" href="'.$yith_wcwl->get_wishlist_url().'"><i class="fa-heart"></i><span class="text">'.__('My wishlist', 'cootheme').'</span></a>';
			            	                
			$wishlist_output .= '</div>';
            }
			
			
	 		do_action( 'yith_wcwl_after_wishlist' );
	 				
			$wishlist_output .= '</div>';                                                                                                          
			$wishlist_output .= '</li>';
			$wishlist_output .= '</ul>';                                                                                                          
			$wishlist_output .= '</li>'; 
					
			return $wishlist_output;
		}
	}
	
	
	/* AJAX SEARCH
	================================================== */
	if (!function_exists('ct_ajaxsearch')) {
		function ct_ajaxsearch() {
			$search_term = trim($_POST['s']);
			$search_query_args = array(
				's' => $search_term,
				'post_type' => 'any',
				'post_status' => 'publish',
				'suppress_filters' => false,
				'numberposts' => -1
			);
			$search_query_args = http_build_query($search_query_args);
			$search_results = get_posts( $search_query_args );
			$count = count($search_results);
			$shown_results = 5;
			
			if (!empty($search_results)) {
				
				$sorted_posts = $post_type = array();
				$search_results_ouput = "";
				
				foreach ($search_results as $search_result) {
					$sorted_posts[$search_result->post_type][] = $search_result;
				    // Check we don't already have this post type in the post_type array
				    if (empty($post_type[$search_result->post_type])) {
				    	// Add the post type object to the post_type array
				        $post_type[$search_result->post_type] = get_post_type_object($search_result->post_type);
				    }			
				}
				
				$i = 0;
				foreach ($sorted_posts as $key => $type) {
					$search_results_ouput .= '<div class="search-result-pt">';
			        if(isset($post_type[$key]->labels->name)) {
			            $search_results_ouput .= "<h6>".$post_type[$key]->labels->name."</h6>";
			        } else {
			            $search_results_ouput .= "<h6>".__("Products", "cootheme")."</h6>";
			        }
		
			        foreach ($type as $post) {
			        	
			        	$img_icon = "";
			        	
			        	$post_format = get_post_format($post->ID);
			        	if ( $post_format == "" ) {
			        		$post_format = 'standard';
			        	}
			        	$post_type = get_post_type($post->ID);
			        	
			        	if ($post_type == "post") {
			        		if ($post_format == "quote" || $post_format == "status") {
			        			$img_icon = "ss-quote";
			        		} else if ($post_format == "image") {
			        			$img_icon = "ss-picture";
			        		} else if ($post_format == "chat") {
			        			$img_icon = "ss-chat";
			        		} else if ($post_format == "audio") {
			        			$img_icon = "ss-music";
			        		} else if ($post_format == "video") {
			        			$img_icon = "ss-video";
			        		} else if ($post_format == "link") {
			        			$img_icon = "ss-link";
			        		} else {
			        			$img_icon = "ss-pen";
			        		}
			        	} else if ($post_type == "product") {
			        		$img_icon = "ss-cart";
			        	} else if ($post_type == "portfolio") {
			        		$img_icon = "ss-picture";
			        	} else if ($post_type == "team") {
			        		$img_icon = "ss-user";
			        	} else if ($post_type == "galleries") {
			        		$img_icon = "ss-picture";
			        	} else {
			        		$img_icon = "ss-file";
			        	}
			        	
			        	$post_title = get_the_title();
			        	$post_date = get_the_date();
			        	$post_permalink = get_permalink();
			        	
			        	$image = get_the_post_thumbnail( $post->ID, 'thumbnail' );
			        	
			            $search_results_ouput .= '<div class="search-result">';
			        	
			        	if ($image) {
			        		$search_results_ouput .= '<div class="search-item-img"><a href="'.$post_permalink.'">'.$image.'</div>';
			        	} else {
			        		$search_results_ouput .= '<div class="search-item-img"><a href="'.$post_permalink.'" class="img-holder"><i class="'.$img_icon.'"></i></a></div>';
			        	}
			        	            				
			            $search_results_ouput .= '<div class="search-item-content">';
			            $search_results_ouput .= '<h5><a href="'.get_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h5>';
			            if ($post_type == "product") {
			            $price = get_post_meta( $post->ID, '_regular_price', true);	            
			            $sale = get_post_meta( $post->ID, '_sale_price', true);
			            if ($sale != "") {
			            $price = $sale;
			            }
			            $search_results_ouput .= '<span>'.get_woocommerce_currency_symbol().$price.'</span>';
			            } else {
			            $search_results_ouput .= '<time>'.$post_date.'</time>';
			            }
			            $search_results_ouput .= '</div>';
			            
			            $search_results_ouput .= '</div>';
			        	
			        	$i++;
			        	if ($i == $shown_results) break;
			        }
			       
			       $search_results_ouput .= '</div>';
			        if ($i == $shown_results) break;
			    }
			    
			    if ($count > 1) {
			    	$search_results_ouput .= '<a href="#" class="all-results">'.sprintf(__("View all %d results", "cootheme"), $count).'</a>';
			    }
				
			} else {
				
				$search_results_ouput .= '<div class="no-search-results">';
				$search_results_ouput .= '<h6>'.__("No results", "cootheme").'</h6>';
				$search_results_ouput .= '<p>'.__("No search results could be found, please try another query.", "cootheme").'</p>';
				$search_results_ouput .= '</div>';
				
			}
			
			echo $search_results_ouput;
			die();
		}
		add_action('wp_ajax_ct_ajaxsearch', 'ct_ajaxsearch');
		add_action('wp_ajax_nopriv_ct_ajaxsearch', 'ct_ajaxsearch');
	}
	
	if (!function_exists('ct_ajaxurl')) {
		function ct_ajaxurl() {
		?>
			<script type="text/javascript">
			var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
			</script>
		<?php 
		}
		add_action('wp_head','ct_ajaxurl');
	}
	
?>