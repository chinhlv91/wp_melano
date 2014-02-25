<?php
	/*
	*
	*	Coo Page Builder - Imapact Text Shortcode
	*	------------------------------------------------
	*	Cootheme
	* 	http://www.cootheme.com
	*
	*/

	class CooPageBuilderShortcode_impact_text extends CooPageBuilderShortcode {
	
	    protected function content( $atts, $content = null ) {
	        $color = $type = $target = $href = $border_top = $include_button = $button_style = $border_bottom = $title = $width = $position = $el_class = '';
	        extract(shortcode_atts(array(
	            'color' => 'btn',
	            'include_button' => '',
	            'button_style' => '',
	            'target' => '',
	            'type'	=> '',
	            'href' => '',
	            'shadow'		=> 'yes',
	            'title' => __('Text on the button', "coo-page-builder"),
	            'position' => 'cta_align_right',
	            'alt_background'	=> 'none',
	            'width' => '1/1',
	            'el_class' => '',
	            'el_position' => '',
	        ), $atts));
	        $output = '';
	        
	        $border_class = '';
	        
	        if ($border_top == "yes") {
	        $border_class .= 'border-top ';
	        }
	        if ($border_bottom == "yes") {
	        $border_class .= 'border-bottom';
	        }
	
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
	
	        if ( $target == 'same' || $target == '_self' ) { $target = '_self'; }
	        if ( $target != '' ) { $target = $target; }
		
	        $a_class = '';
	        if ( $el_class != '' ) {
	            $tmp_class = explode(" ", $el_class);
	            if ( in_array("prettyphoto", $tmp_class) ) {
	                wp_enqueue_script( 'prettyphoto' );
	                wp_enqueue_style( 'prettyphoto' );
	                $a_class .= ' prettyphoto'; $el_class = str_ireplace("prettyphoto", "", $el_class);
	            }
	        }
	        
	        $button = '';
	        
	        if ($button_style == "arrow") {
	        
		        if ($position == "cta_align_left") {
		        	$button = '<a class="impact-text-arrow arrow-left" href="'.$href.'" target="'.$target.'"><i class="ss-navigateleft"></i></a>';
		        } else { 
		        	$button = '<a class="impact-text-arrow arrow-right" href="'.$href.'" target="'.$target.'"><i class="ss-navigateright"></i></a>';
		        }
	        
	        } else {
	        	$button = '<a class="ct-button ct-button '. $color .' '. $type .'" href="'.$href.'" target="'.$target.'"><span>' . $title . '</span></a>';
	        }
	        
	        if ($alt_background == "none" || $sidebars != "no-sidebars") {
	        $output .= '<div class="spb_impact_text spb_content_element clearfix '.$width.' '.$position.$el_class.'">'. "\n";
	        } else {
	        $output .= '<div class="spb_impact_text spb_content_element clearfix alt-bg '.$alt_background.' '.$width.' '.$position.$el_class.'">'. "\n";
	        }
	        $output .= '<div class="impact-text-wrap clearfix">'. "\n";
	        $output .= '<div class="spb_call_text">'. spb_format_content($content) . '</div>'. "\n";
	        if ($include_button == "yes") {
	        $output .= $button. "\n";
	        }
	        $output .= '</div>'. "\n";
	        $output .= '</div> ' . $this->endBlockComment('.spb_impact_text') . "\n";
			
			$output = $this->startRow($el_position) . $output . $this->endRow($el_position);
			
	        return $output;
	    }
	}
	
	$colors_arr = array(__("Accent", "coo-page-builder") => "accent", __("Blue", "coo-page-builder") => "blue", __("Grey", "coo-page-builder") => "grey", __("Light grey", "coo-page-builder") => "lightgrey", __("Purple", "coo-page-builder") => "purple", __("Light Blue", "coo-page-builder") => "lightblue", __("Green", "coo-page-builder") => "green", __("Lime Green", "coo-page-builder") => "limegreen", __("Turquoise", "coo-page-builder") => "turquoise", __("Pink", "coo-page-builder") => "pink", __("Orange", "coo-page-builder") => "orange");
			
	$target_arr = array(__("Same window", "coo-page-builder") => "_self", __("New window", "coo-page-builder") => "_blank");
	
	SPBMap::map( 'impact_text', array(
	    "name"		=> __("Impact Text + Button", "coo-page-builder"),
	    "base"		=> "impact_text",
	    "class"		=> "button_grey",
		"icon"		=> "spb-icon-impact-text",
	    "controls"	=> "edit_popup_delete",
	    "params"	=> array(
	    	array(
	    	    "type" => "dropdown",
	    	    "heading" => __("Include button", "coo-page-builder"),
	    	    "param_name" => "include_button",
	    	    "value" => array(__("Yes", "coo-page-builder") => "yes", __("No", "coo-page-builder") => "no"),
	    	    "description" => __("Include a button in the asset.", "coo-page-builder")
	    	),
	    	array(
	    	    "type" => "dropdown",
	    	    "heading" => __("Button Style", "coo-page-builder"),
	    	    "param_name" => "button_style",
	    	    "value" => array(__("Standard", "coo-page-builder") => "standard", __("Arrow", "coo-page-builder") => "arrow"),
	    	),
	        array(
	            "type" => "textfield",
	            "heading" => __("Text on the button", "coo-page-builder"),
	            "param_name" => "title",
	            "value" => __("Text on the button", "coo-page-builder"),
	            "description" => __("Text on the button.", "coo-page-builder")
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("URL (Link)", "coo-page-builder"),
	            "param_name" => "href",
	            "value" => "",
	            "description" => __("Button link.", "coo-page-builder")
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Color", "coo-page-builder"),
	            "param_name" => "color",
	            "value" => $colors_arr,
	            "description" => __("Button color.", "coo-page-builder")
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Target", "coo-page-builder"),
	            "param_name" => "target",
	            "value" => $target_arr
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Button position", "coo-page-builder"),
	            "param_name" => "position",
	            "value" => array(__("Align right", "coo-page-builder") => "cta_align_right", __("Align left", "coo-page-builder") => "cta_align_left", __("Align bottom", "coo-page-builder") => "cta_align_bottom"),
	            "description" => __("Select button alignment.", "coo-page-builder")
	        ),
	        array(
	            "type" => "textarea_html",
	            "holder" => "div",
	            "class" => "",
	            "heading" => __("Text", "coo-page-builder"),
	            "param_name" => "content",
	            "value" => __("click the edit button to change this text.", "coo-page-builder"),
	            "description" => __("Enter your content.", "coo-page-builder")
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
	    ),
	    "js_callback" => array("init" => "spbCallToActionInitCallBack", "save" => "spbCallToActionSaveCallBack")
	) );
?>