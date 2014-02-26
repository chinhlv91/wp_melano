<?php

	/*
	*
	*	Coo Page Builder - Portfolio Items Function Class
	*	------------------------------------------------
	*	Cootheme
	* 	http://www.cootheme.com
	*
	*	ct_portfolio_items()
	*	ct_portfolio_filter()
	*
	*/
	
	/* PORTFOLIO ITEMS
	================================================== */
	if (!function_exists('ct_portfolio_items')) {
		function ct_portfolio_items($display_type, $columns, $show_title, $show_subtitle, $show_excerpt, $show_it_love, $hover_show_excerpt, $excerpt_length, $item_count, $category, $exclude_categories, $pagination, $sidebars) {
			
			/* OUTPUT VARIABLE
			================================================== */ 
			$portfolio_items_output = "";
			$count = 0;
			
	        /* CATEGORY SLUG MODIFICATION
	        ================================================== */ 
	        if ($category == "All") {$category = "all";}
		    if ($category == "all") {$category = '';}
		    $category_slug = str_replace('_', '-', $category);
		    
		    
		    /* PORTFOLIO QUERY SETUP
		    ================================================== */ 
			global $post, $wp_query;
			
			if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
			} elseif ( get_query_var('page') ) {
			$paged = get_query_var('page');
			} else {
			$paged = 1;
			}
			    		
			$portfolio_args=array(
	    		'post_type' => 'portfolio',
	    		'post_status' => 'publish',
	    		'paged' => $paged,
	    		'portfolio-category' => $category_slug,
	    		'posts_per_page' => $item_count,
	    		'tax_query' => array(
	    				array(
	    					'taxonomy' => 'portfolio-category',
	    					'field' => 'id',
	    					'terms' => array( $exclude_categories ),
	    					'operator' => 'NOT IN'
	    				)
	    			)
	   		);
	   		    		
			$portfolio_items = new WP_Query( $portfolio_args );
			
			
			/* LIST CLASS CONFIG
			================================================== */ 
			$list_class = '';
			if ($display_type == "masonry" || $display_type == "masonry-gallery") {
			$list_class .= 'masonry-items filterable-items col-'.$columns.' row clearfix';
			} else if ($display_type == "gallery") {
			$list_class .= 'gallery-portfolio filterable-items col-'.$columns.' row clearfix';
			} else {
			$list_class .= 'standard-portfolio filterable-items col-'.$columns.' row clearfix';
			}
			
			
			/* ITEMS OUTPUT
			================================================== */
			$portfolio_items_output .= '<ul class="portfolio-items '.$list_class.'">'. "\n";
			
			while ( $portfolio_items->have_posts() ) : $portfolio_items->the_post();								
	
	
				/* META VARIABLES
				================================================== */
				$thumb_image = $thumb_gallery = $video = $item_class = $link_config = '';
				$thumb_width = 420;
				$thumb_height = 315;
				$video_height = 315;
	
				$thumb_type = get_post_meta($post->ID, 'ct_thumbnail_type', true);
				$thumb_image = rwmb_meta('ct_thumbnail_image', 'type=image&size=full');
				$thumb_video = get_post_meta($post->ID, 'ct_thumbnail_video_url', true);
				if ($columns == "2") {
				$thumb_gallery = rwmb_meta( 'ct_thumbnail_gallery', 'type=image&size=thumb-image-twocol' );
				} else {
				$thumb_gallery = rwmb_meta( 'ct_thumbnail_gallery', 'type=image&size=thumb-image' );
				}
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
				$item_subtitle = get_post_meta($post->ID, 'ct_portfolio_subtitle', true);
				$permalink = get_permalink();
				$custom_excerpt = get_post_meta($post->ID, 'ct_custom_excerpt', true);
				$post_excerpt = '';
				if ($custom_excerpt != '') {
				$post_excerpt = ct_custom_excerpt($custom_excerpt, $excerpt_length);
				} else {
				$post_excerpt = ct_excerpt($excerpt_length);
				}
								
				$post_terms = get_the_terms( $post->ID, 'portfolio-category' );
				$term_slug = " ";
				
				if(!empty($post_terms)){
					foreach($post_terms as $post_term){
						$term_slug = $term_slug . strtolower(str_replace(' ', '-', $post_term->name)) . ' ';
					}
				}
								
				
				/* COLUMN VARIABLE CONFIG
				================================================== */
				$item_class = $item_icon = "";
				    				    				
				if ($columns == "2") {
					if ($sidebars == "both-sidebars") {
					$item_class = "col-sm-3 ";
					} else if ($sidebars == "one-sidebar") {
					$item_class = "col-sm-4 ";
					} else {
					$item_class = "col-sm-6 ";
					$thumb_width = 800;
					$thumb_height = 600;
					$video_height = 600;
					}
				} else if ($columns == "3") {
					if ($sidebars == "both-sidebars") {
					$item_class = "col-sm-2 ";
					} else if ($sidebars == "one-sidebar") {
					$item_class = "span-third ";
					} else {
					$item_class = "col-sm-4 ";
					$thumb_width = 600;
					$thumb_height = 450;
					$video_height = 450;
					}
				} else if ($columns == "4") {
					if ($sidebars == "both-sidebars") {
					$item_class = "col-sm-3 ";
					} else if ($sidebars == "one-sidebar") {
					$item_class = "col-sm-2 ";
					} else {
					$item_class = "col-sm-3 ";
					}
				}
				
				if ($display_type == "masonry" || $display_type == "masonry-gallery") {
					$thumb_height = NULL;
				}
				
				
				/* DISPLAY TYPE CONFIG
				================================================== */
				if ($display_type == "masonry" || $display_type == "masonry-gallery") {
					$item_class .= "masonry-item masonry-gallery-item";
				} else if ($display_type == "gallery") {
					$item_class .= "gallery-item ";
				} else {
					$item_class .= "standard ";
				}
				
				
				/* LINK TYPE CONFIG
				================================================== */
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
				
				
				/* ITEM OUTPUT
				================================================== */
				$portfolio_items_output .= '<li itemscope itemtype="http://schema.org/CreativeWork" data-id="id-'. $count .'" class="clearfix portfolio-item '.$item_class.' '. $term_slug .'">'. "\n";		
				
														
				/* THUMBNAIL CONFIG
				================================================== */
				if ($thumb_type != "none") {
					
                        if ($display_type == "gallery" || $display_type == "masonry-gallery") {
					$portfolio_items_output .= '<figure class="animated-overlay">'. "\n";
					} else {
					$portfolio_items_output .= '<figure class="animated-overlay overlay-alt">'. "\n";				
					}
					
					if ($thumb_type == "video") {
						
						$video = ct_video_embed($thumb_video, $thumb_width, $video_height);
						$portfolio_items_output .= $video;
						
					} else if ($thumb_type == "slider") {
						
						$portfolio_items_output .= '<div class="flexslider thumb-slider"><ul class="slides">'. "\n";
									
						foreach ( $thumb_gallery as $image )
						{
						    $portfolio_items_output .= "<li><a ".$link_config."><img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$image['alt']}' /></a></li>". "\n";
						}
																		
						$portfolio_items_output .= '</ul></div>'. "\n";
						
					} else {
						
						if ($thumb_type == "image" && $thumb_img_url == "") {
							$thumb_img_url = "default";
						}
					
						$image = aq_resize( $thumb_img_url, $thumb_width, $thumb_height, true, false);
						
						if($image) {
																		
							$portfolio_items_output .= '<img itemprop="image" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" alt="'.$item_title.'" />'. "\n";
							
							$portfolio_items_output .= '<a '.$link_config.'></a>';
							if ($item_subtitle != "" && $hover_show_excerpt == "no" && ($display_type == "gallery" || $display_type == "masonry-gallery")) {
							$portfolio_items_output .= '<figcaption><div class="thumb-info thumb-info-extended">';
							} else if ($display_type == "standard" || $display_type == "masonry") {
							$portfolio_items_output .= '<figcaption><div class="thumb-info thumb-info-alt">';						
							} else if ($hover_show_excerpt == "yes" && ($display_type == "gallery" || $display_type == "masonry-gallery")) {
							$portfolio_items_output .= '<figcaption><div class="thumb-info thumb-info-excerpt">';						
							} else {
							$portfolio_items_output .= '<figcaption><div class="thumb-info">';
							}
							if ($display_type == "gallery" || $display_type == "masonry-gallery") {
								if ($hover_show_excerpt == "yes") {
								$portfolio_items_output .= '<h4 itemprop="name headline">'.$item_title.'</h4>';
								$portfolio_items_output .= '<p itemprop="description">'.ct_excerpt(30).'</p>';
								} else {
								$portfolio_items_output .= '<h4 itemprop="name headline">'.$item_title.'</h4>';
								$portfolio_items_output .= '<h5 itemprop="name alternative">'.$item_subtitle.'</h5>';
								}
							}
							$portfolio_items_output .= '<i class="'.$item_icon.'"></i>';
							$portfolio_items_output .= '</div></figcaption>';
						}
					}
					
					$portfolio_items_output .= '</figure>'. "\n";
				}
				
				if ($display_type != "gallery" && $display_type != "masonry-gallery") {
					
					$portfolio_items_output .= '<div class="portfolio-item-details">'. "\n";

                    if($show_it_love == "yes"){
					$portfolio_items_output .= '<div class="comments-likes">';
					if (function_exists( 'lip_love_it_link' )) {
						$portfolio_items_output .= lip_love_it_link(get_the_ID(), '<i class="ss-heart"></i>', '<i class="ss-heart"></i>', false);
					}
					$portfolio_items_output .= '</div>';
                    }
					
					
					if ($show_title == "yes") {
						$portfolio_items_output .= '<h3 class="portfolio-item-title" itemprop="name headline"><a '.$link_config.'>'. $item_title .'</a></h3>'. "\n";
					}
					if ($show_subtitle == "yes" && $item_subtitle) {
						$portfolio_items_output .= '<h5 class="portfolio-subtitle" itemprop="alternativeHeadline">'.$item_subtitle.'</h5>'. "\n";
					}
					if ($show_excerpt == "yes") {
						$portfolio_items_output .= '<div class="portfolio-item-excerpt" itemprop="description">'. $post_excerpt .'</div>'. "\n";
					}
					
					$portfolio_items_output .= '</div>'. "\n";
					
				}
				
				$portfolio_items_output .= '</li>'. "\n";
				
				$count++;
			
			endwhile;
			
			wp_reset_postdata();
					
			$portfolio_items_output .= '</ul>'. "\n";
			
			
			/* PAGINATION OUTPUT
			================================================== */
			if ($pagination == "yes") {
				if ($display_type == "masonry" || $display_type == "masonry-gallery") {
				$portfolio_items_output .= '<div class="pagination-wrap masonry-pagination">';
				} else {
				$portfolio_items_output .= '<div class="pagination-wrap">';
				}
				$portfolio_items_output .= pagenavi($portfolio_items);									
				$portfolio_items_output .= '</div>';
			}
			
			
			/* FUNCTION OUTPUT
			================================================== */
			return $portfolio_items_output;
		}
	}	
	
	
	/* PORTFOLIO FILTER
	================================================== */
	if (!function_exists('ct_portfolio_filter')) {
		function ct_portfolio_filter($style = "basic") {
			
			$filter_output = "";
			
			$options = get_option('ct_coo_options');
			$filter_wrap_bg = $options['filter_wrap_bg'];
			
			if ($style == "slide-out") {
			
		    $filter_output .= '<div class="filter-wrap slideout-filter row clearfix">'. "\n";
		    $filter_output .= '<a href="#" class="select"><i class="fa-justify"></i>'. __("Filter our work", "cootheme") .'</a>'. "\n";
		    $filter_output .= '<div class="filter-slide-wrap col-sm-12 alt-bg '.$filter_wrap_bg.'">'. "\n";
		    $filter_output .= '<ul class="portfolio-filter filtering row clearfix">'. "\n";
		    $filter_output .= '<li class="all selected col-sm-2"><a data-filter="*" href="#"><span class="item-name">'. __("All", "cootheme").'</span><span class="item-count">0</span></a></li>'. "\n";
		    			$tax_terms = ct_get_category_list('portfolio-category', 1);
		    			foreach ($tax_terms as $tax_term) {
		    				$term_slug = strtolower(str_replace(' ', '-', $tax_term));
		    				$filter_output .= '<li class="col-sm-2"><a href="#" title="View all ' . $tax_term . ' items" class="' . $term_slug . '" data-filter=".' . $term_slug . '"><span class="item-name">' . $tax_term . '</span><span class="item-count">0</span></a></li>'. "\n";
		    			}
		    $filter_output .= '</ul></div></div>'. "\n";
		    
		    } else {
		    
		    $filter_output .= '<div class="filter-wrap row clearfix">'. "\n";
		    $filter_output .= '<ul class="portfolio-filter-tabs bar-styling filtering col-sm-12 clearfix">'. "\n";
		    $filter_output .= '<li class="all selected"><a data-filter="*" href="#"><span class="item-name">'. __("All", "cootheme").'</span><span class="item-count">0</span></a></li>'. "\n";
		    			$tax_terms = ct_get_category_list('portfolio-category', 1);
		    			foreach ($tax_terms as $tax_term) {
		    				$term_slug = strtolower(str_replace(' ', '-', $tax_term));
		    				$filter_output .= '<li><a href="#" title="View all ' . $tax_term . ' items" class="' . $term_slug . '" data-filter=".' . $term_slug . '"><span class="item-name">' . $tax_term . '</span><span class="item-count">0</span></a></li>'. "\n";
		    			}
		    $filter_output .= '</ul></div>'. "\n";
		    
		    }
			
			return $filter_output;	
		}
	}
?>