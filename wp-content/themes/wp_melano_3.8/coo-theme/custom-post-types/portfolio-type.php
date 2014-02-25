<?php

	/* ==================================================
	
	Portfolio Post Type Functions
	
	================================================== */
	
	$portfolio_permalinks = get_option( 'ct_portfolio_permalinks' );
	
	$args = array(
	    "label" 						=> _x('Portfolio Categories', 'category label', "coo-theme-admin"),
	    "singular_label" 				=> _x('Portfolio Category', 'category singular label', "coo-theme-admin"),
	    'public'                        => true,
	    'hierarchical'                  => true,
	    'show_ui'                       => true,
	    'show_in_nav_menus'             => false,
	    'args'                          => array( 'orderby' => 'term_order' ),
		'rewrite' 						=> array(
					    					'slug'         => empty( $portfolio_permalinks['category_base'] ) ? _x( 'portfolio-category', 'slug', 'coo-theme-admin' ) : $portfolio_permalinks['category_base'],
					    					'with_front'   => false,
					    					'hierarchical' => true,
					    	            ),
	    'query_var'                     => true
	);
	
	register_taxonomy( 'portfolio-category', 'portfolio', $args );
	
	    
	add_action('init', 'portfolio_register');  
	  
	function portfolio_register() {
		
		$portfolio_permalinks = get_option( 'ct_portfolio_permalinks' );
		
		$portfolio_permalink = empty( $portfolio_permalinks['portfolio_base'] ) ? _x( 'portfolio', 'slug', 'coo-theme-admin' ) : $portfolio_permalinks['portfolio_base'];
		
	    $labels = array(
	        'name' => _x('Portfolio', 'post type general name', "coo-theme-admin"),
	        'singular_name' => _x('Portfolio Item', 'post type singular name', "coo-theme-admin"),
	        'add_new' => _x('Add New', 'portfolio item', "coo-theme-admin"),
	        'add_new_item' => __('Add New Portfolio Item', "coo-theme-admin"),
	        'edit_item' => __('Edit Portfolio Item', "coo-theme-admin"),
	        'new_item' => __('New Portfolio Item', "coo-theme-admin"),
	        'view_item' => __('View Portfolio Item', "coo-theme-admin"),
	        'search_items' => __('Search Portfolio', "coo-theme-admin"),
	        'not_found' =>  __('No portfolio items have been added yet', "coo-theme-admin"),
	        'not_found_in_trash' => __('Nothing found in Trash', "coo-theme-admin"),
	        'parent_item_colon' => ''
	    );
			
	    $args = array(  
	        'labels' => $labels,  
	        'public' => true,  
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'show_in_nav_menus' => false,
	        'hierarchical' => false,
	        'rewrite' => $portfolio_permalink != "portfolio" ? array(
	        				'slug' => untrailingslashit( $portfolio_permalink ),
	        				'with_front' => false,
	        				'feeds' => true )
	        			: false,
	        'supports' => array('title', 'editor', 'thumbnail'),
	        'has_archive' => true,
	        'taxonomies' => array('portfolio-category')
	       );  
	  
	    register_post_type( 'portfolio' , $args );  
	}  
	
	add_filter("manage_edit-portfolio_columns", "portfolio_edit_columns");   
	  
	function portfolio_edit_columns($columns){  
	        $columns = array(  
	            "cb" => "<input type=\"checkbox\" />",  
	            "thumbnail" => "",
	            "title" => __("Portfolio Item", "coo-theme-admin"),
	            "description" => __("Description", "coo-theme-admin"),
	            "portfolio-category" => __("Categories", "coo-theme-admin")
	        );  
	  
	        return $columns;  
	}

?>