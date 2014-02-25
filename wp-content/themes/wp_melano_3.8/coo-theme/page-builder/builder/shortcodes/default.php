<?php
	
	/*
	*
	*	Coo Page Builder - Default Shortcodes Config
	*	------------------------------------------------
	*	Cootheme
	* 	http://www.cootheme.com
	*
	*/
	
	/* TEXT BLOCK ASSET
	================================================== */
	class CooPageBuilderShortcode_spb_text_block extends CooPageBuilderShortcode {
	
	    public function content( $atts, $content = null ) {
	
	        $title = $pb_margin_bottom = $pb_border_bottom = $el_class = $width = $el_position = '';
	
	        extract(shortcode_atts(array(
	        	'title' => '',
	        	'icon' => '',
	        	'pb_margin_bottom' => 'no',
	        	'pb_border_bottom' => 'no',
	            'el_class' => '',
	            'el_position' => '',
	            'width' => '1/2'
	        ), $atts));
	
	        $output = '';
	
	        $el_class = $this->getExtraClass($el_class);
	        $width = spb_translateColumnWidthToSpan($width);
	
	        $el_class .= ' spb_text_column';
	        
	        if ($pb_margin_bottom == "yes") {
	        $el_class .= ' pb-margin-bottom';
	        }
	        if ($pb_border_bottom == "yes") {
	        $el_class .= ' pb-border-bottom';
	        }
	        
	        $icon_output = "";
	        
	        if ($icon) { 
	        $icon_output = '<i class="'.$icon.'"></i>';
	        }
	
	        $output .= "\n\t".'<div class="spb_content_element '.$width.$el_class.'">';
	        $output .= "\n\t\t".'<div class="spb_wrapper clearfix">';
	        if ($icon_output != "") {
	        $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading spb-icon-heading"><span>'.$icon_output.''.$title.'</span></h3>' : '';
	        } else {
	        $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading spb-text-heading"><span>'.$title.'</span></h3>' : '';
	        }
	        $output .= "\n\t\t\t".do_shortcode($content);
	        $output .= "\n\t\t".'</div> ' . $this->endBlockComment('.spb_wrapper');
	        $output .= "\n\t".'</div> ' . $this->endBlockComment($width);
	
	        //
	        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
	        return $output;
	    }
	}
	
	SPBMap::map( 'spb_text_block', array(
	    "name"		=> __("Text Block", "coo-page-builder"),
	    "base"		=> "spb_text_block",
	    "class"		=> "",
	    "icon"      => "spb-icon-text-block",
	    "wrapper_class" => "clearfix",
	    "controls"	=> "full",
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
	    	    "heading" => __("Title icon", "coo-page-builder"),
	    	    "param_name" => "icon",
	    	    "value" => "",
	    	    "description" => __("Icon to the left of the title text. You can get the code from <a href='http://fortawesome.github.com/Font-Awesome/' target='_blank'>here</a>. E.g. icon-cloud", "coo-page-builder")
	    	),
	        array(
	            "type" => "textarea_html",
	            "holder" => "div",
	            "class" => "",
	            "heading" => __("Text", "coo-page-builder"),
	            "param_name" => "content",
	            "value" => __("<p>This is a text block. Click the edit button to change this text.</p>", "coo-page-builder"),
	            "description" => __("Enter your content.", "coo-page-builder")
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Margin below widget", "coo-page-builder"),
	            "param_name" => "pb_margin_bottom",
	            "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
	            "description" => __("Add a bottom margin to the widget.", "coo-page-builder")
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Border below widget", "coo-page-builder"),
	            "param_name" => "pb_border_bottom",
	            "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
	            "description" => __("Add a bottom border to the widget.", "coo-page-builder")
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
	
	
	/* BOXED CONTENT ASSET
	================================================== */ 
	class CooPageBuilderShortcode_boxed_content extends CooPageBuilderShortcode {
	
	    public function content( $atts, $content = null ) {
	
	        $title = $type = $custom_styling = $custom_bg_colour = $custom_text_colour = $pb_margin_bottom = $el_class = $width = $el_position = '';
	
	        extract(shortcode_atts(array(
	        	'title' => '',
	        	'type'	=> '',
	        	'custom_bg_colour' => '',
	        	'custom_text_colour' => '',
	        	'pb_margin_bottom' => 'no',
	            'el_class' => '',
	            'el_position' => '',
	            'width' => '1/2'
	        ), $atts));
	
	        $output = '';
	
	        $el_class = $this->getExtraClass($el_class);
	        $width = spb_translateColumnWidthToSpan($width);
	
	        $el_class .= ' spb_box_text';
	        $el_class .= ' '.$type;
	        
	        if ($pb_margin_bottom == "yes") {
	        $el_class .= ' pb-margin-bottom';
	        }
	        
	        if ($custom_bg_colour != "") {
	        $custom_styling .= 'background: '.$custom_bg_colour.'!important;';
	        }
	        
	        if ($custom_text_colour != "") {
	        $custom_styling .= 'color: '.$custom_text_colour.'!important;';
	        }
	
	        $output .= "\n\t".'<div class="spb_content_element '.$width.$el_class.'">';
	        $output .= "\n\t\t".'<div class="spb_wrapper">';
	        $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading spb-text-heading"><span>'.$title.'</span></h3>' : '';
	        $output .= "\n\t\t\t";
	        if ($custom_styling != "") {
	        $output .= '<div class="box-content-wrap" style="'.$custom_styling.'">'.do_shortcode($content).'</div>';
	        } else {
	        $output .= '<div class="box-content-wrap">'.do_shortcode($content).'</div>';
	        }
	        $output .= "\n\t\t".'</div> ' . $this->endBlockComment('.spb_wrapper');
	        $output .= "\n\t".'</div> ' . $this->endBlockComment($width);
	
	        //
	        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
	        return $output;
	    }
	}
	
	SPBMap::map( 'boxed_content', array(
	    "name"		=> __("Boxed Content", "coo-page-builder"),
	    "base"		=> "boxed_content",
	    "class"		=> "",
	    "icon"      => "spb-icon-boxed-content",
	    "wrapper_class" => "clearfix",
	    "controls"	=> "full",
	    "params"	=> array(
	    	array(
	    	    "type" => "textfield",
	    	    "heading" => __("Widget title", "coo-page-builder"),
	    	    "param_name" => "title",
	    	    "value" => "",
	    	    "description" => __("Heading text. Leave it empty if not needed.", "coo-page-builder")
	    	),
	        array(
	            "type" => "textarea_html",
	            "holder" => "div",
	            "class" => "",
	            "heading" => __("Text", "coo-page-builder"),
	            "param_name" => "content",
	            "value" => __("<p>This is a boxed content block. Click the edit button to edit this text.</p>", "coo-page-builder"),
	            "description" => __("Enter your content.", "coo-page-builder")
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Box type", "coo-page-builder"),
	            "param_name" => "type",
	            "value" => array(__('Coloured', "coo-page-builder") => "coloured", __('White with stroke', "coo-page-builder") => "whitestroke"),
	            "description" => __("Choose the surrounding box type for this content", "coo-page-builder")
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Custom background colour", "coo-page-builder"),
	            "param_name" => "custom_bg_colour",
	            "value" => "",
	            "description" => __("Provide a hex colour code here (include #). If blank, your chosen accent colour will be used.", "coo-page-builder")
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Custom text colour", "coo-page-builder"),
	            "param_name" => "custom_text_colour",
	            "value" => "",
	            "description" => __("Provide a hex colour code here (include #) if you want to override the default (#ffffff).", "coo-page-builder")
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Margin below widget", "coo-page-builder"),
	            "param_name" => "pb_margin_bottom",
	            "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
	            "description" => __("Add a bottom margin to the widget.", "coo-page-builder")
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
	
	
	/* DIVIDER ASSET
	================================================== */ 
	class CooPageBuilderShortcode_divider extends CooPageBuilderShortcode {
	
	    protected function content( $atts, $content = null ) {
	        $with_line = $type = $el_class = $text = '';
	        extract(shortcode_atts(array(
	            'with_line' => '',
	            'type'		=> '',
	            'full_width'		=> '',
	            'text' => '',
	            'el_class' => '',
	            'el_position' => ''
	        ), $atts));
	        
	        $width = spb_translateColumnWidthToSpan("1/1");

	        $output = '';
	        if ($full_width == "yes") {
	        $output .= '<div class="spb_divider '. $type .' spb_content_element alt-bg '.$width.$el_class.'">';
	        $output .= '<span class="short-line"></span>';
	        } else {
	        $output .= '<div class="divider-wrap"><div class="spb_divider '. $type .' spb_content_element '.$width.$el_class.'">';
            $output .= '<span class="short-line"></span>';
	        }
	        if ($type == "go_to_top") {
	        $output .= '<a class="animate-top" href="#">'. $text .'</a>';
	        } else if ($type == "go_to_top_icon1") {
	        $output .= '<a class="animate-top" href="#"><i class="ss-up"></i></a>';
	        } else if ($type == "go_to_top_icon2") {
	        $output .= '<a class="animate-top" href="#">'. $text .'<i class="ss-up"></i></a>';
	        }
	        if ($full_width != "yes") {
	        $output .= '</div>';
	        }
	        $output .= '</div>'.$this->endBlockComment('divider')."\n";
	        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
	        return $output;
	    }
	}
	SPBMap::map( 'divider',  array(
	    "name"		=> __("Divider", "coo-page-builder"),
	    "base"		=> "divider",
	    "class"		=> "spb_divider spb_controls_top_right",
		'icon'		=> 'spb-icon-divider',
	    "controls"	=> 'edit_popup_delete',
	    "params"	=> array(
	        array(
	            "type" => "dropdown",
	            "heading" => __("Divider type", "coo-page-builder"),
	            "param_name" => "type",
	            "value" => array(__('Standard', "coo-page-builder") => "standard", __('Thin', "coo-page-builder") => "thin", __('Dotted', "coo-page-builder") => "dotted", __('Go to top (text)', "coo-page-builder") => "go_to_top", __('Go to top (Icon 1)', "coo-page-builder") => "go_to_top_icon1", __('Go to top (Icon 2)', "coo-page-builder") => "go_to_top_icon2"),
	            "description" => __("Select divider type.", "coo-page-builder")
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Go to top text", "coo-page-builder"),
	            "param_name" => "text",
	            "value" => __("Go to top", "coo-page-builder"),
	            "description" => __("The text for the 'Go to top (text)' divider type.", "coo-page-builder")
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Full width", "coo-page-builder"),
	            "param_name" => "full_width",
	            "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
	            "description" => __("Select yes if you'd like the divider to be full width (only to be used with no sidebars, and with Standard/Thin/Dotted divider types).", "coo-page-builder")
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Extra class name", "coo-page-builder"),
	            "param_name" => "el_class",
	            "value" => "",
	            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "coo-page-builder")
	        )
	    ),
	    "js_callback" => array("init" => "spbTextSeparatorInitCallBack")
	) );
	
	
	/* BLANK SPACER ASSET
	================================================== */ 
	class CooPageBuilderShortcode_blank_spacer extends CooPageBuilderShortcode {
	
	    protected function content( $atts, $content = null ) {
	        $height = $el_class = '';
	        extract(shortcode_atts(array(
	            'height' => '',
	            'spacer_id' => '',
	            'el_class' => '',
	        ), $atts));
	        
	        $width = spb_translateColumnWidthToSpan("1/1");
	        
	        $output = '';
	        if ($spacer_id != "") {
	        $output .= '<div id="'.$spacer_id.'" class="blank_spacer '.$width.' '.$el_class.'" style="height:'.$height.';">';
	        } else {
	        $output .= '<div class="blank_spacer '.$width.' '.$el_class.'" style="height:'.$height.';">';
	        }
	        $output .= '</div>'.$this->endBlockComment('divider')."\n";
	        return $output;
	    }
	}
	
	SPBMap::map( 'blank_spacer',  array(
	    "name"		=> __("Blank Spacer", "coo-page-builder"),
	    "base"		=> "blank_spacer",
	    "class"		=> "spb_blank_spacer spb_controls_top_right",
		'icon'		=> 'spb-icon-spacer',
	    "controls"	=> 'edit_popup_delete',
	    "params"	=> array(
	        array(
	            "type" => "textfield",
	            "heading" => __("Height", "coo-page-builder"),
	            "param_name" => "height",
	            "value" => __("30px", "coo-page-builder"),
	            "description" => __("The height of the spacer, in px (required).", "coo-page-builder")
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Spacer ID", "coo-page-builder"),
	            "param_name" => "spacer_id",
	            "value" => "",
	            "description" => __("If you wish to add an ID to the spacer, then add it here. You can then use the id to deep link to this section of the page. NOTE: Make sure this is unique to the page!!", "coo-page-builder")
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Extra class name", "coo-page-builder"),
	            "param_name" => "el_class",
	            "value" => "",
	            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "coo-page-builder")
	        )
	    ),
	    "js_callback" => array("init" => "spbBlankSpacerInitCallBack")
	) );
	
	
	/* MESSAGE BOX ASSET
	================================================== */
	class CooPageBuilderShortcode_spb_message extends CooPageBuilderShortcode {
	
	    protected function content( $atts, $content = null ) {
	        $color = '';
	        extract(shortcode_atts(array(
	            'color' => 'alert-info',
	            'el_position' => ''
	        ), $atts));
	        $output = '';
	        if ($color == "alert-block") $color = "";
	        
	        $width = spb_translateColumnWidthToSpan("1/1");
	
	        $output .= '<div class="'.$width.'"><div class="alert spb_content_element '.$color.'"><div class="messagebox_text">'.spb_format_content($content).'</div></div></div>'.$this->endBlockComment('alert box')."\n";
	        //$output .= '<div class="spb_messagebox message '.$color.'"><div class="messagebox_text">'.spb_format_content($content).'</div></div>';
	        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
	        return $output;
	    }
	}
	
	SPBMap::map( 'spb_message', array(
	    "name"		=> __("Message Box", "coo-page-builder"),
	    "base"		=> "spb_message",
	    "class"		=> "spb_messagebox spb_controls_top_right",
		"icon"		=> "spb-icon-message-box",
	    "wrapper_class" => "alert",
	    "controls"	=> "edit_popup_delete",
	    "params"	=> array(
	        array(
	            "type" => "dropdown",
	            "heading" => __("Message box type", "coo-page-builder"),
	            "param_name" => "color",
	            "value" => array(__('Informational', "coo-page-builder") => "alert-info", __('Warning', "coo-page-builder") => "alert-block", __('Success', "coo-page-builder") => "alert-success", __('Error', "coo-page-builder") => "alert-error"),
	            "description" => __("Select message type.", "coo-page-builder")
	        ),
	        array(
	            "type" => "textarea_html",
	            "holder" => "div",
	            "class" => "messagebox_text",
	            "heading" => __("Message text", "coo-page-builder"),
	            "param_name" => "content",
	            "value" => __("<p>This is a message box. Click the edit button to edit this text.</p>", "coo-page-builder"),
	            "description" => __("Message text.", "coo-page-builder")
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Extra class name", "coo-page-builder"),
	            "param_name" => "el_class",
	            "value" => "",
	            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "coo-page-builder")
	        )
	    ),
	    "js_callback" => array("init" => "spbMessageInitCallBack")
	) );
	
	
	/* TOGGLE ASSET
	================================================== */ 
	class CooPageBuilderShortcode_spb_toggle extends CooPageBuilderShortcode {
	
	    protected function content( $atts, $content = null ) {
	        $title = $el_class = $open = null;
	        extract(shortcode_atts(array(
	            'title' => __("Click to toggle", "coo-page-builder"),
	            'el_class' => '',
	            'open' => 'false',
	            'el_position' => '',
	            'width' => '1/1'
	        ), $atts));
	        $output = '';
	        
	        $width = spb_translateColumnWidthToSpan($width);
	
	        $el_class = $this->getExtraClass($el_class);
	        $open = ( $open == 'true' ) ? ' spb_toggle_title_active' : '';
	        $el_class .= ( $open == ' spb_toggle_title_active' ) ? ' spb_toggle_open' : '';
			$output .= '<div class="toggle-wrap '.$width.'">';
	        $output .= '<div class="spb_toggle'.$open.'">'.$title.'</div><div class="spb_toggle_content'.$el_class.'">'.spb_format_content($content).'</div>'.$this->endBlockComment('toggle')."\n";
	        $output .= '</div>';
			$output = $this->startRow($el_position) . $output . $this->endRow($el_position);
	        return $output;
	    }
	}
	
	SPBMap::map( 'spb_toggle', array(
	    "name"		=> __("Toggle", "coo-page-builder"),
	    "base"		=> "spb_toggle",
	    "class"		=> "spb_faq",
		"icon"		=> "spb-icon-toggle",
	    "params"	=> array(
	        array(
	            "type" => "textfield",
	            "holder" => "h4",
	            "class" => "toggle_title",
	            "heading" => __("Toggle title", "coo-page-builder"),
	            "param_name" => "title",
	            "value" => __("Toggle title", "coo-page-builder"),
	            "description" => __("Toggle block title.", "coo-page-builder")
	        ),
	        array(
	            "type" => "textarea_html",
	            "holder" => "div",
	            "class" => "toggle_content",
	            "heading" => __("Toggle content", "coo-page-builder"),
	            "param_name" => "content",
	            "value" => __("<p>The toggle content goes here, click the edit button to change this text.</p>", "coo-page-builder"),
	            "description" => __("Toggle block content.", "coo-page-builder")
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Default state", "coo-page-builder"),
	            "param_name" => "open",
	            "value" => array(__("Closed", "coo-page-builder") => "false", __("Open", "coo-page-builder") => "true"),
	            "description" => __("Select this if you want toggle to be open by default.", "coo-page-builder")
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