<?php
	
	/*
	*
	*	Cootheme Menu Functions
	*	------------------------------------------------
	*	Cootheme v2.0
	* 	http://www.cootheme.com
	*
	*	ct_setup_menus()
	*
	*/
	
	
	/* CUSTOM MENU SETUP
	================================================== */
	if (!function_exists('ct_setup_menus')) {
		function ct_setup_menus() {
			// This theme uses wp_nav_menu() in four locations.
			register_nav_menus( array(
			'main_navigation' => __( 'Main Menu', "cootheme" ),
			'mobile_menu' => __( 'Mobile Menu', "cootheme" ),
			'top_bar_menu' => __( 'Top Bar Menu', "cootheme" ),
			'footer_menu' => __( 'Footer Menu', "cootheme" )
			) );
		}
		add_action( 'init', 'ct_setup_menus' );
	}
	
	
?>