<?php

class CooPageBuilderShortcode_recent_posts extends CooPageBuilderShortcode {

    protected function content($atts, $content = null) {
    		
    		$options = get_option('ct_coo_options');

		    $title = $width = $excerpt_length = $item_class = $offset = $el_class = $output = $items = $el_position = '';
		
	        extract(shortcode_atts(array(
	        	'title' => '',
	        	'item_columns' => '3',
	        	"item_count"	=> '4',
	        	"category"		=> '',
	        	"offset"		=> 0,
	        	"excerpt_length" => '20',
	        	'el_position' => '',
	        	'width' => '1/1',
	        	'el_class' => ''
	        ), $atts));
	        
	        // CATEGORY SLUG MODIFICATION
	        if ($category == "All") {$category = "all";}
	        if ($category == "all") {$category = '';}
	        $category_slug = str_replace('_', '-', $category);
		    
    		global $post, $wp_query;
    		
    		$args=array(
	    		'post_type' => 'post',
	    		'post_status' => 'publish',
	    		'category_name' => $category_slug,
	    		'posts_per_page' => $item_count,
	    		'offset' => $offset
       		);
    		$blog_items = query_posts($args);
    		
    		if ($item_columns == "1") {
    		$item_class = 'col-sm-12';
    		} else if ($item_columns == "2") {
    		$item_class = 'col-sm-6';
    		} else if ($item_columns == "3") {
    		$item_class = 'col-sm-4';
    		} else {
    		$item_class = 'col-sm-3';
    		}
    		
    		if( have_posts() ) {
    		
    			$items .= '<ul class="recent-posts row clearfix">';
    	
    			while ( have_posts() ) {
    				
    				the_post();
    				
    				$thumb_type = get_post_meta($post->ID, 'ct_thumbnail_type', true);
					$thumb_image = rwmb_meta('ct_thumbnail_image', 'type=image&size=full');
    				$thumb_video = get_post_meta($post->ID, 'ct_thumbnail_video_url', true);
    				$thumb_gallery = rwmb_meta( 'ct_thumbnail_gallery', 'type=image&size=thumb-image' );

    				foreach ($thumb_image as $detail_image) {
    					$thumb_img_url = $detail_image['url'];
    					break;
    				}
    												
    				if (!$thumb_image) {
    					$thumb_image = get_post_thumbnail_id();
    					$thumb_img_url = wp_get_attachment_url( $thumb_image, 'full' );
    				}
    					    				
    				$item_title = get_the_title();
    				$post_author = get_the_author_link();
    				$post_date = get_the_date();
    				$post_permalink = get_permalink();
    				$post_comments = get_comments_number();
    				$custom_excerpt = get_post_meta($post->ID, 'ct_custom_excerpt', true);
    				$post_excerpt = '';
    				if ($custom_excerpt != '') {
    				$post_excerpt = ct_custom_excerpt($custom_excerpt, $excerpt_length);
    				} else {
    				$post_excerpt = ct_excerpt($excerpt_length);
    				}
    				
    				$thumb_link_type = get_post_meta($post->ID, 'ct_thumbnail_link_type', true);
    				$thumb_link_url = get_post_meta($post->ID, 'ct_thumbnail_link_url', true);
    				$thumb_lightbox_thumb = rwmb_meta( 'ct_thumbnail_image', 'type=image&size=large' );
    				$thumb_lightbox_image = rwmb_meta( 'ct_thumbnail_link_image', 'type=image&size=large' );
    				$thumb_lightbox_video_url = get_post_meta($post->ID, 'ct_thumbnail_link_video_url', true);
    				$thumb_lightbox_video_url = ct_get_embed_src($thumb_lightbox_video_url);
    				
    				$thumb_lightbox_img_url = wp_get_attachment_url( $thumb_lightbox_image, 'full' );
    				
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
    					$item_icon = "ss-plus";
    				}
    				
    				$items .= '<li itemscope class="recent-post '.$item_class.' clearfix">';
    				
    				$items .= '<figure class="animated-overlay overlay-alt">';
    								
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
    					    $items .= "<li><a '.$link_config.'><img src='{$image['url']}' width='{$image['width']}' height='{$image['height']}' alt='{$alt}' /></a></li>";
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
    					$items .= '<figcaption><div class="thumb-info thumb-info-alt">';
    					$items .= '<i class="'.$item_icon.'"></i>';
    					$items .= '</div></figcaption>';	
    					}
    				}
    				
    				$items .= '</figure>';
    				
    				$items .= '<div class="details-wrap">';
    				$items .= '<h5><a href="'.$post_permalink.'">'.$item_title.'</a></h5>';    				
    				if ($excerpt_length != "0") {
    				$items .= '<div class="excerpt">'. $post_excerpt .'</div>';
    				}
					$items .= '</div>';
					$items .= '<div class="post-item-details clearfix">';
					$items .= '<span class="post-date">'.$post_date.'</span>';
					$items .= '<div class="comments-likes">';
					if ( comments_open() ) {
					$items .= '<a href="'.$post_permalink.'#comment-area"><i class="ss-chat"></i><span>'. $post_comments .'</span></a> ';
					}
					if (function_exists( 'lip_love_it_link' )) {
					$items .= lip_love_it_link(get_the_ID(), '<i class="ss-heart"></i>', '<i class="ss-heart"></i>', false);
					}
					$items .= '</div>';				
					$items .= '</div>';
					$items .= '</li>';
    			
    			}
    			
    			wp_reset_query();
    					
    			$items .= '</ul>';
    
    		}
    		
    		$el_class = $this->getExtraClass($el_class);
            $width = spb_translateColumnWidthToSpan($width);
            
            $output .= "\n\t".'<div class="spb_recent_posts_widget spb_content_element '.$width.$el_class.'">';
            $output .= "\n\t\t".'<div class="spb_wrapper recent-posts-wrap">';
            $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading"><span>'.$title.'</span></h3>' : '';
            $output .= "\n\t\t\t\t".$items;
            $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
            $output .= "\n\t".'</div> '.$this->endBlockComment($width);
    
            $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
            return $output;
		
    }
}

SPBMap::map( 'recent_posts', array(
    "name"		=> __("Recent Posts", "coo-page-builder"),
    "base"		=> "recent_posts",
    "class"		=> "spb_recent_posts",
    "icon"      => "spb-icon-recent-posts",
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
    	    "heading" => __("Columns", "coo-page-builder"),
    	    "param_name" => "item_columns",
    	    "value" => array(
    	    			__('2', "coo-page-builder") => "2",
    	    			__('3', "coo-page-builder") => "3",
    	    			__('4', "coo-page-builder") => "4"
    	    		),
    	    "description" => __("Choose the amount of columns you would like for the team asset.", "coo-page-builder")
    	),
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __("Number of items", "coo-page-builder"),
            "param_name" => "item_count",
            "value" => "4",
            "description" => __("The number of blog items to show per page.", "coo-page-builder")
        ),
		array(
		  	"type" => "select-multiple",
		   	"heading" => __("Blog category", "coo-page-builder"),
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