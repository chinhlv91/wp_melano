<?php

	/* ==================================================
	
	Clients Post Type Functions
	
	================================================== */
	    
	    
	$args = array(
		"label" 						=> _x('Client Categories', 'category label', "coo-theme-admin"),
		"singular_label" 				=> _x('Client Category', 'category singular label', "coo-theme-admin"),
	    'public'                        => true,
	    'hierarchical'                  => true,
	    'show_ui'                       => true,
	    'show_in_nav_menus'             => false,
	    'args'                          => array( 'orderby' => 'term_order' ),
	    'rewrite'                       => false,
	    'query_var'                     => true
	);
	
	register_taxonomy( 'clients-category', 'clients', $args );
	
	
	add_action('init', 'clients_register');  
	  
	function clients_register() {  
	
	    $labels = array(
	        'name' => _x('Clients', 'post type general name', "coo-theme-admin"),
	        'singular_name' => _x('Client', 'post type singular name', "coo-theme-admin"),
	        'add_new' => _x('Add New', 'Client', "coo-theme-admin"),
	        'add_new_item' => __('Add New Client', "coo-theme-admin"),
	        'edit_item' => __('Edit Client', "coo-theme-admin"),
	        'new_item' => __('New Client', "coo-theme-admin"),
	        'view_item' => __('View Client', "coo-theme-admin"),
	        'search_items' => __('Search Clients', "coo-theme-admin"),
	        'not_found' =>  __('No clients have been added yet', "coo-theme-admin"),
	        'not_found_in_trash' => __('Nothing found in Trash', "coo-theme-admin"),
	        'parent_item_colon' => ''
	    );
	
	    $args = array(  
	        'labels' => $labels,  
	        'public' => true,  
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'show_in_nav_menus' => false,
	        'rewrite' => false,
	        'supports' => array('title', 'thumbnail'),
	        'has_archive' => true,
	        'taxonomies' => array('clients-category', 'post_tag')
	       );  
	  
	    register_post_type( 'clients' , $args );  
	}  
	
	add_filter("manage_edit-clients_columns", "clients_edit_columns");   
	  
	function clients_edit_columns($columns){  
	        $columns = array(  
	            "cb" => "<input type=\"checkbox\" />",  
	            "thumbnail" => "",
	            "title" => __("Client", "coo-theme-admin"),
	            "clients-category" => __("Categories", "coo-theme-admin")
	        );  
	  
	        return $columns;  
	}  

?>