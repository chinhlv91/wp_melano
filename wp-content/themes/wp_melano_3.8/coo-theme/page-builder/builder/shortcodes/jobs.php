<?php

class CooPageBuilderShortcode_jobs extends CooPageBuilderShortcode {

    public function content( $atts, $content = null ) {

        $title = $order = $items = $el_class = $width = $el_position = '';

        extract(shortcode_atts(array(
        	'title' => '',
           	'item_count'	=> '-1',
           	'order'	=> '',
        	'category'		=> '',
        	'pagination'	=> 'no',
            'el_class' => '',
            'el_position' => '',
            'width' => '1/2'
        ), $atts));

        $output = '';
        
        // CATEGORY SLUG MODIFICATION
        if ($category == "All") {$category = "all";}
        if ($category == "all") {$category = '';}
        $category_slug = str_replace('_', '-', $category);
        
        // JOBS QUERY SETUP
        
        global $post, $wp_query;
        
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            		
        $jobs_args = array(
        	'orderby' => $order,
        	'post_type' => 'jobs',
        	'post_status' => 'publish',
        	'paged' => $paged,
        	'jobs-category' => $category_slug,
        	'posts_per_page' => $item_count
        	);
        	    		
        $jobs = new WP_Query( $jobs_args );
                
        $items .= '<ul class="jobs clearfix">';
        
        // JOBS LOOP
        
        while ( $jobs->have_posts() ) : $jobs->the_post();
        	
        	$job_title = get_the_title();
        	$job_date = get_the_date();
        	$job_text = get_the_excerpt();
        	
        	$job_image = get_post_thumbnail_id();	
        	$job_image_url = wp_get_attachment_url( $job_image,'full' );
        	$image = aq_resize( $job_image_url, 90, NULL, true, false);
        				        	
        	$items .= '<li class="job">';

			if ($image) {
			$items .= '<img itemprop="image" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" />';
			$items .= '<div class="job-details has-job-image">';
			} else {
			$items .= '<div class="job-details">';
			}
        	$items .= '<span class="job-date">'.$job_date.'</span>';
        	$items .= '<h5>'.$job_title.'</h5>';
        	$items .= '<div class="job-text">'.do_shortcode($job_text).'</div>';
        	$items .= '<a href="'.get_permalink().'" class="read-more">'.__("Learn more", "cootheme").'</a>';
        	$items .= '</div>';
        	$items .= '</li>';
        	        
        endwhile;
        
        wp_reset_postdata();
        		
        $items .= '</ul>';
        
        
        // PAGINATION
        
       if ($pagination == "yes") {
       
       	$items .= '<div class="pagination-wrap">';
       	
       	$items .= pagenavi($jobs);
       						
       	$items .= '</div>';
       
       }    

        $el_class = $this->getExtraClass($el_class);
        $width = spb_translateColumnWidthToSpan($width);
        
        $output .= "\n\t".'<div class="spb_content_element '.$width.$el_class.'">';
        $output .= "\n\t\t".'<div class="spb_wrapper jobs-wrap">';
        $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading"><span>'.$title.'</span></h3>' : '';
        $output .= "\n\t\t\t". $items;
        $output .= "\n\t\t".'</div> ' . $this->endBlockComment('.spb_wrapper');
        $output .= "\n\t".'</div> ' . $this->endBlockComment($width);

        //
        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
        return $output;
    }
}

SPBMap::map( 'jobs', array(
    "name"		=> __("Jobs", "coo-page-builder"),
    "base"		=> "jobs",
    "class"		=> "",
    "icon"      => "spb-icon-jobs",
    "wrapper_class" => "clearfix",
    "controls"	=> "full",
    "params"	=> array(
    	array(
    	    "type" => "textfield",
    	    "heading" => __("Widget title", "coo-page-builder"),
    	    "param_name" => "title",
    	    "value" => "",
    	    "description" => __("Heading text. Leave it empty if not needed.", "coo-page-builder")
    	),
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __("Number of items", "coo-page-builder"),
            "param_name" => "item_count",
            "value" => "6",
            "description" => __("The number of jobs to show per page. Leave blank to show ALL jobs.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Jobs Order", "coo-page-builder"),
            "param_name" => "order",
            "value" => array(__('Random', "coo-page-builder") => "rand", __('Latest', "coo-page-builder") => "date"),
            "description" => __("Choose the order of the jobs.", "coo-page-builder")
        ),
        array(
            "type" => "select-multiple",
            "heading" => __("Jobs category", "coo-page-builder"),
            "param_name" => "category",
            "value" => ct_get_category_list('jobs-category'),
            "description" => __("Choose the category for the jobs.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Pagination", "coo-page-builder"),
            "param_name" => "pagination",
            "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
            "description" => __("Show jobs pagination.", "coo-page-builder")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "coo-page-builder"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "coo-page-builder")
        )
    )
) );

?>