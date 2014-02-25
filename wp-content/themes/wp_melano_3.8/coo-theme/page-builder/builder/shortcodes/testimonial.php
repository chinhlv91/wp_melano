<?php

class CooPageBuilderShortcode_testimonial extends CooPageBuilderShortcode {

    public function content( $atts, $content = null ) {

        $title = $order = $page_link = $text_size = $items = $el_class = $width = $el_position = '';

        extract(shortcode_atts(array(
        	'title' => '',
        	'text_size' => '',
           	'item_count'	=> '-1',
           	'order'	=> '',
        	'category'		=> '',
        	'pagination'	=> 'no',
        	'page_link'	=> '',
            'el_class' => '',
            'el_position' => '',
            'width' => '1/2'
        ), $atts));

        $output = '';
        
        // CATEGORY SLUG MODIFICATION
        if ($category == "All") {$category = "all";}
        if ($category == "all") {$category = '';}
        $category_slug = str_replace('_', '-', $category);
        
        
        // TESTIMONIAL QUERY SETUP
        
        global $post, $wp_query;
        
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            		
        $testimonials_args = array(
        	'orderby' => $order,
        	'post_type' => 'testimonials',
        	'post_status' => 'publish',
        	'paged' => $paged,
        	'testimonials-category' => $category_slug,
        	'posts_per_page' => $item_count
        	);
        	    		
        $testimonials = new WP_Query( $testimonials_args );
                
        $items .= '<ul class="testimonials clearfix">';
        
        // TESTIMONIAL LOOP
        
        while ( $testimonials->have_posts() ) : $testimonials->the_post();
        	
        	$testimonial_text = get_the_content();
        	$testimonial_cite = get_post_meta($post->ID, 'ct_testimonial_cite', true);
        	$testimonial_cite_subtext = get_post_meta($post->ID, 'ct_testimonial_cite_subtext', true);
        	$testimonial_image = rwmb_meta('ct_testimonial_cite_image', 'type=image', $post->ID);
        			
        	foreach ($testimonial_image as $detail_image) {
        		$testimonial_image_url = $detail_image['url'];
        		break;
        	}
        									
        	if (!$testimonial_image) {
        		$testimonial_image = get_post_thumbnail_id();
        		$testimonial_image_url = wp_get_attachment_url( $testimonial_image, 'full' );
        	}
        	
        	$testimonial_image = aq_resize( $testimonial_image_url, 70, 70, true, false);
        	
        	$items .= '<li class="testimonial">';
        	$items .= '<div class="testimonial-text">'.do_shortcode($testimonial_text).'</div>'; 
        	$items .= '<div class="testimonial-cite">';		
        	if ($testimonial_image) {
        	$items .= '<img src="'.$testimonial_image[0].'" width="'.$testimonial_image[1].'" height="'.$testimonial_image[2].'" alt="'.$testimonial_cite.'" />';
        	$items .= '<div class="cite-text has-cite-image"><span class="cite-name">'.$testimonial_cite.'</span><span>'.$testimonial_cite_subtext.'</span></div>';
        	} else {
        	$items .= '<div class="cite-text"><span class="cite-name">'.$testimonial_cite.'</span><span>'.$testimonial_cite_subtext.'</span></div>';
        	}
        	$items .= '</div>';
        	$items .= '</li>';
        	        
        endwhile;
        
        wp_reset_postdata();
        		
        $items .= '</ul>';
       
   		if ($page_link == "yes") {
	        $options = get_option('ct_coo_options');
	        $testimonials_page = __($options['testimonial_page'], 'cootheme');
	               
	        if ($testimonials_page) {
	        	$items .= '<a href="'.get_permalink($testimonials_page).'" class="read-more">'.__("More", "cootheme").'<i class="ss-navigateright"></i></a>';
	        }
		}
        
        // PAGINATION
        
        if ($pagination == "yes") {
        
        $items .= '<div class="pagination-wrap">';
        
        if($testimonials->max_num_pages>1){
        	
        	$items .= '<ul>';
        
            for($i=1;$i<=$testimonials->max_num_pages;$i++) {
            	if ($i == $paged) {
            		$items .= '<li><span>'.$i.'</span></li>';
            	} else {
             		$items .= '<li><a href="'. get_permalink() .'page/'.$i.'">'.$i.'</a></li>';
            	}
            }
            
            $items .= '</ul>';
            
        }
        					
        $items .= '</div>';
        
        }       

        $el_class = $this->getExtraClass($el_class);
        $width = spb_translateColumnWidthToSpan($width);

        $el_class .= ' testimonial';

        $output .= "\n\t".'<div class="spb_content_element '.$width.$el_class.'">';
        $output .= "\n\t\t".'<div class="spb_wrapper testimonial-wrap '.$text_size.'">';
        $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading spb-text-heading"><span>'.$title.'</span></h3>' : '';
        $output .= "\n\t\t\t". $items;
        $output .= "\n\t\t".'</div> ' . $this->endBlockComment('.spb_wrapper');
        $output .= "\n\t".'</div> ' . $this->endBlockComment($width);

        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
        return $output;
    }
}

SPBMap::map( 'testimonial', array(
    "name"		=> __("Testimonials", "coo-page-builder"),
    "base"		=> "testimonial",
    "class"		=> "",
    "icon"      => "spb-icon-testimonial",
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
            "type" => "dropdown",
            "heading" => __("Text size", "coo-page-builder"),
            "param_name" => "text_size",
            "value" => array(__('Normal', "coo-page-builder") => "normal", __('Large', "coo-page-builder") => "large"),
            "description" => __("Choose the size of the text.", "coo-page-builder")
        ),
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __("Number of items", "coo-page-builder"),
            "param_name" => "item_count",
            "value" => "6",
            "description" => __("The number of testimonials to show per page. Leave blank to show ALL testimonials.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Testimonials Order", "coo-page-builder"),
            "param_name" => "order",
            "value" => array(__('Random', "coo-page-builder") => "rand", __('Latest', "coo-page-builder") => "date"),
            "description" => __("Choose the order of the testimonials.", "coo-page-builder")
        ),
        array(
            "type" => "select-multiple",
            "heading" => __("Testimonials category", "coo-page-builder"),
            "param_name" => "category",
            "value" => ct_get_category_list('testimonials-category'),
            "description" => __("Choose the category for the testimonials.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Pagination", "coo-page-builder"),
            "param_name" => "pagination",
            "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
            "description" => __("Show testimonial pagination (1/1 width element only).", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Testimonials page link", "coo-page-builder"),
            "param_name" => "page_link",
            "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
            "description" => __("Include a link to the testimonials page (which you must choose in the theme options).", "coo-page-builder")
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