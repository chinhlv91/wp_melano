<?php

	/* ==================================================
	
	Team Post Type Functions
	
	================================================== */
	    
	    
	$args = array(
	    "label" 						=> _x('Team Categories', 'category label', "coo-theme-admin"),
	    "singular_label" 				=> _x('Team Category', 'category singular label', "coo-theme-admin"),
	    'public'                        => true,
	    'hierarchical'                  => true,
	    'show_ui'                       => true,
	    'show_in_nav_menus'             => false,
	    'args'                          => array( 'orderby' => 'term_order' ),
	    'rewrite'                       => false,
	    'query_var'                     => true
	);
	
	register_taxonomy( 'team-category', 'team', $args );
	
	
	add_action('init', 'team_register');  
	  
	function team_register() {  
	
	    $labels = array(
	        'name' => _x('Team', 'post type general name', "coo-theme-admin"),
	        'singular_name' => _x('Team Member', 'post type singular name', "coo-theme-admin"),
	        'add_new' => _x('Add New', 'team member', "coo-theme-admin"),
	        'add_new_item' => __('Add New Team Member', "coo-theme-admin"),
	        'edit_item' => __('Edit Team Member', "coo-theme-admin"),
	        'new_item' => __('New Team Member', "coo-theme-admin"),
	        'view_item' => __('View Team Member', "coo-theme-admin"),
	        'search_items' => __('Search Team Members', "coo-theme-admin"),
	        'not_found' =>  __('No team members have been added yet', "coo-theme-admin"),
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
	        'supports' => array('title', 'editor', 'thumbnail'),
	        'has_archive' => true,
	        'taxonomies' => array('team-category', 'post_tag')
	       );  
	  
	    register_post_type( 'team' , $args );  
	}  
	
	add_filter("manage_edit-team_columns", "team_edit_columns");   
	  
	function team_edit_columns($columns){  
	        $columns = array(  
	            "cb" => "<input type=\"checkbox\" />",  
	            "thumbnail" => "",
	            "title" => __("Team Member", "coo-theme-admin"),
	            "description" => __("Description", "coo-theme-admin"),
	            "team-category" => __("Categories", "coo-theme-admin")
	        );  
	  
	        return $columns;  
	}

?>