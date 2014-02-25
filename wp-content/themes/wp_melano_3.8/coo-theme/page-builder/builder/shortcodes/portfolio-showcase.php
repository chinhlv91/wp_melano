<?php

class CooPageBuilderShortcode_portfolio_showcase extends CooPageBuilderShortcode {

    protected function content($atts, $content = null) {

		    $title = $category = $item_class = $width = $el_class = $output = $filter = $items = $el_position = '';
		
	        extract(shortcode_atts(array(
		        'title' => '',
	        	"item_count"	=> '5',
	        	"category"		=> 'all',
	        	'alt_background'	=> 'none',
	        	'el_position' => '',
	        	'width' => '1/1',
	        	'el_class' => ''
	        ), $atts));
	        
	        // CATEGORY SLUG MODIFICATION
	        if ($category == "All") {$category = "all";}
	        if ($category == "all") {$category = '';}
	        $category_slug = str_replace('_', '-', $category);
		    
    		global $post, $wp_query;
    		
    		$portfolio_args=array(
    			'post_type' => 'portfolio',
    			'post_status' => 'publish',
    			'portfolio-category' => $category_slug,
    			'posts_per_page' => $item_count,
    			'no_found_rows' => 1
    			);
    			    		
    		$portfolio_items = new WP_Query( $portfolio_args );
    		    		    		
			$items .= '<div class="portfolio-showcase-wrap"><ul class="portfolio-showcase-items clearfix" data-columns="'.$item_count.'">';
	
			while ( $portfolio_items->have_posts() ) : $portfolio_items->the_post();
				
				$thumb_img_url = "";
					
				$item_title = get_the_title();
				$item_subtitle = get_post_meta($post->ID, 'ct_portfolio_subtitle', true);
				
				$thumb_image = rwmb_meta('ct_thumbnail_image', 'type=image&size=full');
				$thumb_link_type = get_post_meta($post->ID, 'ct_thumbnail_link_type', true);
				$thumb_link_url = get_post_meta($post->ID, 'ct_thumbnail_link_url', true);
				$thumb_lightbox_thumb = rwmb_meta( 'ct_thumbnail_image', 'type=image&size=large' );
				$thumb_lightbox_image = rwmb_meta( 'ct_thumbnail_link_image', 'type=image&size=large' );
				$thumb_lightbox_video_url = get_post_meta($post->ID, 'ct_thumbnail_link_video_url', true);
				$thumb_lightbox_video_url = ct_get_embed_src($thumb_lightbox_video_url);
				
				foreach ($thumb_image as $detail_image) {
					$thumb_img_url = $detail_image['url'];
					break;
				}
																
				if (!$thumb_image || $thumb_img_url == "") {
					$thumb_image = get_post_thumbnail_id();
					$thumb_img_url = wp_get_attachment_url( $thumb_image, 'full' );
				}
									
				$thumb_lightbox_img_url = wp_get_attachment_url( $thumb_lightbox_image, 'full' );				
				
				$item_title = get_the_title();
				$permalink = get_permalink();
								
				if ($thumb_link_type == "link_to_url") {
					$link_config = 'href="'.$thumb_link_url.'" class="link-to-url"';
					$item_icon = "ss-link";
				} else if ($thumb_link_type == "link_to_url_nw") {
					$link_config = 'href="'.$thumb_link_url.'" class="link-to-url" target="_blank"';
					$item_icon = "ss-link";
				} else if ($thumb_link_type == "lightbox_thumb") {
					$link_config = 'href="'.$thumb_img_url.'" class="view"';
					$item_icon = "ss-view";
				} else if ($thumb_link_type == "lightbox_image") {
					$lightbox_image_url = '';
					foreach ($thumb_lightbox_image as $image) {
						$lightbox_image_url = $image['full_url'];
					}
					$link_config = 'href="'.$lightbox_image_url.'" class="view"';	
					$item_icon = "ss-view";
				} else if ($thumb_link_type == "lightbox_video") {
					$link_config = 'data-video="'.$thumb_lightbox_video_url.'" href="#" class="fw-video-link"';
					$item_icon = "ss-video";				
				} else {
					$link_config = 'href="'.$permalink.'" class="link-to-post"';
					$item_icon = "ss-navigateright";
				}
				    					   	
				$items .= '<li itemscope class="clearfix portfolio-item deselected-item '.$item_class.'">';
										
				// THUMBNAIL MEDIA TYPE SETUP
				$image_width = 700;
				$image_height = 350;
				if ($item_count == "5") {
				$image_width = 500;
				$image_height = 500;
				}
				
				if ($thumb_img_url == "") {
					$thumb_img_url = "default";
				}
				
				$image = aq_resize( $thumb_img_url, $image_width, $image_height, true, false);
				    					  					
				if ($image) {	
					$items .= '<a '.$link_config.'>';				
					$items .= '<img itemprop="image" class="main-image" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" alt="'.$item_title.'" />';
					$items .= '</a>';
				}
				
				if ($item_subtitle == "") {
				$items .= '<div class="item-info">';
				$items .= '<span class="item-title"><a href="'.$permalink.'">'.$item_title.'</a></span>';
				$items .= '</div>';
				} else {
				$items .= '<div class="item-info has-subtitle">';
				$items .= '<span class="item-title"><a href="'.$permalink.'">'.$item_title.'</a></span>';
				$items .= '<span><a href="'.$permalink.'">'.$item_subtitle.'</a></span>';
				$items .= '</div>';
				}
				
				$items .= '</li>';
			
			endwhile;
			
			wp_reset_query();
			
			$items .= '</ul></div>';
        	
        	$width = spb_translateColumnWidthToSpan($width);
    		$el_class = $this->getExtraClass($el_class);
            
            $sidebar_config = get_post_meta(get_the_ID(), 'ct_sidebar_config', true);
            
            $sidebars = '';
            if (($sidebar_config == "left-sidebar") || ($sidebar_config == "right-sidebar")) {
            $sidebars = 'one-sidebar';
            } else if ($sidebar_config == "both-sidebars") {
            $sidebars = 'both-sidebars';
            } else {
            $sidebars = 'no-sidebars';
            }
            
            if ($alt_background == "none" || $sidebars != "no-sidebars") {
            $output .= "\n\t".'<div class="spb_portfolio_showcase_widget spb_content_element no-bg '.$width.$el_class.'">';
            } else {
            $output .= "\n\t".'<div class="spb_portfolio_showcase_widget spb_content_element alt-bg '.$alt_background.' '.$width.$el_class.'">';
            }     
                        
            $output .= "\n\t\t".'<div class="spb_wrapper">';
            if ($title != '') {
            $output .= "\n\t\t\t".'<div class="heading-wrap"><h3 class="spb-heading spb-center-heading"><span>'.$title.'</span></h3></div>';
            }
            $output .= "\n\t\t\t\t".$items;
            $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
            $output .= "\n\t".'</div> '.$this->endBlockComment($width);
    
            $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
            
            global $ct_has_portfolio_showcase;
            $ct_has_portfolio_showcase = true;
            
            return $output;
		
    }
}

SPBMap::map( 'portfolio_showcase', array(
    "name"		=> __("Portfolio Showcase", "coo-page-builder"),
    "base"		=> "portfolio_showcase",
    "class"		=> "spb_portfolio_showcase spb_showcase",
    "icon"      => "spb-icon-portfolio-showcase",
    "params"	=> array(
	    array(
	        "type" => "textfield",
	        "heading" => __("Widget title", "coo-page-builder"),
	        "param_name" => "title",
	        "value" => "",
	        "description" => __("Heading text. Leave it empty if not needed.", "coo-page-builder")
	    ),
        array(
            "type" => "select-multiple",
            "heading" => __("Portfolio category", "coo-page-builder"),
            "param_name" => "category",
            "value" => ct_get_category_list('portfolio-category'),
            "description" => __("Choose the category for the portfolio items.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Number of items", "coo-page-builder"),
            "param_name" => "item_count",
            "value" => array(__('4', "coo-page-builder") => "4", __('5', "coo-page-builder") => "5"),
            "description" => __("Choose the display type for the asset.", "coo-page-builder")
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
        )
    )
) );

?>