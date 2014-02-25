<?php
	
	/*
	*
	*	Cootheme Media Functions
	*	------------------------------------------------
	*	Cootheme v2.0
	* 	http://www.cootheme.com
	*
	*	ct_return_slider()
	*	ct_video_embed()
	*	ct_video_youtube()
	*	ct_video_vimeo()
	*	ct_get_embed_src()
	*	ct_featured_img_title()
	*	ct_coo_slider()
	*
	*/

	
	/* REVSLIDER RETURN FUNCTION
	================================================== */
	function ct_return_slider($revslider_shortcode) {
	    ob_start();
	    putRevSlider($revslider_shortcode);
	    return ob_get_clean();
	}


	/* VIDEO EMBED FUNCTIONS
	================================================== */
	if (!function_exists('ct_video_embed')) {
		function ct_video_embed($url, $width = 640, $height = 480) {
			if (strpos($url,'youtube') || strpos($url,'youtu.be')){
				return ct_video_youtube($url, $width, $height);
			} else {
				return ct_video_vimeo($url, $width, $height);
			}
		}
	}
	
	if (!function_exists('ct_video_youtube')) {
		function ct_video_youtube($url, $width = 640, $height = 480) {
			preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $video_id);
			return '<iframe itemprop="video" src="http://www.youtube.com/embed/'. $video_id[1] .'?wmode=transparent" width="'. $width .'" height="'. $height .'" ></iframe>';
		}
	}
	
	if (!function_exists('ct_video_vimeo')) {
		function ct_video_vimeo($url, $width = 640, $height = 480) {
			preg_match('/http:\/\/vimeo.com\/(\d+)$/', $url, $video_id);		
			return '<iframe itemprop="video" src="http://player.vimeo.com/video/'. $video_id[1] .'?title=0&amp;byline=0&amp;portrait=0?wmode=transparent" width="'. $width .'" height="'. $height .'"></iframe>';
		}
	}
	
	if (!function_exists('ct_get_embed_src')) {
		function ct_get_embed_src($url) {
			if (strpos($url,'youtube')){
				preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $video_id);
				if (isset($video_id[1])) {
					return 'http://www.youtube.com/embed/'. $video_id[1] .'?autoplay=1&amp;wmode=transparent';
				}
			} else {
				preg_match('/http:\/\/vimeo.com\/(\d+)$/', $url, $video_id);
				if (isset($video_id[1])) {
					return 'http://player.vimeo.com/video/'. $video_id[1] .'?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=1&amp;wmode=transparent';
				}
			}
		}
	}	
		
	/* FEATURED IMAGE TITLE
	================================================== */
	function ct_featured_img_title() {
		global $post;
		$ct_thumbnail_id = get_post_thumbnail_id($post->ID);
		$ct_thumbnail_image = get_posts(array('p' => $ct_thumbnail_id, 'post_type' => 'attachment', 'post_status' => 'any'));
		if ($ct_thumbnail_image && isset($ct_thumbnail_image[0])) {
			return $ct_thumbnail_image[0]->post_title;
		}
	}
	
	
	/* COO SLIDER
	================================================== */
	if (!function_exists('ct_coo_slider')) {
		function ct_coo_slider() {
			
			global $post, $wp_query;
			
			$output = '';
			
			$options = get_option('ct_coo_options');
			$posts_slider_type = get_post_meta($post->ID, 'ct_posts_slider_type', true);
			$posts_category = get_post_meta($post->ID, 'ct_posts_slider_category', true);
			$portfolio_category = get_post_meta($post->ID, 'ct_posts_slider_portfolio_category', true);
			$count = get_post_meta($post->ID, 'ct_posts_slider_count', true);
			
			$args = array();
			
			if ($posts_slider_type == "post") {
				$slider_category = $posts_category;
				if ($slider_category == "All") {$slider_category = "all";}
				if ($slider_category == "all") {$slider_category = '';}
				$category_slug = str_replace('_', '-', $slider_category);
				$args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'category_name' => $category_slug,
					'posts_per_page' => $count
					);
			} else if ($posts_slider_type == "hybrid") {
				$args = array(
					'post_type' => array( 'post', 'portfolio'),
					'post_status' => 'publish',
					'posts_per_page' => $count
					);		
			} else {
				$slider_category = $portfolio_category;
				if ($slider_category == "All") {$slider_category = "all";}
				if ($slider_category == "all") {$slider_category = '';}
				$category_slug = str_replace('_', '-', $slider_category);
				$args = array(
					'post_type' => 'portfolio',
					'post_status' => 'publish',
					'portfolio-category' => $category_slug,
					'posts_per_page' => $count,
					'no_found_rows' => 1,
					);
			}
				
			$slider_items = new WP_Query( $args );
					
			if( $slider_items->have_posts() ) {
				
				$output .= '<!--// COO SLIDER //-->'. "\n";
				$output .= '<div id="coo-slider" class="flexslider">'. "\n";
				$output .= '<div class="coo-slider-loading"></div>'. "\n";
				$output .= '<ul class="slides">'. "\n";
						
				while ( $slider_items->have_posts() ) : $slider_items->the_post();
					
						$post_title = get_the_title();
					$post_permalink = get_permalink();
					$post_author = get_the_author_link();
					$post_date = get_the_date();
					$post_client = get_post_meta($post->ID, 'ct_portfolio_client', true);
					$post_categories = get_the_category_list(', ');
					if ($posts_slider_type == "portfolio") {
					$post_categories = get_the_term_list($post->ID, 'portfolio-category', '', ', ');
					}
					$post_comments = get_comments_number();
					$custom_excerpt = get_post_meta($post->ID, 'ct_custom_excerpt', true);
					$post_excerpt = '';
					if ($custom_excerpt != '') {
					$post_excerpt = ct_custom_excerpt($custom_excerpt, 20);
					} else {
					$post_excerpt = ct_excerpt(20);
					}
					$posts_slider_image = rwmb_meta('ct_posts_slider_image', 'type=image&size=full');
					$caption_position = get_post_meta($post->ID, 'ct_caption_position', true);
					
					$accent_color = get_option('accent_color', '#fb3c2d');
					$secondary_accent_color = get_option('secondary_accent_color', '#2e2e36');
					$secondary_accent_alt_color = get_option('secondary_accent_alt_color', '#ffffff');
					
					$media_image_url = "";
					
					foreach ($posts_slider_image as $detail_image) {
						$media_image_url = $detail_image['url'];
						break;
					}
													
					if (!$posts_slider_image) {
						$posts_slider_image = get_post_thumbnail_id();
						$media_image_url = wp_get_attachment_url( $posts_slider_image, 'full' );
					}
					
					
					if (!$caption_position) { $caption_position = "caption-right"; }
					
					$image = aq_resize( $media_image_url, 1920, NULL, true, false);
							  
					$output .= '<li>'. "\n";
					$output .= '<div class="slide-caption-container">'. "\n";
					if ($image) {
						$output .= '<div class="flex-caption '.$caption_position.'">'. "\n";
						$output .= '<div class="flex-caption-details">'. "\n";
						$output .= '<div class="caption-details-inner">'. "\n";
						$output .= '<div class="details clearfix">'. "\n";
						$output .= '<span class="date">'.$post_date.'</span>'. "\n";
						if ($post_client != "") {
						$output .= '<span class="item-client">'.__("Client: ", "cootheme").$post_client.'</span>'. "\n";
						$output .= '<span class="item-categories">'.$post_categories.'</span>'. "\n";
						} else {
						$output .= '<span class="item-author">'.__("Posted by ", "cootheme").$post_author.'</span>'. "\n";
						$output .= '<span class="item-categories">'.$post_categories.'</span>'. "\n";
						}
						$output .= '</div>';
						if ( comments_open() ) {
							$output .= '<div class="comment-chart chart" data-percent="1" data-count="'.$post_comments.'" data-barcolor="'.$secondary_accent_color.'"><span>0</span><i class="ss-chat"></i></div>'. "\n";
						}
						if (function_exists( 'lip_get_love_count' )) {
						$output .= '<div class="loveit-chart chart" data-percent="1" data-count="'.lip_get_love_count($post->ID).'" data-barcolor="'.$accent_color.'"><span>0</span><i class="ss-heart"></i></div>'. "\n";
						}
						$output .= '</div>'. "\n";
						$output .= '</div>'. "\n";
						$output .= '<div class="flex-caption-headline clearfix">'. "\n";
						$output .= '<h4><a href="'.$post_permalink.'"><span>'. $post_title .'</span><i class="ss-navigateright"></i></a></h4>'. "\n";
						$output .= '</div></div></div>'. "\n";
						$output .= '<img src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" alt="'.$post_title.'" />'. "\n";
					} else {
						$output .= '<div class="flex-caption-large clearfix">'. "\n";
						$output .= '<h1><a href="'.$post_permalink.'">'. $post_title .'</a></h1>'. "\n";
						$output .= '<div class="excerpt">'. $post_excerpt .'</div>'. "\n";
						$output .= '<div class="cl-charts">'. "\n";
						if ( comments_open() ) {
							$output .= '<div class="comment-chart fw-chart chart" data-percent="1" data-count="'.$post_comments.'" data-barcolor="'.$secondary_accent_alt_color.'"><span>0</span><i class="ss-chat"></i></div>'. "\n";
						}
						if (function_exists( 'lip_get_love_count' )) {
						$output .= '<div class="loveit-chart fw-chart chart" data-percent="1" data-count="'.lip_get_love_count($post->ID).'" data-barcolor="'.$accent_color.'"><span>0</span><i class="ss-heart"></i></div>'. "\n";
						}	
						$output .= '</div>'. "\n";
						$output .= '<div class="details clearfix">'. "\n";
						$output .= '<span class="date">'.$post_date.'</span>'. "\n";
						if ($post_client != "") {
						$output .= '<span class="item-client">'.__("Client: ", "cootheme").$post_client.'</span>'. "\n";
						$output .= '<span class="item-categories">'.$post_categories.'</span>'. "\n";
						} else {
						$output .= '<span class="item-author">'.__("Posted by ", "cootheme").$post_author.'</span>'. "\n";
						$output .= '<span class="item-categories">'.$post_categories.'</span>'. "\n";
						}
						$output .= '</div></div></div>'. "\n";
					}
					$output .= '</li>'. "\n";
									    						
				endwhile;
				
				wp_reset_postdata();
						
				$output .= '</ul></div>'. "\n";
			}
			
			echo $output;
		}
	}
?>