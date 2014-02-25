<?php

class CooPageBuilderShortcode_ct_gallery extends CooPageBuilderShortcode {

    protected function content($atts, $content = null) {

		   	$title = $width = $el_class = $gallery_id = $output = $items = $main_slider = $thumb_slider = $el_position = '';
		
	        extract(shortcode_atts(array(
	        	'title' => '',
	        	'gallery_id' => '',
	        	'show_thumbs' => '',
	        	'show_captions' => '',
	        	'slider_transition' => 'slide',
	        	'el_position' => '',
	        	'width' => '1/1',
	        	'el_class' => ''
	        ), $atts));
	        
	        
	        /* SIDEBAR CONFIG
	        ================================================== */ 
	        $sidebar_config = get_post_meta(get_the_ID(), 'ct_sidebar_config', true);
	        	        
	        $sidebars = '';
	        if (($sidebar_config == "left-sidebar") || ($sidebar_config == "right-sidebar")) {
	        $sidebars = 'one-sidebar';
	        } else if ($sidebar_config == "both-sidebars") {
	        $sidebars = 'both-sidebars';
	        } else {
	        $sidebars = 'no-sidebars';
	        }
	        
	        
	        /* GALLERY
	        ================================================== */
	        
	        $gallery_args = array(
	        	'post_type' => 'galleries',
	        	'post_status' => 'publish',
	        	'p' => $gallery_id
	        );
	        	    		
	        $gallery_query = new WP_Query( $gallery_args );
	        
	        while ( $gallery_query->have_posts() ) : $gallery_query->the_post();
	        
		       	$gallery_images = rwmb_meta( 'ct_gallery_images', 'type=image&size=full-width-image-gallery');
		       	//$thumb_images = rwmb_meta( 'ct_gallery_images', 'type=image&size=thumb-square');
   			       	
		       	$main_slider .= '<div class="flexslider gallery-slider" data-transition="'.$slider_transition.'"><ul class="slides">'. "\n";
		       				
		       	foreach ( $gallery_images as $image ) {       		
		       	    $main_slider .= "<li><a href='{$image['url']}' class='view' rel='gallery-{$gallery_id}'><img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$image['alt']}' /></a>";
		       	    if ($show_captions == "yes" && $image['caption'] != "") {
		       	    $main_slider .= '<p class="flex-caption">'.$image['caption'].'</p>';
		       	    }
		       	    $main_slider .= "</li>". "\n";
		       	}
		       													
		       	$main_slider .= '</ul></div>'. "\n";
		        
//		        if ($show_thumbs == "yes") {
//		        
//		        $thumb_slider .= '<div class="flexslider gallery-nav"><ul class="slides">'. "\n";
//		        
//		        foreach ( $thumb_images as $image ) {
//		            $thumb_slider .= "<li><img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$image['alt']}' /></li>". "\n";
//		        }
//		        
//		        $thumb_slider .= '</ul></div>'. "\n";
//		        
//		        }
		        
		        $items .= $main_slider;
	        	//$items .= $thumb_slider;
	        	
	        endwhile;
	        
	        
			/* PAGE BUILDER OUTPUT
			================================================== */ 
    		$width = spb_translateColumnWidthToSpan($width);
    		$el_class = $this->getExtraClass($el_class);
            
            $output .= "\n\t".'<div class="spb_gallery_widget spb_content_element '.$width.$el_class.'">';
            $output .= "\n\t\t".'<div class="spb_wrapper gallery-wrap">';
            $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading"><span>'.$title.'</span></h3>' : '';
            $output .= "\n\t\t\t".$items;
            $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
            $output .= "\n\t".'</div> '.$this->endBlockComment($width);
    
            $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
            
            global $ct_has_gallery;
            $ct_has_gallery = true;

            return $output;
		
    }
}

SPBMap::map( 'ct_gallery', array(
    "name"		=> __("Gallery", "coo-page-builder"),
    "base"		=> "ct_gallery",
    "class"		=> "spb_gallery",
    "icon"      => "spb-icon-gallery",
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
            "heading" => __("Gallery", "coo-page-builder"),
            "param_name" => "gallery_id",
            "value" => ct_list_galleries(),
            "description" => __("Choose the gallery which you'd like to display. You can add galleries in the left admin area.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Slider transition", "coo-page-builder"),
            "param_name" => "slider_transition",
            "value" => array(__("Slide", "coo-page-builder") => "slide", __("Fade", "coo-page-builder") => "fade"),
            "description" => __("Choose the transition type for the slider.", "coo-page-builder")
        ),
//        array(
//            "type" => "dropdown",
//            "heading" => __("Show thumbnail navigation", "coo-page-builder"),
//            "param_name" => "show_thumbs",
//            "value" => array(__("Yes", "coo-page-builder") => "yes", __("No", "coo-page-builder") => "no"),
//            "description" => __("Show a thumbnail navigation display below the slider.", "coo-page-builder")
//        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show captions", "coo-page-builder"),
            "param_name" => "show_captions",
            "value" => array(__("Yes", "coo-page-builder") => "yes", __("No", "coo-page-builder") => "no"),
            "description" => __("Choose whether to show captions on the slider or not.", "coo-page-builder")
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