<?php

/* ==================================================

Gallery Post Type Functions

================================================== */


$args = array(
    "label" 						=> _x('Gallery Categories', 'category label', "coo-theme-admin"),
    "singular_label" 				=> _x('Gallery Category', 'category singular label', "coo-theme-admin"),
    'public'                        => true,
    'hierarchical'                  => true,
    'show_ui'                       => true,
    'show_in_nav_menus'             => false,
    'args'                          => array( 'orderby' => 'term_order' ),
	'rewrite' 						=> false,
    'query_var'                     => true
);

register_taxonomy( 'gallery-category', 'gallery', $args );

add_action('init', 'galleries_register');  
  
function galleries_register() {
		
    $labels = array(
        'name' => _x('Galleries', 'post type general name', "coo-theme-admin"),
        'singular_name' => _x('Gallery', 'post type singular name', "coo-theme-admin"),
        'add_new' => _x('Add New', 'gallery', "coo-theme-admin"),
        'add_new_item' => __('Add New Gallery', "coo-theme-admin"),
        'edit_item' => __('Edit Gallery', "coo-theme-admin"),
        'new_item' => __('New Gallery', "coo-theme-admin"),
        'view_item' => __('View Gallery', "coo-theme-admin"),
        'search_items' => __('Search Galleries', "coo-theme-admin"),
        'not_found' =>  __('No galleries have been added yet', "coo-theme-admin"),
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
        'rewrite' => false,
        'supports' => array('title', 'thumbnail'),
        'has_archive' => true,
        'taxonomies' => array('gallery-category')
       );  
  
    register_post_type( 'galleries' , $args );  
}  

add_filter("manage_edit-galleries_columns", "galleries_edit_columns");   
  
function galleries_edit_columns($columns){  
        $columns = array(  
            "cb" => "<input type=\"checkbox\" />", 
            "thumbnail" => "",
            "title" => __("Gallery", "coo-theme-admin"),
            "gallery-category" => __("Categories", "coo-theme-admin")
        );  
  
        return $columns;  
}

?>