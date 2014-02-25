<?php

	/*
	*
	*	Coo Page Builder - Post Format Output Functions
	*	------------------------------------------------
	*	Cootheme
	* 	http://www.cootheme.com
	*
	*	ct_get_post_media()
	*	ct_get_post_format_image_src()
	*	ct_image_post()
	*	ct_video_post()
	*	ct_gallery_post()
	*	ct_audio_post()
	*	ct_link_post()
	*	ct_chat_post()
	*	ct_get_post_item()
	*	ct_get_search_item()
	*
	*/
	
	
	/* MAIN GET MEDIA FUNCTION
	================================================== */
	if (!function_exists('ct_get_post_media')) {
		function ct_get_post_media($postID, $media_width, $media_height, $video_height, $use_thumb_content) {
			
			$format = get_post_format($postID);
			$post_media = "";
			
			if ($format == "image") {
				$post_media = ct_image_post($postID, $media_width, $media_height, $use_thumb_content);
			} else if ($format == "video") {
				$post_media = ct_video_post($postID, $media_width, $video_height, $use_thumb_content);
			} else if ($format == "gallery") {
				$post_media = ct_gallery_post($postID, $use_thumb_content);
			} else if ($format == "audio") {
				$post_media = ct_audio_post($postID);
			} else if ($format == "link") {
				$post_media = ct_link_post($postID);
			} else if ($format == "chat") {
				$post_media = ct_chat_post($postID);
			}
			
			return $post_media;
		
		}
	}
	
	
	/* GET IMAGE MEDIA
	================================================== */
	if (!function_exists('ct_get_post_format_image_src')) {
		function ct_get_post_format_image_src($post_id){
		    $format_meta = get_post_format_meta($post_id);
		    $match = array();
		    if ($format_meta['image'] != "") {
		    preg_match('/<img.*?src="([^"]+)"/s', $format_meta['image'], $match);
		    return $match[1];
		    }
		}
	}
	
	if (!function_exists('ct_image_post')) {
		function ct_image_post($postID, $media_width, $media_height, $use_thumb_content) {
		
			$image = $media_image_url = "";
			
			if ($use_thumb_content) {
			$media_image = rwmb_meta('ct_thumbnail_image', 'type=image&size=full', $postID);
			} else {
			$media_image = rwmb_meta('ct_detail_image', 'type=image&size=full', $postID);
			}
					
			foreach ($media_image as $detail_image) {
				$media_image_url = $detail_image['url'];
				break;
			}
											
			if (!$media_image) {
				$media_image = get_post_thumbnail_id();
				$media_image_url = wp_get_attachment_url( $media_image, 'full' );
			}
			
			if ($media_image_url == "") {
				$media_image_url = "default";
			}
			
			$detail_image = aq_resize( $media_image_url, $media_width, $media_height, true, false);
			
			
			$image_title = ct_featured_img_title();
			
			if ($detail_image) {
				$image = '<img itemprop="image" src="'.$detail_image[0].'" width="'.$detail_image[1].'" height="'.$detail_image[2].'" alt="'.$image_title.'" />';
			}
			
			return $image;
		}
	}
	
	
	/* GET VIDEO MEDIA
	================================================== */ 
	if (!function_exists('ct_video_post')) {
		function ct_video_post($postID, $media_width, $video_height, $use_thumb_content) {
			
			$video = $media_video = "";
						
			if ($use_thumb_content) {
			$media_video = get_post_meta($postID, 'ct_thumbnail_video_url', true);
			} else {
			$media_video = get_post_meta($postID, 'ct_detail_video_url', true);
			}
			
			$video = ct_video_embed($media_video, $media_width, $video_height);
			
			return $video;
		}
	}
	
	
	/* GET GALLERY MEDIA
	================================================== */ 
	if (!function_exists('ct_gallery_post')) {
		function ct_gallery_post($postID, $use_thumb_content) {
			
			$gallery = '<div class="flexslider item-slider">'."\n";
			$gallery .= '<ul class="slides">'."\n";
				
			if ($use_thumb_content) {
			$media_gallery = rwmb_meta('ct_thumbnail_gallery', 'type=image&size=full-width-image-gallery', $postID);
			} else {
			$media_gallery = rwmb_meta( 'ct_detail_gallery', 'type=image&size=full-width-image-gallery', $postID);
			}
						
			foreach ( $media_gallery as $image ) {
				$gallery .= "<li><img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$image['alt']}' /></li>";
			}
																	
			$gallery .= '</ul>'."\n";
			$gallery .= '</div>'."\n";
			
			return $gallery;
		}
	}
	
	
	/* GET AUDIO MEDIA
	================================================== */ 
	if (!function_exists('ct_audio_post')) {
		function ct_audio_post($postID) {
			$audio = "";
			if (function_exists('get_the_post_format_media')) {
				$audio = do_shortcode(get_the_post_format_media( 'audio', $null, 1 ));
			}			
			return $audio;
		}
	}
	
	
	/* GET LINK MEDIA
	================================================== */ 
	if (!function_exists('ct_link_post')) {
		function ct_link_post($postID) {
			
			$link = "";
			
			if (function_exists('get_the_post_format_url')) {
				$link = get_the_post_format_url();
				$link = '<a href="'.esc_url($link).'" target="_blank" class="link-post-link"><i class="ss-link"></i>'.$link.'</a>';
			}
			
			return $link;
		}
	}


	/* GET CHAT MEDIA
	================================================== */ 
	if (!function_exists('ct_chat_post')) {
		function ct_chat_post($postID) {
			
			$chat = "";
			
			if (function_exists('get_the_post_format_chat')) {
	
				$chat  = '<dl class="chat">';
				$stanzas = get_the_post_format_chat();
			
				foreach ( $stanzas as $stanza ) {
					foreach ( $stanza as $row ) {
						$time = '';
						if ( ! empty( $row['time'] ) )
							$time = sprintf( '<time class="chat-timestamp">%s</time>', esc_html( $row['time'] ) );
			
						$chat .= sprintf(
							'<dt class="chat-author chat-author-%1$s vcard">%2$s <cite class="fn">%3$s</cite>: </dt>
								<dd class="chat-text">%4$s</dd>
							',
							esc_attr( sanitize_title_with_dashes( $row['author'] ) ), // Slug.
							$time,
							esc_html( $row['author'] ),
							$row['message']
						);
					}
				}
			
				$chat .= '</dl><!-- .chat -->';
			
			}
			
			return $chat;
		}
	}	
	
	/* GET POST ITEM
	================================================== */ 
	if (!function_exists('ct_get_post_item')) {
		function ct_get_post_item($postID, $blog_type, $show_title = "yes", $show_excerpt = "yes", $show_details = "yes", $excerpt_length = "20", $content_output = "excerpt", $show_read_more = "no") {
		
			$post_item = "";
								
			global $ct_sidebar_config;
			$post_format = get_post_format($postID);
			if ( $post_format == "" ) {
				$post_format = 'standard';
			}
			$post_title = get_the_title();
			$post_author = get_the_author_link();
			$post_date = get_the_date();
			$post_categories = get_the_category_list(', ');
			$post_comments = get_comments_number();
			$post_permalink = get_permalink();
			$custom_excerpt = get_post_meta($postID, 'ct_custom_excerpt', true);
			$post_excerpt = '';
			if ($content_output == "excerpt") {
				if ($custom_excerpt != '') {
				$post_excerpt = ct_custom_excerpt($custom_excerpt, $excerpt_length);
				} else {
				if ($post_format == "quote") {
				$post_excerpt = ct_get_the_content_with_formatting();
				} else {
				$post_excerpt = ct_excerpt($excerpt_length);
				}
				}
			} else {
				$post_excerpt = ct_get_the_content_with_formatting();
			}
			if ($post_format == "chat") {
			$post_excerpt = ct_content(40);
			} else if ($post_format == "audio") {
			$post_excerpt = do_shortcode(get_the_content());
			} else if ($post_format == "video") {
			$content = get_the_content();
			$content = apply_filters('the_content', $content);
			$post_excerpt = $content;
			} else if ($post_format == "link") {
			$content = get_the_content();
			$content = apply_filters('the_content', $content);
			$post_excerpt = $content;
			}
			
			
			$post_item = $thumb_image = $thumb_width = $thumb_height = $bordered_thumb_width = $bordered_thumb_height = $video = $video_height = $bordered_video_height = $item_class = $link_config = $item_icon = $gallery_size = '';
				
			if ($blog_type == "mini") {
				if ($ct_sidebar_config == "no-sidebars") {
				$thumb_width = 446;
				$thumb_height = NULL;
				$video_height = 335;
				} else {
				$thumb_width = 370;
				$thumb_height = NULL;
				$video_height = 260;
				}
				$gallery_size = 'thumb-image';
			} else if ($blog_type == "masonry") {
				if ($ct_sidebar_config == "both-sidebars") {
				$item_class = "col-sm-3";
				} else {
				$item_class = "col-sm-4";
				}
				$thumb_width = 480;
				$thumb_height = NULL;
				$video_height = 360;
				$gallery_size = 'thumb-image';
			} else {
				$thumb_width = 970;
				$thumb_height = NULL;
				$video_height = 728;
				$gallery_size = 'blog-image';
			}
			
			
			$thumb_type = get_post_meta($postID, 'ct_thumbnail_type', true);
			$thumb_image = rwmb_meta('ct_thumbnail_image', 'type=image&size=full');
			$thumb_video = get_post_meta($postID, 'ct_thumbnail_video_url', true);
			$thumb_gallery = rwmb_meta( 'ct_thumbnail_gallery', 'type=image&size='.$gallery_size);
			$thumb_link_type = get_post_meta($postID, 'ct_thumbnail_link_type', true);
			$thumb_link_url = get_post_meta($postID, 'ct_thumbnail_link_url', true);
			$thumb_lightbox_thumb = rwmb_meta( 'ct_thumbnail_image', 'type=image&size=large' );
			$thumb_lightbox_image = rwmb_meta( 'ct_thumbnail_link_image', 'type=image&size=large' );
			$thumb_lightbox_video_url = get_post_meta($postID, 'ct_thumbnail_link_video_url', true);
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
			
			$item_figure = $link_config = "";
			
			// LINK TYPE VARIABLES			
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
			
			// THUMBNAIL MEDIA TYPE SETUP
			
			if ($thumb_type != "none") {
			
			$item_figure .= '<figure class="animated-overlay overlay-alt">';
							
			if ($thumb_type == "video") {
				
				$video = ct_video_embed($thumb_video, $thumb_width, $video_height);
				
				$item_figure .= $video;
				
			} else if ($thumb_type == "slider") {
				
				$item_figure .= '<div class="flexslider thumb-slider"><ul class="slides">';
							
				foreach ( $thumb_gallery as $image )
				{
				    $item_figure .= "<li><a ".$link_config."><img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$image['alt']}' /></a></li>";
				}
																
				$item_figure .= '</ul></div>';
				
			} else {
				
				if ($thumb_type == "image" && $thumb_img_url == "") {
					$thumb_img_url = "default";
				}
				
				$image = aq_resize( $thumb_img_url, $thumb_width, $thumb_height, true, false);
				$image_title = ct_featured_img_title();
				
				if ($image) {
					$item_figure .= '<img itemprop="image" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" alt="'.$image_title.'" />';
					$item_figure .= '<a '.$link_config.'></a>';
					$item_figure .= '<figcaption><div class="thumb-info thumb-info-alt">';
					$item_figure .= '<i class="'.$item_icon.'"></i>';
					$item_figure .= '</div></figcaption>';		
				}
			}
			
			$item_figure .= '</figure>';
			
			}
				
			// MASONRY STYLING				
			if ($blog_type == "masonry") {
				
				$post_item .= '<div class="masonry-item-wrap">';
				
				if ($post_format == "quote") {
					$post_item .= '<div class="quote-excerpt heading-font" itemprop="description">'. $post_excerpt .'</div>';
				} else if ($post_format == "link") {
					$post_item .= '<div class="link-excerpt heading-font" itemprop="description">'. $post_excerpt .'</div>';	
				} else {
					$post_item .= $item_figure;
				}
				
				$post_item .= '<div class="details-wrap clearfix">';
				
				if ($show_title == "yes" && $post_format != "quote" && $post_format != "link") {
					$post_item .= '<h4 itemprop="name headline"><a href="'.$post_permalink.'">'.$post_title.'</a></h4>'; 				
				}
				
				if ($show_details == "yes" && $post_format != "quote" && $post_format != "link") {
					$post_item .= '<div class="blog-item-details">'. sprintf(__('By <a href="%2$s">%1$s</a> on %3$s', 'cootheme'), $post_author, get_author_posts_url(get_the_author_meta( 'ID' )), $post_date) .'</div>';
				}
				
				// POST EXCERPT
				if ($show_excerpt == "yes" && $post_excerpt != "0") {					
					if ($post_format != "quote" && $post_format != "link") {
						$post_item .= '<div class="excerpt" itemprop="description">'. $post_excerpt .'</div>';
					}
				}
					
				// POST DETAILS 
				
				if (is_sticky()) {
					$post_item .= '<div class="sticky-post-icon"><i class="ss-bookmark"></i></div>';
				}
				
				if ($show_read_more == "yes") {
					$post_item .= '<a class="read-more-button" href="'.$post_permalink.'">'.__("Read more", "cootheme").'</a>';
				}
				
				if ($show_details == "yes") {
	
					$post_item .= '<div class="comments-likes">';
					
					if ( comments_open() ) {
						$post_item .= '<div class="comments-wrapper"><a href="'.$post_permalink.'#comment-area"><i class="ss-chat"></i><span>'. $post_comments .'</span></a></div>';
					}
					
					if (function_exists( 'lip_love_it_link' )) {
						$post_item .= lip_love_it_link(get_the_ID(), '<i class="ss-heart"></i>', '<i class="ss-heart"></i>', false);
					}
					
					$post_item .= '</div>';
				}
				
				$post_item .= '</div>';
							
				$post_item .= '</div>';
				
			// MINI STYLING
			} else if ($blog_type == "mini") {
			
				$post_item .= '<div class="mini-blog-item-wrap">';
				
				if ($post_format == "quote" || $post_format == "link") {
				
				$post_item .= '<div class="mini-alt-wrap">';
				
				} else {
				
				$post_item .= $item_figure;
			
				}
				
				$post_item .= '<div class="blog-details-wrap">';
				
				if ($show_title == "yes" && $post_format != "quote" && $post_format != "link") {
					$post_item .= '<h3 itemprop="name headline"><a href="'.$post_permalink.'">'. $post_title .'</a></h3>';
				}
				
				if ($show_details == "yes" && $post_format != "quote" && $post_format != "link") {
				$post_item .= '<div class="blog-item-details">'. sprintf(__('By <a href="%2$s">%1$s</a> on %3$s', 'cootheme'), $post_author, get_author_posts_url(get_the_author_meta( 'ID' )), $post_date) .'</div>';
				
				}
				if ($show_excerpt == "yes") {
					if ($post_format == "quote") {
						$post_item .= '<div class="quote-excerpt heading-font" itemprop="description">'. $post_excerpt .'</div>';
					} else if ($post_format == "link") {
						$post_item .= '<div class="link-excerpt heading-font" itemprop="description"><i class="ss-link"></i>'. $post_excerpt .'</div>';
					} else {
						$post_item .= '<div class="excerpt" itemprop="description">'. $post_excerpt .'</div>';
					}
				}
				
				if (is_sticky()) {
					$post_item .= '<div class="sticky-post-icon"><i class="ss-bookmark"></i></div>';
				}
				
				if ($show_read_more == "yes") {
					$post_item .= '<a class="read-more-button" href="'.$post_permalink.'">'.__("Read more", "cootheme").'</a>';
				}
				
				if ($show_details == "yes") {
	
					$post_item .= '<div class="comments-likes">';
					
					if ($post_format == "quote" || $post_format == "link") {
					$post_item .= '<div class="blog-item-details">'. sprintf(__('By <a href="%2$s">%1$s</a> on %3$s', 'cootheme'), $post_author, get_author_posts_url(get_the_author_meta( 'ID' )), $post_date) .'</div>';
					}
					
					if ( comments_open() ) {
						$post_item .= '<div class="comments-wrapper"><a href="'.$post_permalink.'#comment-area"><i class="ss-chat"></i><span>'. $post_comments .'</span></a></div>';
					}
					
					if (function_exists( 'lip_love_it_link' )) {
						$post_item .= lip_love_it_link(get_the_ID(), '<i class="ss-heart"></i>', '<i class="ss-heart"></i>', false);
					}
					
					$post_item .= '</div>';
				}
				
				$post_item .= '</div>';
				
				if ($post_format == "quote" || $post_format == "link") {
				
					$post_item .= '</div>';
				
				}
				
				$post_item .= '</div>';
				
			
			// STANDARD STYLING
			} else {
										
				if ($show_details == "yes") {
					$post_item .= '<span class="standard-post-date" itemprop="datePublished">'.$post_date.'</span>';
				}
											
				$post_item .= $item_figure;
				
				if ($item_figure == "") {
				$post_item .= '<div class="standard-post-content no-thumb clearfix">'; // open standard-post-content
				} else {
				$post_item .= '<div class="standard-post-content clearfix">'; // open standard-post-content				
				}
				
				if ($show_title && $post_format != "link" && $post_format != "quote") {
					$post_item .= '<h1 itemprop="name headline"><a href="'.$post_permalink.'">'. $post_title .'</a></h1>';
				}
				
				if ($show_details == "yes" && $post_format != "quote" && $post_format != "link") {
				$post_item .= '<div class="blog-item-details">'. sprintf(__('By <a href="%2$s">%1$s</a>', 'cootheme'), $post_author, get_author_posts_url(get_the_author_meta( 'ID' ))) .'</div>';
				}
				
				if ($show_excerpt == "yes") {					
					if ($post_format == "quote") {
						$post_item .= '<div class="quote-excerpt heading-font" itemprop="description">'. $post_excerpt .'</div>';
					} else if ($post_format == "link") {
						$post_item .= '<div class="link-excerpt heading-font" itemprop="description"><i class="ss-link"></i>'. $post_excerpt .'</div>';
					} else {
						$post_item .= '<div class="excerpt" itemprop="description">'. $post_excerpt .'</div>';
					}
				}
				
				if (is_sticky()) {
					$post_item .= '<div class="sticky-post-icon"><i class="ss-bookmark"></i></div>';
				}
				
				if ($show_read_more == "yes") {
				$post_item .= '<a class="read-more-button" href="'.$post_permalink.'">'.__("Read more", "cootheme").'</a>';
				}
				
				if ($show_details == "yes") {
	
					$post_item .= '<div class="comments-likes">';
					
					if ($post_format == "quote" || $post_format == "link") {
					$post_item .= '<div class="blog-item-details">'. sprintf(__('By <a href="%2$s">%1$s</a> on %3$s', 'cootheme'), $post_author, get_author_posts_url(get_the_author_meta( 'ID' )), $post_date) .'</div>';
					}
					
					if ( comments_open() ) {
						$post_item .= '<div class="comments-wrapper"><a href="'.$post_permalink.'#comment-area"><i class="ss-chat"></i><span>'. $post_comments .'</span></a></div>';
					}
					
					if (function_exists( 'lip_love_it_link' )) {
						$post_item .= lip_love_it_link(get_the_ID(), '<i class="ss-heart"></i>', '<i class="ss-heart"></i>', false);
					}
					
					$post_item .= '</div>';
				}
			
				$post_item .= '</div>'; // close standard-post-content
										
			}		
			
			return $post_item;
		}
	}
	
	
	/* GET SEARCH ITEM
	================================================== */ 
	if (!function_exists('ct_get_search_item')) {
		function ct_get_search_item($postID) {
			
			$search_item = $thumb_img_url = $post_excerpt = $img_icon = "";
			
			$post_format = get_post_format($postID);
			if ( $post_format == "" ) {
				$post_format = 'standard';
			}
			$post_type = get_post_type($postID);
			
			if ($post_type == "post") {
				if ($post_format == "quote" || $post_format == "status") {
					$img_icon = "ss-quote";
				} else if ($post_format == "image") {
					$img_icon = "ss-picture";
				} else if ($post_format == "chat") {
					$img_icon = "ss-chat";
				} else if ($post_format == "audio") {
					$img_icon = "ss-music";
				} else if ($post_format == "video") {
					$img_icon = "ss-video";
				} else if ($post_format == "link") {
					$img_icon = "ss-link";
				} else {
					$img_icon = "ss-pen";
				}
			} else if ($post_type == "product") {
				$img_icon = "ss-cart";
			} else if ($post_type == "portfolio") {
				$img_icon = "ss-picture";
			} else if ($post_type == "team") {
				$img_icon = "ss-user";
			} else if ($post_type == "galleries") {
				$img_icon = "ss-picture";
			} else {
				$img_icon = "ss-file";
			}
			
			$post_title = get_the_title();
			$post_date = get_the_date();
			$post_permalink = get_permalink();
			$custom_excerpt = get_post_meta($postID, 'ct_custom_excerpt', true);
			$post_excerpt = strip_shortcodes(get_the_excerpt());
			
			$thumb_image = rwmb_meta('ct_thumbnail_image', 'type=image&size=thumbnail');
			
			foreach ($thumb_image as $detail_image) {
				$thumb_img_url = $detail_image['url'];
				break;
			}
											
			if (!$thumb_image) {
				$thumb_image = get_post_thumbnail_id();
				$thumb_img_url = wp_get_attachment_url( $thumb_image, 'thumbnail' );
			}
			
			$image = aq_resize( $thumb_img_url, 70, 70, true, false);
			$image_title = ct_featured_img_title();
			
			if ($image) {
				$search_item .= '<div class="search-item-img"><a href="'.$post_permalink.'"><img itemprop="image" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" alt="'.$image_title.'" /></a></div>';
			} else {
				$search_item .= '<div class="search-item-img"><a href="'.$post_permalink.'" class="img-holder"><i class="'.$img_icon.'"></i></a></div>';
			}
			
			if ($post_excerpt == "<p></p>") {
			$search_item .= '<div class="search-item-content no-excerpt">';		
			$search_item .= '<h3><a href="'.$post_permalink.'">'.$post_title.'</a></h3>';
			$search_item .= '<time>'.$post_date.'</time>';
			$search_item .= '</div>';
			} else {
			$search_item .= '<div class="search-item-content">';		
			$search_item .= '<h3><a href="'.$post_permalink.'">'.$post_title.'</a></h3>';
			$search_item .= '<time>'.$post_date.'</time>';
			$search_item .= '<div class="excerpt">'.$post_excerpt.'</div>';
			$search_item .= '</div>';		
			}
			
			return $search_item;
			
		}
	}
?>