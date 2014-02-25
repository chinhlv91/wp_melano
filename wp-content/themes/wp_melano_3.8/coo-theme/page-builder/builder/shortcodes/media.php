<?php
	
	/*
	*
	*	Coo Page Builder - Media Shortcodes Config
	*	------------------------------------------------
	*	Cootheme
	* 	http://www.cootheme.com
	*
	*/
	

	/* VIDEO ASSET
	================================================== */ 
	class CooPageBuilderShortcode_spb_video extends CooPageBuilderShortcode {
	
	    protected function content( $atts, $content = null ) {
	        $title = $link = $size = $el_position = $full_width = $width = $el_class = '';
	        extract(shortcode_atts(array(
	            'title' => '',
	            'link' => '',
	            'size' => ( isset($content_width) ) ? $content_width : 500,
	            'el_position' => '',
	            'width' => '1/1',
	            'full_width' => 'no',
	            'el_class' => ''
	        ), $atts));
	        $output = '';
	
	        if ( $link == '' ) { return null; }
	        $video_h = '';
	        $el_class = $this->getExtraClass($el_class);
	        $width = spb_translateColumnWidthToSpan($width);
	        $size = str_replace(array( 'px', ' ' ), array( '', '' ), $size);
	        $size = explode("x", $size);
	        $video_w = $size[0];
	        if ( count($size) > 1 ) {
	            $video_h = ' height="'.$size[1].'"';
	        }
	
	        global $wp_embed;
	        $embed = $wp_embed->run_shortcode('[embed width="'.$video_w.'"'.$video_h.']'.$link.'[/embed]');
			
			if ($full_width == "yes") {
	        $output .= "\n\t".'<div class="spb_video_widget full-width spb_content_element '.$width.$el_class.'">';
			} else {
	        $output .= "\n\t".'<div class="spb_video_widget spb_content_element '.$width.$el_class.'">';
			}
			
	        $output .= "\n\t\t".'<div class="spb_wrapper">';
	        $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading spb_video_heading"><span>'.$title.'</span></h3>' : '';
	        $output .= $embed;
	        $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
	        $output .= "\n\t".'</div> '.$this->endBlockComment($width);
	
	        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
	        return $output;
	    }
	}
	
	SPBMap::map( 'spb_video', array(
	    "name"		=> __("Video Player", "coo-page-builder"),
	    "base"		=> "spb_video",
	    "class"		=> "",
		"icon"		=> "spb-icon-film-youtube",
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
	            "heading" => __("Video link", "coo-page-builder"),
	            "param_name" => "link",
	            "value" => "",
	            "description" => __('Link to the video. More about supported formats at <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex page</a>.', "coo-page-builder")
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Video size", "coo-page-builder"),
	            "param_name" => "size",
	            "value" => "",
	            "description" => __('Enter video size in pixels. Example: 200x100 (Width x Height).', "coo-page-builder")
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Full width", "coo-page-builder"),
	            "param_name" => "full_width",
	            "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
	            "description" => __("Select this if you want the video to be the full width of the page container (leave the above size blank).", "coo-page-builder")
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
	
	
	/* SINGLE IMAGE ASSET
	================================================== */ 
	class CooPageBuilderShortcode_spb_single_image extends CooPageBuilderShortcode {
	
	    public function content( $atts, $content = null ) {
	
	        $el_class = $width = $image_size = $animation = $frame = $lightbox = $image_link = $link_target = $caption = $el_position = $el_class = $image = '';
	
	        extract(shortcode_atts(array(
	            'width' => '1/1',
	            'image' => $image,
	            'image_size' => '',
	            'intro_animation' => 'none',
	            'frame'	=> '',
	            'lightbox' => '',
	            'image_link' => '',
	            'link_target' => '',
	            'caption' => '',
	            'el_position' => '',
	            'el_class' => ''
	        ), $atts));
			
			if ($image_size == "") { $image_size = "large"; }
			
	        $output = '';
	        $img = spb_getImageBySize(array( 'attach_id' => preg_replace('/[^\d]/', '', $image), 'thumb_size' => $image_size ));
	        $img_url = wp_get_attachment_image_src($image, 'large');
	        $el_class = $this->getExtraClass($el_class);
	        $width = spb_translateColumnWidthToSpan($width);
	        // $content =  !empty($image) ? '<img src="'..'" alt="">' : '';
	        $content = '';
	        
	        if ($intro_animation != "none") {
	        $output .= "\n\t".'<div class="spb_content_element spb_single_image ct-animation '. $frame .' '.$width.$el_class.'" data-animation="'.$intro_animation.'" data-delay="200">';
	        } else {
	        $output .= "\n\t".'<div class="spb_content_element spb_single_image '. $frame .' '.$width.$el_class.'">';           
			}
			
	        $output .= "\n\t\t".'<div class="spb_wrapper">';
	        if ($lightbox == "yes") {
	        $output .= '<figure class="lightbox animated-overlay overlay-alt clearfix">';
	        } else {
	        $output .= '<figure class="clearfix">';
	        }
	        if ($image_link != "") {
		        $output .= "\n\t\t\t".'<a class="img-link" href="'.$image_link.'" target="'.$link_target.'">';
		        $output .= $img['thumbnail'];
		        $output .= '</a>';
		        if ($caption != "") {
			        $output .= '<figcaption class="image-caption">';
		            $output .= '<h4>'.$caption.'</h4>';			
		        	$output .= '</figcaption>';
		        }
	        } else if ($lightbox == "yes") {
		        $output .= $img['thumbnail'];
		        $output .= '<a class="view" href="'.$img_url[0].'" rel="image-gallery"></a>';
		        $output .= '<figcaption>';
		        if ($caption != "") {
			        $output .= '<div class="thumb-info">';	
			        $output .= '<h4>'.$caption.'</h4>';			
		        } else {
		      		$output .= '<div class="thumb-info thumb-info-alt">';	 
		        }
		        $output .= '<i class="ss-view"></i>';
		        $output .= '</figcaption>';
	        } else { 
	        	$output .= "\n\t\t\t".$img['thumbnail'];
	        }
	        $output .= '</figure>';
	        $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
	        $output .= "\n\t".'</div> '.$this->endBlockComment($width);
	
	        //
	        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
	        return $output;
	    }
	
	    public function singleParamHtmlHolder($param, $value) {
	        $output = '';
	        // Compatibility fixes
	        $old_names = array('yellow_message', 'blue_message', 'green_message', 'button_green', 'button_grey', 'button_yellow', 'button_blue', 'button_red', 'button_orange');
	        $new_names = array('alert-block', 'alert-info', 'alert-success', 'btn-success', 'btn', 'btn-info', 'btn-primary', 'btn-danger', 'btn-warning');
	        $value = str_ireplace($old_names, $new_names, $value);
	        //$value = __($value, "coo-page-builder");
	        //
	        $param_name = isset($param['param_name']) ? $param['param_name'] : '';
	        $type = isset($param['type']) ? $param['type'] : '';
	        $class = isset($param['class']) ? $param['class'] : '';
	
	        if ( isset($param['holder']) == false || $param['holder'] == 'hidden' ) {
	            $output .= '<input type="hidden" class="spb_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.$value.'" />';
	            if(($param['type'])=='attach_image') {
	                $img = spb_getImageBySize(array( 'attach_id' => (int)preg_replace('/[^\d]/', '', $value), 'thumb_size' => 'thumbnail' ));
	                $output .= ( $img ? $img['thumbnail'] : '<img width="150" height="150" src="' . CooPageBuilder::getInstance()->assetURL('img/blank_f7.gif') . '" class="attachment-thumbnail" alt="" title="" />') . '<a href="#" class="column_edit_trigger' . ( $img && !empty($img['p_img_large'][0]) ? ' image-exists' : '' ) . '"><i class="spb-icon-single-image"></i>' . __( 'No image yet! Click here to select it now.', 'coo-page-builder' ) . '</a>';
	            }
	        }
	        else {
	            $output .= '<'.$param['holder'].' class="spb_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">'.$value.'</'.$param['holder'].'>';
	        }
	        return $output;
	    }
	}
	
	SPBMap::map( 'spb_single_image', array(
		"name"		=> __("Image", "coo-page-builder"),
		"base"		=> "spb_single_image",
		"class"		=> "spb_single_image_widget",
		"icon"		=> "spb-icon-single-image",
	    "params"	=> array(
			array(
				"type" => "attach_image",
				"heading" => __("Image", "coo-page-builder"),
				"param_name" => "image",
				"value" => "",
				"description" => ""
			),
			array(
			    "type" => "dropdown",
			    "heading" => __("Image Size", "coo-page-builder"),
			    "param_name" => "image_size",
			    "value" => array(__("Full", "coo-page-builder") => "full", __("Large", "coo-page-builder") => "large", __("Medium", "coo-page-builder") => "medium", __("Thumbnail", "coo-page-builder") => "thumbnail"),
			    "description" => __("Select the source size for the image (NOTE: this doesn't affect it's size on the front-end, only the quality).", "coo-page-builder")
			),
			array(
			    "type" => "dropdown",
			    "heading" => __("Image Frame", "coo-page-builder"),
			    "param_name" => "frame",
			    "value" => array(__("No Frame", "coo-page-builder") => "noframe", __("Border Frame", "coo-page-builder") => "borderframe", __("Glow Frame", "coo-page-builder") => "glowframe", __("Shadow Frame", "coo-page-builder") => "shadowframe"),
			    "description" => __("Select a frame for the image.", "coo-page-builder")
			),
			array(
			    "type" => "dropdown",
			    "heading" => __("Intro Animation", "coo-page-builder"),
			    "param_name" => "intro_animation",
			    "value" => array(
			    			__("None", "coo-page-builder") => "none",
			    			__("Fade In", "coo-page-builder") => "fade-in",
			    			__("Fade From Left", "coo-page-builder") => "fade-from-left",
			    			__("Fade From Right", "coo-page-builder") => "fade-from-right",
			    			__("Fade From Bottom", "coo-page-builder") => "fade-from-bottom",
			    			__("Move Up", "coo-page-builder") => "move-up",
			    			__("Grow", "coo-page-builder") => "grow",
			    			__("Fly", "coo-page-builder") => "fly",
			    			__("Helix", "coo-page-builder") => "helix",
			    			__("Flip", "coo-page-builder") => "flip",
			    			__("Pop Up", "coo-page-builder") => "pop-up",
			    			__("Spin", "coo-page-builder") => "spin",
			    			__("Flip X", "coo-page-builder") => "flip-x",
			    			__("Flip Y", "coo-page-builder") => "flip-y"
			    			),
			    "description" => __("Select an intro animation for the image that will show it when it appears within the viewport.", "coo-page-builder")
			),
			array(
			    "type" => "dropdown",
			    "heading" => __("Full width", "coo-page-builder"),
			    "param_name" => "full_width",
			    "value" => array(__("No", "coo-page-builder") => "no", __("Yes", "coo-page-builder") => "yes"),
			    "description" => __("Select if you want the image to be the full width of the page. (Make sure the element width is 1/1 too).", "coo-page-builder")
			),
			array(
			    "type" => "dropdown",
			    "heading" => __("Enable lightbox link", "coo-page-builder"),
			    "param_name" => "lightbox",
			    "value" => array(__("Yes", "coo-page-builder") => "yes", __("No", "coo-page-builder") => "no"),
			    "description" => __("Select if you want the image to open in a lightbox on click", "coo-page-builder")
			),
			array(
			    "type" => "textfield",
			    "heading" => __("Add link to image", "coo-page-builder"),
			    "param_name" => "image_link",
			    "value" => "",
			    "description" => __("If you would like the image to link to a URL, then enter it here. NOTE: this will override the lightbox functionality if you have enabled it.", "coo-page-builder")
			),
			array(
			    "type" => "dropdown",
			    "heading" => __("Link opens in new window?", "coo-page-builder"),
			    "param_name" => "link_target",
			    "value" => array(__("Self", "coo-page-builder") => "_self", __("New Window", "coo-page-builder") => "_blank"),
			    "description" => __("Select if you want the link to open in a new window", "coo-page-builder")
			),
			array(
			    "type" => "textfield",
			    "heading" => __("Image Caption", "coo-page-builder"),
			    "param_name" => "caption",
			    "value" => "",
			    "description" => __("If you would like a caption to be shown below the image, add it here.", "coo-page-builder")
			),
			array(
			    "type" => "textfield",
			    "heading" => __("Extra class name", "coo-page-builder"),
			    "param_name" => "el_class",
			    "value" => "",
			    "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "coo-page-builder")
			)
	    )
	));
	
	
	/* GOOGLE MAPS ASSET
	================================================== */ 
	class CooPageBuilderShortcode_spb_gmaps extends CooPageBuilderShortcode {
	
	    protected function content( $atts, $content = null ) {
	
	        $title = $address = $size = $zoom = $color = $saturation = $pin_image = $type = $el_position = $width = $el_class = '';
	        extract(shortcode_atts(array(
	            'title' => '',
	            'address' => '',
	            'size' => 200,
	            'zoom' => 14,
	            'color' => '',
	            'saturation' => '',
	            'pin_image' => '',
	            'type' => 'm',
	            'fullscreen' => 'no',
	            'el_position' => '',
	            'width' => '1/1',
	            'el_class' => ''
	        ), $atts));
	        $output = '';
	
	        if ( $address == '' ) { return null; }
	
	        $el_class = $this->getExtraClass($el_class);
	        $width = spb_translateColumnWidthToSpan($width);
			
	        $size = str_replace(array( 'px', ' ' ), array( '', '' ), $size);
	                
	        $img_url = wp_get_attachment_image_src($pin_image, 'full');
			
			if ($fullscreen == "yes" && $width == "col-sm-12") {
			$output .= "\n\t".'<div class="spb_gmaps_widget fullscreen-map spb_content_element '.$width.$el_class.'">';	          
	        } else {
	        $output .= "\n\t".'<div class="spb_gmaps_widget spb_content_element '.$width.$el_class.'">';	          
	        }
	        $output .= "\n\t\t".'<div class="spb_wrapper">';
	        $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading"><span>'.$title.'</span></h3>' : '';
	        $output .= '<div class="spb_map_wrapper"><div class="map-canvas" style="width:100%;height:'.$size.'px;" data-address="'.$address.'" data-zoom="'.$zoom.'" data-maptype="'.$type.'" data-mapcolor="'.$color.'" data-mapsaturation="'.$saturation.'" data-pinimage="'.$img_url[0].'"></div></div>';
	        $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
	        $output .= "\n\t".'</div> '.$this->endBlockComment($width);
			if ($fullscreen != "yes") {
	        $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
	        }
	        global $ct_include_maps;
	        $ct_include_maps = true;
	        
	        return $output;
	    }
	}
	
	SPBMap::map( 'spb_gmaps',  array(
	    "name"		=> __("Google Map", "coo-page-builder"),
	    "base"		=> "spb_gmaps",
	    "class"		=> "",
		"icon"		=> "spb-icon-map-pin",
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
	            "heading" => __("Address", "coo-page-builder"),
	            "param_name" => "address",
	            "value" => "",
	            "description" => __('Enter the address that you would like to show on the map here, i.e. "Cupertino".', "coo-page-builder")
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Map Height", "coo-page-builder"),
	            "param_name" => "size",
	            "value" => "300",
	            "description" => __('Enter map height in pixels. Example: 300.', "coo-page-builder")
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Map Type", "coo-page-builder"),
	            "param_name" => "type",
	            "value" => array(__("Map", "coo-page-builder") => "ROADMAP", __("Satellite", "coo-page-builder") => "SATELLITE", __("Hybrid", "coo-page-builder") => "HYBRID", __("Terrain", "coo-page-builder") => "TERRAIN"),
	            "description" => __("Select map display type. NOTE, if you set a color below, then only the standard Map type will show.", "coo-page-builder")
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Map Zoom", "coo-page-builder"),
	            "param_name" => "zoom",
	            "value" => array(__("14 - Default", "coo-page-builder") => 14, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19, 20)
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Map Color", "coo-page-builder"),
	            "param_name" => "color",
	            "value" => "",
	            "description" => __('If you would like, you can enter a hex color here to style the map by changing the hue. Please provide the # as well, e.g. #ff9900', "coo-page-builder")
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Map Saturation", "coo-page-builder"),
	            "param_name" => "saturation",
	            "value" => array(__("Color", "coo-page-builder") => "color", __("Mono", "coo-page-builder") => "mono"),
	            "description" => __("Set whether you would like the map to be in color or mono (black/white).", "coo-page-builder")
	        ),
	        array(
	        	"type" => "attach_image",
	        	"heading" => __("Custom Map Pin", "coo-page-builder"),
	        	"param_name" => "pin_image",
	        	"value" => "",
	        	"description" => "Choose an image to use as the custom pin for the address on the map. Upload your custom map pin, the image size must be 150px x 75px."
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Fullscreen Display", "coo-page-builder"),
	            "param_name" => "fullscreen",
	            "value" => array(__("No", "coo-page-builder") => "no", __("Yes", "coo-page-builder") => "yes"),
	            "description" => __("If yes, the map will be displayed from screen edge to edge.", "coo-page-builder")
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