<?php

class CooPageBuilderShortcode_spb_parallax extends CooPageBuilderShortcode {

    protected function content( $atts, $content = null ) {

        $title = $el_position = $width = $el_class = '';
        extract(shortcode_atts(array(
            'title' => '',
            'parallax_type' => '',
            'bg_image' => '',
            'bg_video_mp4' => '',
            'bg_video_webm' => '',
            'bg_video_ogg' => '',
            'parallax_video_height' => 'video-height',
            'parallax_image_height' => 'content-height',
            'parallax_video_overlay' => 'none',
            'bg_type' => '',
            'alt_background' => 'none',
            'el_position' => '',
            'width' => '1/1',
            'el_class' => ''
        ), $atts));
        $output = '';

        $el_class = $this->getExtraClass($el_class);
        $width = spb_translateColumnWidthToSpan($width);
		        
        $img_url = wp_get_attachment_image_src($bg_image, 'full');
		
		if ($parallax_type == "video") {
			if ($img_url[0] != "") {
			$output .= "\n\t".'<div class="spb_parallax_asset ct-parallax ct-parallax-video parallax-'.$parallax_video_height.' spb_content_element bg-type-'.$bg_type.' '.$width.$el_class.' alt-bg '.$alt_background.'" style="background-image: url('.$img_url[0].');">';
			} else {
			$output .= "\n\t".'<div class="spb_parallax_asset ct-parallax ct-parallax-video parallax-'.$parallax_video_height.' spb_content_element bg-type-'.$bg_type.' '.$width.$el_class.' alt-bg '.$alt_background.'">';
			}
		} else {
			if ($img_url[0] != "") {
			$output .= "\n\t".'<div class="spb_parallax_asset ct-parallax parallax-'.$parallax_image_height.' spb_content_element bg-type-'.$bg_type.' '.$width.$el_class.' alt-bg '.$alt_background.'" style="background-image: url('.$img_url[0].');">';
			} else {
			$output .= "\n\t".'<div class="spb_parallax_asset ct-parallax parallax-'.$parallax_image_height.' spb_content_element bg-type-'.$bg_type.' '.$width.$el_class.' alt-bg '.$alt_background.'">';
			}	
		}
        $output .= "\n\t\t".'<div class="spb_content_wrapper">';
        $output .= ($title != '' ) ? "\n\t\t\t".'<div class="heading-wrap"><h3 class="spb-heading spb-center-heading"><span>'.$title.'</span></h3></div>' : '';
        $output .= "\n\t\t\t".do_shortcode($content);
        $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_content_wrapper');
        if ($parallax_type == "video") {
	        $output .= '<video class="parallax-video" poster="'.$img_url[0].'" preload="auto" autoplay loop="loop" muted="muted">';
	        if ($bg_video_mp4 != "") {
	        $output .= '<source src="'.$bg_video_mp4.'" type="video/mp4">';
	        }
	        if ($bg_video_webm != "") {
	        $output .= '<source src="'.$bg_video_webm.'" type="video/webm">';
	        }
	        if ($bg_video_ogg != "") {
	        $output .= '<source src="'.$bg_video_ogg.'" type="video/ogg">';
			}
	        $output .= '</video>';
	        $output .= '<div class="video-overlay overlay-'.$parallax_video_overlay.'"></div>';
        }
        $output .= "\n\t".'</div> '.$this->endBlockComment($width);
		
		$output = $this->startRow($el_position) . $output . $this->endRow($el_position);
		
        global $ct_include_parallax;
        $ct_include_parallax = true;
        
        return $output;
    }
}

SPBMap::map( 'spb_parallax',  array(
    "name"		=> __("Parallax", "coo-page-builder"),
    "base"		=> "spb_parallax",
    "class"		=> "",
	"icon"		=> "spb-icon-parallax",
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
            "type" => "dropdown",
            "heading" => __("Parallax Type", "coo-page-builder"),
            "param_name" => "parallax_type",
            "value" => array(
            			__("Image", "coo-page-builder") => "image",
            			__("Video", "coo-page-builder") => "video"
            			),
            "description" => __("Choose whether you want to use an image or video for the background of the parallax. This will decide what is used from the options below.", "coo-page-builder")
        ),
        array(
        	"type" => "attach_image",
        	"heading" => __("Background Image", "coo-page-builder"),
        	"param_name" => "bg_image",
        	"value" => "",
        	"description" => "Choose an image to use as the background for the parallax area."
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Background Type", "coo-page-builder"),
            "param_name" => "bg_type",
            "value" => array(
            			__("Cover", "coo-page-builder") => "cover",
            			__("Pattern", "coo-page-builder") => "pattern"
            			),
            "description" => __("If you're uploading an image that you want to spread across the whole asset, then choose cover. Else choose pattern for an image you want to repeat.", "coo-page-builder")
        ),
        array(
        	"type" => "textfield",
        	"heading" => __("Background Video (MP4)", "coo-page-builder"),
        	"param_name" => "bg_video_mp4",
        	"value" => "",
        	"description" => "Provide a video URL in MP4 format to use as the background for the parallax area. You can upload these videos through the WordPress media manager."
        ),
        array(
        	"type" => "textfield",
        	"heading" => __("Background Video (WebM)", "coo-page-builder"),
        	"param_name" => "bg_video_webm",
        	"value" => "",
        	"description" => "Provide a video URL in WebM format to use as the background for the parallax area. You can upload these videos through the WordPress media manager."
        ),
        array(
        	"type" => "textfield",
        	"heading" => __("Background Video (Ogg)", "coo-page-builder"),
        	"param_name" => "bg_video_ogg",
        	"value" => "",
        	"description" => "Provide a video URL in OGG format to use as the background for the parallax area. You can upload these videos through the WordPress media manager."
        ),
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "class" => "",
            "heading" => __("Parallax Content", "coo-page-builder"),
            "param_name" => "content",
            "value" => __("<p>This is a parallax text block. Click the edit button to change this text.</p>", "coo-page-builder"),
            "description" => __("Enter your content.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Parallax Video Height", "coo-page-builder"),
            "param_name" => "parallax_video_height",
            "value" => array(
            			__("Video Height", "coo-page-builder") => "video-height",
            			__("Content Height", "coo-page-builder") => "content-height"
            			),
            "description" => __("If you are using this as a video parallax asset, then please choose whether you'd like asset to sized based on the content height or the video height.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Parallax Video Overlay", "coo-page-builder"),
            "param_name" => "parallax_video_overlay",
            "value" => array(
            			__("None", "coo-page-builder") => "none",
            			__("Striped", "coo-page-builder") => "striped"
            			),
            "description" => __("If you would like an overlay to appear on top of the video, then you can select it here.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Parallax Image Height", "coo-page-builder"),
            "param_name" => "parallax_image_height",
            "value" => array(
            			__("Content Height", "coo-page-builder") => "content-height",
            			__("Window Height", "coo-page-builder") => "window-height"
            			),
            "description" => __("If you are using this as an image parallax asset, then please choose whether you'd like asset to sized based on the content height or the height of the viewport window.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show alt background", "coo-page-builder"),
            "param_name" => "alt_background",
            "value" => array(__("None", "coo-page-builder") => "none", __("Alt 1", "coo-page-builder") => "alt-one", __("Alt 2", "coo-page-builder") => "alt-two", __("Alt 3", "coo-page-builder") => "alt-three", __("Alt 4", "coo-page-builder") => "alt-four", __("Alt 5", "coo-page-builder") => "alt-five", __("Alt 6", "coo-page-builder") => "alt-six", __("Alt 7", "coo-page-builder") => "alt-seven", __("Alt 8", "coo-page-builder") => "alt-eight", __("Alt 9", "coo-page-builder") => "alt-nine", __("Alt 10", "coo-page-builder") => "alt-ten"),
            "description" => __("Show an alternative background around the asset. These can all be set in Theme Options > Asset Background Options. NOTE: This will only use the text color configuration, as the background is set in this asset.", "coo-page-builder")
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