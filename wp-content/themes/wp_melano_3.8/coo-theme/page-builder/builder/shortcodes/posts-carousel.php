<?php

class CooPageBuilderShortcode_posts_carousel extends CooPageBuilderShortcode {

    protected function content($atts, $content = null) {
    
    		$options = get_option('ct_coo_options');

		    $title = $category = $item_class = $excerpt_length = $width = $offset = $el_class = $output = $filter = $items = $el_position = $item_count = '';
		
	        extract(shortcode_atts(array(
		        'title' => '',
	        	'show_title'	=> 'yes',
	        	'show_excerpt'	=> 'yes',
	        	"excerpt_length" => '20',
	        	"item_count"	=> '12',
	        	"show_details"	    => 'yes',
	        	"offset"		=> '0',
	        	"category"		=> 'all',
	        	'el_position' => '',
	        	'width' => '1/1',
	        	'el_class' => ''
	        ), $atts));
	        
	        // CATEGORY SLUG MODIFICATION
	        if ($category == "All") {$category = "all";}
	        if ($category == "all") {$category = '';}
	        $category_slug = str_replace('_', '-', $category);
		    
    		global $post, $wp_query, $ct_carouselID;
    		
    		if ($ct_carouselID == "") {
    		$ct_carouselID = 1;
    		} else {
    		$ct_carouselID++;
    		}
    		
    		$blog_args = array(
    			'post_type' => 'post',
    			'post_status' => 'publish',
    			'no_found_rows' => 1,
    			'category_name' => $category_slug,
    			'posts_per_page' => $item_count,
    			'offset' => $offset
    			);
    			    		
    		$blog_items = new WP_Query( $blog_args );
    		
    		$count = $columns = 0;
    		    		
    		$sidebar_config = get_post_meta(get_the_ID(), 'ct_sidebar_config', true);
    		
    		if (is_singular('portfolio')) {
    		$sidebar_config = "no-sidebars";
    		}
    		
    		if (($sidebar_config == "left-sidebar") || ($sidebar_config == "right-sidebar")) {
    		$item_class = 'span2';
    		} else if ($sidebar_config == "both-sidebars") {
    		$item_class = 'span-bs-quarter';
    		} else {
    		$item_class = 'span3';
    		}
    		
    		if ($width == "1/4") {
    		$columns = 1;
    		} else if ($width == "1/2") {
    		$columns = 2;
    		} else if ($width == "3/4") {
    		$columns = 3;
    		} else {
    		$columns = 4;
    		}
    				
			$items .= '<div class="carousel-overflow"><ul id="carousel-'.$ct_carouselID.'" class="blog-items carousel-items clearfix" data-columns="'.$columns.'" data-auto="false">';
	
			while ( $blog_items->have_posts() ) : $blog_items->the_post();
								
				$item_title = get_the_title();
				$post_author = get_the_author_link();
				$post_date = get_the_date('M j Y');
				$post_comments = get_comments_number();
				$post_category = get_the_category();
				
				$thumb_type = get_post_meta($post->ID, 'ct_thumbnail_type', true);
				$thumb_image = rwmb_meta('ct_thumbnail_image', 'type=image&size=full');
				$thumb_video = get_post_meta($post->ID, 'ct_thumbnail_video_url', true);
				$thumb_gallery = rwmb_meta( 'ct_thumbnail_gallery', 'type=image&size=thumb-image' );
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
												
				if (!$thumb_image) {
					$thumb_image = get_post_thumbnail_id();
					$thumb_img_url = wp_get_attachment_url( $thumb_image, 'full' );
				}
					
				$thumb_lightbox_img_url = wp_get_attachment_url( $thumb_lightbox_image, 'full' );
				
				$item_title = get_the_title();
				$post_permalink = get_permalink();
				$custom_excerpt = get_post_meta($post->ID, 'ct_custom_excerpt', true);
				$post_excerpt = '';
				if ($custom_excerpt != '') {
				$post_excerpt = ct_custom_excerpt($custom_excerpt, $excerpt_length);
				} else {
				$post_excerpt = ct_excerpt($excerpt_length);
				}
				
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
					$link_config = 'href="'.$post_permalink.'" class="link-to-post"';
					$item_icon = "ss-navigateright";
				}
				 				   	
				$items .= '<li itemscope data-id="id-'. $count .'" class="clearfix carousel-item recent-post '.$item_class.'">';
				
				$items .= '<figure class="animated-overlay overlay-alt">';
						
				// THUMBNAIL MEDIA TYPE SETUP
				
				if ($thumb_type == "video") {
					
						$video = ct_video_embed($thumb_video, 270, 202);
					
					$items .= $video;
					
				} else if ($thumb_type == "slider") {
					
					$items .= '<div class="flexslider thumb-slider"><ul class="slides">';
								
					foreach ( $thumb_gallery as $image )
					{
						$alt = $image['alt'];
						if (!$alt) {
						$alt = $image['title'];
						}
					    $items .= "<li><a ".$link_config."><img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$alt}' /></a></li>";
					}
																	
					$items .= '</ul></div>';
					
				} else {
					
					if ($thumb_img_url == "") {
						$thumb_img_url = "default";
					}
				
					$image = aq_resize( $thumb_img_url, 420, 315, true, false);
						
					if ($image) {
						$items .= '<img itemprop="image" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" alt="'.$item_title.'" />';
						
						$items .= '<a '.$link_config.'></a>';

						if ($show_title == "yes") {
							$items .= '<figcaption><div class="thumb-info thumb-info-alt">';
							$items .= '<i class="'.$item_icon.'"></i>';
							$items .= '</div></figcaption>';
						} else {
							$items .= '<figcaption><div class="thumb-info">';
							$items .= '<h4>'.$item_title.'</h4>';
							$items .= '<i class="'.$item_icon.'"></i>';
							$items .= '</div></figcaption>';
						}
					}

				}
								
				$items .= '</figure>';
				
				$items .= '<div class="details-wrap row">';

                $items .= '<div class="col-md-3 col-sm-3">';

                if($thumb_type == "image"){
                    $items .= '<div class="icon-post-type"><i class="fa-camera"></i></div>';
                }elseif($thumb_type == "video"){
                    $items .= '<div class="icon-post-type"><i class="fa-video-camera"></i></div>';
                }elseif($thumb_type == "slider"){
                    $items .= '<div class="icon-post-type"><i class="fa-crosshairs"></i></div>';
                }
                else{
                    $items .= '<div class="icon-post-type"><i class="fa-unlink"></i></div>';
                }
				
                // Post Date
				if ($show_details == "yes") {
					$items .= '<div class="post-details">'.$post_date.'</div>';
				}

                $items .= '</div>';
                $items .= '<div class="col-md-9 col-sm-9 pl0">';

                // POST TITLE
                if ($show_title == "yes") {
                    $items .= '<h5><a href="'.$post_permalink.'">'.$item_title.'</a></h5>';
                }

				// POST EXCERPT
				if ($excerpt_length != "0" && $show_excerpt == "yes") {
					$items .= '<div class="excerpt">'. $post_excerpt .'</div>';
				}
				
				$items .= '</div>';
				$items .= '</div>';
				$items .= '</li>';
				
				$count++;
			
			endwhile;
			
			wp_reset_query();
			wp_reset_postdata();
					
			$items .= '</ul>';
			
			$items .= '<a href="#" class="prev"><i class="ss-navigateleft"></i></a><a href="#" class="next"><i class="ss-navigateright"></i></a>';
			
			$options = get_option('ct_coo_options');
			if ($options['enable_swipe_indicators']) {
			$items .= '<div class="ct-swipe-indicator"></div>';
			}
			
			$items .= '</div>';
    		
			$width = spb_translateColumnWidthToSpan($width);
			$el_class = $this->getExtraClass($el_class);
    		
    		$output .= "\n\t".'<div class="spb_posts_carousel_widget spb_content_element '.$width.$el_class.'">';
            $output .= "\n\t\t".'<div class="spb_wrapper carousel-wrap alt-nav">';
            if ($title != '') {
            	if ($width == "col-sm-12") {
            		$output .= "\n\t\t\t".'<div class="heading-wrap"><h3 class="spb-heading spb-center-heading"><span>'.$title.'</span></h3></div>';
            	} else {
            		$output .= "\n\t\t\t".'<div class="heading-wrap"><h3 class="spb-heading"><span>'.$title.'</span></h3></div>';
            		            	
            	}
            }
            $output .= "\n\t\t\t\t".$items;
            $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
            $output .= "\n\t".'</div> '.$this->endBlockComment($width);
    
            $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
            
            global $ct_include_carousel, $ct_include_isotope;
            $ct_include_carousel = true;
            $ct_include_isotope = true;
            
            return $output;
		
    }
}

SPBMap::map( 'posts_carousel', array(
    "name"		=> __("Posts Carousel", "coo-page-builder"),
    "base"		=> "posts_carousel",
    "class"		=> "spb_posts_carousel spb_carousel",
    "icon"      => "spb-icon-posts-carousel",
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
            "value" => "12",
            "description" => __("The number of blog items to show in the carousel.", "coo-page-builder")
        ),
        array(
            "type" => "select-multiple",
            "heading" => __("Posts category", "coo-page-builder"),
            "param_name" => "category",
            "value" => ct_get_category_list('category'),
            "description" => __("Choose the category for the blog items.", "coo-page-builder")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Posts offset", "coo-page-builder"),
            "param_name" => "offset",
            "value" => "0",
            "description" => __("The offset for the start of the posts that are displayed, e.g. enter 5 here to start from the 5th post.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show title text", "coo-page-builder"),
            "param_name" => "show_title",
            "value" => array(__("Yes", "coo-page-builder") => "yes", __("No", "coo-page-builder") => "no"),
            "description" => __("Show the item title text.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show item excerpt", "coo-page-builder"),
            "param_name" => "show_excerpt",
            "value" => array(__("Yes", "coo-page-builder") => "yes", __("No", "coo-page-builder") => "no"),
            "description" => __("Show the item excerpt text.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show item details", "coo-page-builder"),
            "param_name" => "show_details",
            "value" => array(__("Yes", "coo-page-builder") => "yes", __("No", "coo-page-builder") => "no"),
            "description" => __("Show the item details.", "coo-page-builder")
        ),
        array(
            "type" => "textfield",
            "heading" => __("Excerpt Length", "coo-page-builder"),
            "param_name" => "excerpt_length",
            "value" => "20",
            "description" => __("The length of the excerpt for the posts.", "coo-page-builder")
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