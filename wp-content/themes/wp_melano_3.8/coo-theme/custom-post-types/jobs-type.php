<?php
	
	/* ==================================================
	
	Jobs Post Type Functions
	
	================================================== */
	    
	    
	$args = array(
	    "label" 						=> _x('Job Categories', 'category label', "coo-theme-admin"),
	    "singular_label" 				=> _x('Job Category', 'category singular label', "coo-theme-admin"),
	    'public'                        => true,
	    'hierarchical'                  => true,
	    'show_ui'                       => true,
	    'show_in_nav_menus'             => false,
	    'args'                          => array( 'orderby' => 'term_order' ),
	    'rewrite'                       => false,
	    'query_var'                     => true
	);
	
	register_taxonomy( 'jobs-category', 'jobs', $args );
	
	
	add_action('init', 'jobs_register');  
	  
	function jobs_register() {  
	
	    $labels = array(
	        'name' => _x('Jobs', 'post type general name', "coo-theme-admin"),
	        'singular_name' => _x('Job', 'post type singular name', "coo-theme-admin"),
	        'add_new' => _x('Add New', 'job', "coo-theme-admin"),
	        'add_new_item' => __('Add New Job', "coo-theme-admin"),
	        'edit_item' => __('Edit Job', "coo-theme-admin"),
	        'new_item' => __('New Job', "coo-theme-admin"),
	        'view_item' => __('View Job', "coo-theme-admin"),
	        'search_items' => __('Search Jobs', "coo-theme-admin"),
	        'not_found' =>  __('No jobs have been added yet', "coo-theme-admin"),
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
	        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
	        'has_archive' => true,
	        'taxonomies' => array('jobs-category', 'post_tag')
	       );  
	  
	    register_post_type( 'jobs' , $args );  
	}  
	
	add_filter("manage_edit-jobs_columns", "jobs_edit_columns");   
	  
	function jobs_edit_columns($columns){  
	        $columns = array(  
	            "cb" => "<input type=\"checkbox\" />",  
	            "thumbnail" => "",
	            "title" => __("Job", "coo-theme-admin"),
	            "description" => __("Description", "coo-theme-admin"),
	            "jobs-category" => __("Categories", "coo-theme-admin")
	        );  
	  
	        return $columns;  
	}  

?>