<?php
	
	/*
	*
	*	Cootheme Main Class
	*	------------------------------------------------
	*	Cootheme v2.0
	* 	http://www.cootheme.com
	*
	*/
	
	
	/* COO FUNCTIONS
	================================================== */  
	include_once(CT_FRAMEWORK_PATH . '/ct-functions.php');
	

	/* CUSTOM POST TYPES
	================================================== */  
	require_once(CT_FRAMEWORK_PATH . '/custom-post-types/portfolio-type.php');
	require_once(CT_FRAMEWORK_PATH . '/custom-post-types/gallery-type.php');
	require_once(CT_FRAMEWORK_PATH . '/custom-post-types/team-type.php');
	require_once(CT_FRAMEWORK_PATH . '/custom-post-types/clients-type.php');
	require_once(CT_FRAMEWORK_PATH . '/custom-post-types/testimonials-type.php');
	require_once(CT_FRAMEWORK_PATH . '/custom-post-types/jobs-type.php');
	require_once(CT_FRAMEWORK_PATH . '/custom-post-types/faqs-type.php');
	require_once(CT_FRAMEWORK_PATH . '/custom-post-types/ct-post-type-permalinks.php');
	
	
	/* COO PAGE BUILDER
	================================================== */ 
	include_once(CT_FRAMEWORK_PATH . '/page-builder/ct-page-builder.php');
	
	
	/* META BOX FRAMEWORK
	================================================== */  
	include_once(CT_FRAMEWORK_PATH . '/meta-box/meta-box.php');
	include_once(CT_FRAMEWORK_PATH . '/meta-boxes.php');
		
	
	/* WOOCOMMERCE FILTERS/HOOKS
	================================================== */  
	include_once(CT_FRAMEWORK_PATH . '/ct-woocommerce.php');
	
	
	/* SHORTCODES
	================================================== */  
	include_once(CT_FRAMEWORK_PATH . '/shortcodes.php');
	
	
	/* MEGA MENU
	================================================== */  
	include_once(CT_FRAMEWORK_PATH . '/ct-megamenu/ct-megamenu.php');

	
	/* SUPER SEARCH
	================================================== */  
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	include_once(CT_FRAMEWORK_PATH . '/ct-supersearch.php');
	}
	
	
	/* WIDGETS
	================================================== */  
	include_once(CT_FRAMEWORK_PATH . '/widgets/widget-twitter.php');
	include_once(CT_FRAMEWORK_PATH . '/widgets/widget-flickr.php');
	include_once(CT_FRAMEWORK_PATH . '/widgets/widget-video.php');
	include_once(CT_FRAMEWORK_PATH . '/widgets/widget-posts.php');
	include_once(CT_FRAMEWORK_PATH . '/widgets/widget-portfolio.php');
	include_once(CT_FRAMEWORK_PATH . '/widgets/widget-portfolio-grid.php');
	include_once(CT_FRAMEWORK_PATH . '/widgets/widget-advertgrid.php');
	include_once(CT_FRAMEWORK_PATH . '/widgets/widget-infocus.php');
	include_once(CT_FRAMEWORK_PATH . '/widgets/widget-comments.php');
	
	
	/* TEXT DOMAIN
	================================================== */
	load_theme_textdomain( 'coo-theme-admin', get_template_directory() . '/coo-theme/language' );
	
?>