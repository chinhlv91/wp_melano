<?php

class CooPageBuilderShortcode_testimonial_slider extends CooPageBuilderShortcode {

    public function content( $atts, $content = null ) {

        $title = $order = $text_size = $items = $el_class = $width = $el_position = '';

        extract(shortcode_atts(array(
        	'title' => '',
        	'text_size' => '',
           	'item_count'	=> '',
           	'order'	=> '',
        	'category'		=> 'all',
        	'animation'		=> 'fade',
        	'autoplay'		=> 'yes',
            'el_class' => '',
            'alt_background'	=> 'none',
            'el_position' => '',
            'width' => '1/1',
            'control_nav'=> 'yes',
            'control_button_nav'=> 'yes',
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
        	'posts_per_page' => $item_count,
        	'no_found_rows' => 1,
        	);
        	    		
        $testimonials = new WP_Query( $testimonials_args );


            if ($autoplay == "yes") {
            $items .= '<div class="flexslider testimonials-slider content-slider" data-animation="'.$animation.'" data-autoplay="yes"><ul class="slides">';
            } else {
            $items .= '<div class="flexslider testimonials-slider content-slider" data-animation="'.$animation.'" data-autoplay="no"><ul class="slides">';
            }
                  
        // TESTIMONIAL LOOP
        
        while ( $testimonials->have_posts() ) : $testimonials->the_post();
        	
        	$testimonial_text = get_the_content();
        	$testimonial_cite = get_post_meta($post->ID, 'ct_testimonial_cite', true);
        	$testimonial_cite_subtext = get_post_meta($post->ID, 'ct_testimonial_cite_subtext', true);
        	
        	$items .= '<li class="testimonial">';
        	$items .= '<div class="testimonial-text text-'.$text_size.'">'.do_shortcode($testimonial_text).'</div>'; 
        	if ($testimonial_cite_subtext != "") {
        	$items .= '<cite>'.$testimonial_cite.' - '.$testimonial_cite_subtext.'</cite>';
        	} else {
        	$items .= '<cite>'.$testimonial_cite.'</cite>';
        	}
        	$items .= '</li>';
        	        
        endwhile;
        
        wp_reset_postdata();
        		
        $items .= '</ul></div>';
        $control_nav_value = 'false';
        $control_button_nav_check = 'false';
        if( $control_nav == 'yes')
            $control_nav_value = 'true';
        if($control_button_nav == 'yes')
            $control_button_nav_check = 'true';

        $items .= "
            <script>
            jQuery(document).ready(function() {
                jQuery('.content-slider').each(function() {
                    var slider = jQuery(this),
                            autoplay = ((slider.attr('data-autoplay') === 'yes') ? true : false);

                    slider.flexslider({
                        animation: 'fade',
                        slideshow: autoplay,	//Boolean: Animate slider automatically
                        slideshowSpeed: 6000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
                        animationDuration: 1000,			//Integer: Set the speed of animations, in milliseconds
                        smoothHeight: true,
                        directionNav: ".$control_button_nav_check.",             //Boolean: Create navigation for previous/next navigation? (true/false)
                        controlNav: ".$control_nav_value.",               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                        start: function() {}
                    });
                });
            });
        </script>
        ";

        $el_class = $this->getExtraClass($el_class);
        $width = spb_translateColumnWidthToSpan($width);

        $sidebar_config = get_post_meta(get_the_ID(), 'ct_sidebar_config', true);
        
        $sidebars = '';
        if (($sidebar_config == "left-sidebar") || ($sidebar_config == "right-sidebar")) {
        $sidebars = 'one-sidebar';
        } else if ($sidebar_config == "both-sidebars") {
        $sidebars = 'both-sidebars';
        } else {
        $sidebars = 'no-sidebars';
        }

        $el_class .= ' testimonial';
        
        if ($alt_background == "none" || $sidebars != "no-sidebars") {
		$output .= "\n\t".'<div class="spb_testimonial_slider_widget spb_content_element '.$width.$el_class.'">';
        } else {
        $output .= "\n\t".'<div class="spb_testimonial_slider_widget spb_content_element alt-bg '.$alt_background.' '.$width.$el_class.'">';            
        }
        $output .= "\n\t\t".'<div class="spb_wrapper slider-wrap">';
        $output .= ($title != '' ) ? "\n\t\t\t".'<div class="heading-wrap"><h3 class="spb-heading spb-center-heading"><span>'.$title.'</span></h3></div>' : '';
        $output .= "\n\t\t\t".$items;
        $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
        $output .= "\n\t".'</div> '.$this->endBlockComment($width);

        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
        
        global $ct_include_carousel;
        $ct_include_carousel = true;
        
        return $output;
    }
}

SPBMap::map( 'testimonial_slider', array(
    "name"		=> __("Testimonials Slider", "coo-page-builder"),
    "base"		=> "testimonial_slider",
    "class"		=> "spb_testimonial_slider spb_slider",
    "icon"      => "spb-icon-testimonial_slider",
    "wrapper_class" => "clearfix",
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
            "description" => __("The number of testimonials to show. Leave blank to show ALL testimonials.", "coo-page-builder")
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
            "heading" => __("Slider autoplay", "coo-page-builder"),
            "param_name" => "autoplay",
            "value" => array(__('Yes', "coo-page-builder") => "yes", __('No', "coo-page-builder") => "no"),
            "description" => __("Select if you want the slider to autoplay or not.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show alt background", "coo-page-builder"),
            "param_name" => "alt_background",
            "value" => array(__("None", "coo-page-builder") => "none", __("Alt 1", "coo-page-builder") => "alt-one", __("Alt 2", "coo-page-builder") => "alt-two", __("Alt 3", "coo-page-builder") => "alt-three", __("Alt 4", "coo-page-builder") => "alt-four", __("Alt 5", "coo-page-builder") => "alt-five", __("Alt 6", "coo-page-builder") => "alt-six", __("Alt 7", "coo-page-builder") => "alt-seven", __("Alt 8", "coo-page-builder") => "alt-eight", __("Alt 9", "coo-page-builder") => "alt-nine", __("Alt 10", "coo-page-builder") => "alt-ten"),
            "description" => __("Show an alternative background around the asset. These can all be set in Theme Options > Asset Background Options. NOTE: This is only available on a page with the no sidebar setup.", "coo-page-builder")
        ),
        array(
            "type" => "altbg_preview",
            "heading" => __("Alt Background Preview", "coo-page-builder"),
            "param_name" => "altbg_preview",
            "value" => "",
            "description" => __("", "coo-page-builder")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Extra class name", "coo-page-builder"),
            "param_name" => "el_class",
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Enable Bullet Control Nav", "coo-page-builder"),
            "param_name" => "control_nav",
            "value" => array(__('Yes', "coo-page-builder") => "yes", __('No', "coo-page-builder") => "no"),
            "description" => __("Select if you want the slider enable control nav.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Enable Control Button Nav", "coo-page-builder"),
            "param_name" => "control_button_nav",
            "value" => array(__('Yes', "coo-page-builder") => "yes", __('No', "coo-page-builder") => "no"),
            "description" => __("Select if you want the slider enable control button nav.", "coo-page-builder")
        ),
    )
) );

?>