<?php

class CooPageBuilderShortcode_team extends CooPageBuilderShortcode {

    protected function content($atts, $content = null) {

		    $title = $width = $el_class = $output = $filter = $social_icon_type = $items = $el_position = '';
		
	        extract(shortcode_atts(array(
		        'title' => '',
		        'item_columns' => '3',
	        	"item_count"	=> '12',
	        	"category"		=> '',
	        	'social_icon_type' => 'dark',
	        	'pagination'	=> '',
	        	'el_position' => '',
	        	'width' => '1/1',
	        	'el_class' => ''
	        ), $atts));
	        
	        // CATEGORY SLUG MODIFICATION
	        if ($category == "All") {$category = "all";}
	        if ($category == "all") {$category = '';}
	        $category_slug = str_replace('_', '-', $category);
		    
    		global $post, $wp_query;
    		
    		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    		$team_args=array(
	    		'post_type' => 'team',
	    		'post_status' => 'publish',
	    		'paged' => $paged,
	    		'team-category' => $category_slug,
	    		'posts_per_page' => $item_count,
	    		'ignore_sticky_posts'=> 1
    		);    			    		
    		$team_members = new WP_Query( $team_args );
    		
    		$count = 0;
    		$image_width = 270;
    		$image_height = 270;    		
    		
    		if ($item_columns == "1") {
    		$item_class = 'col-sm-12';
    		} else if ($item_columns == "2") {
    		$image_width = 540;
    		$image_height = 540;
    		$item_class = 'col-sm-6';
    		} else if ($item_columns == "3") {
    		$image_width = 360;
    		$image_height = 360;
    		$item_class = 'col-sm-4';
    		} else {
    		$item_class = 'col-sm-3';
    		}
    		    		
			$items .= '<ul class="team-members row clearfix">';
	
			while ( $team_members->have_posts() ) : $team_members->the_post();
				
				$member_name = get_the_title();
				$member_position = get_post_meta($post->ID, 'ct_team_member_position', true);
				$member_bio = ct_content(15);
				$member_email = get_post_meta($post->ID, 'ct_team_member_email', true);
				$member_phone = get_post_meta($post->ID, 'ct_team_member_phone_number', true);
				$member_twitter = get_post_meta($post->ID, 'ct_team_member_twitter', true);
				$member_facebook = get_post_meta($post->ID, 'ct_team_member_facebook', true);
				$member_linkedin = get_post_meta($post->ID, 'ct_team_member_linkedin', true);
				$member_google_plus = get_post_meta($post->ID, 'ct_team_member_google_plus', true);
				$member_skype = get_post_meta($post->ID, 'ct_team_member_skype', true);
				$member_instagram = get_post_meta($post->ID, 'ct_team_member_instagram', true);
				$member_dribbble = get_post_meta($post->ID, 'ct_team_member_dribbble', true);
				$member_image = get_post_thumbnail_id();
				$member_link = get_permalink();
				   	
				$items .= '<li itemscope data-id="id-'. $count .'" class="clearfix team-member '.$item_class.'">';
				
				$img_url = wp_get_attachment_url( $member_image,'full' );
				$image = aq_resize( $img_url, $image_width, $image_height, true, false);
				
				$items .= '<figure class="gallery-style">';
							if ($image) {
								$items .= '<a href="'.get_permalink().'"><img itemprop="image" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'" /></a>';
							}
							
				$items .= '<figcaption>';
				
				$items .= '<h5 class="team-member-name">'. $member_name .'</h5>';
				$items .= '<h5 class="team-member-position">'. $member_position .'</h5>';
				$items .= '<p class="team-member-bio">'. $member_bio .'</0>';

				if (($member_twitter) || ($member_facebook) || ($member_linkedin) || ($member_google_plus) || ($member_skype) || ($member_instagram) || ($member_dribbble)) {				
					$items .= '<ul class="social-icons">';
					if ($member_twitter) {
						$items .= '<li class="twitter"><a href="http://www.twitter.com/'.$member_twitter.'" target="_blank"><i class="fa-twitter"></i><i class="fa-twitter"></i></a></li>';
					}
					if ($member_facebook) {
						$items .= '<li class="facebook"><a href="'.$member_facebook.'" target="_blank"><i class="fa-facebook"></i><i class="fa-facebook"></i></a></li>';
					}
					if ($member_linkedin) {
						$items .= '<li class="linkedin"><a href="'.$member_linkedin.'" target="_blank"><i class="fa-linkedin"></i><i class="fa-linkedin"></i></a></li>';
					}
					if ($member_google_plus) {
						$items .= '<li class="googleplus"><a href="'.$member_google_plus.'" target="_blank"><i class="fa-google-plus"></i><i class="fa-google-plus"></i></a></li>';
					}
					if ($member_skype) {
						$items .= '<li class="skype"><a href="skype:'.$member_skype.'" target="_blank"><i class="fa-skype"></i><i class="fa-skype"></i></a></li>';
					}
					if ($member_instagram) {
						$items .= '<li class="instagram"><a href="'.$member_instagram.'" target="_blank"><i class="fa-instagram"></i><i class="fa-instagram"></i></a></li>';
					}
					if ($member_dribbble) {
						$items .= '<li class="dribbble"><a href="http://www.dribbble.com/'.$member_dribbble.'" target="_blank"><i class="fa-dribbble"></i><i class="fa-dribbble"></i></a></li>';
					}
					$items .= '</ul>';
				}
				$items .= '</figcaption>';
				$items .= '</figure>';
				
				$items .= '</li>';
				$count++;
				
			endwhile;
			
			wp_reset_postdata();
					
			$items .= '</ul>';
    
   		
    		// PAGINATION
    		
    		if ($pagination == "yes") {
    		
	    		$items .= '<div class="pagination-wrap">';
	    		
	    		$items .= pagenavi($team_members);
	    							
	    		$items .= '</div>';
    		
    		}       
    		
    		
    		$el_class = $this->getExtraClass($el_class);
            $width = spb_translateColumnWidthToSpan($width);
            
            $output .= "\n\t".'<div class="team_list_widget spb_content_element '.$width.$el_class.'">';
            $output .= "\n\t\t".'<div class="spb_wrapper">';
            $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading"><span>'.$title.'</span></h3>' : '';
            $output .= "\n\t\t\t\t".$items;
            $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
            $output .= "\n\t".'</div> '.$this->endBlockComment($width);
    
            $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
           
           	global $ct_include_isotope, $ct_has_team;
           	$ct_include_isotope = true;
           	$ct_has_team = true;
            
            return $output;
		
    }
}

SPBMap::map( 'team', array(
    "name"		=> __("Team Gallery", "coo-page-builder"),
    "base"		=> "team",
    "class"		=> "team",
    "icon"      => "spb-icon-team",
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
            "value" => "12",
            "description" => __("The number of team members to show per page.", "coo-page-builder")
        ),
        array(
            "type" => "select-multiple",
            "heading" => __("Team category", "coo-page-builder"),
            "param_name" => "category",
            "value" => ct_get_category_list('team-category'),
            "description" => __("Choose the category for the portfolio items.", "coo-page-builder")
		),
		array(
		    "type" => "dropdown",
		    "heading" => __("Pagination", "coo-page-builder"),
		    "param_name" => "pagination",
		    "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
		    "description" => __("Show testimonial pagination.", "coo-page-builder")
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