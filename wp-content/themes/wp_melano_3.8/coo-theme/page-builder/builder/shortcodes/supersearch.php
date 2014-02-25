<?php

class CooPageBuilderShortcode_supersearch extends CooPageBuilderShortcode {

    protected function content($atts, $content = null) {

		   	$title = $width = $el_class = $output = $items = $el_position = '';
		
	        extract(shortcode_atts(array(
	        	'title' => '',
	        	'el_position' => '',
	        	'width' => '1/1',
	        	'el_class' => ''
	        ), $atts));
	        
	        
			/* PAGE BUILDER OUTPUT
			================================================== */ 
    		$width = spb_translateColumnWidthToSpan($width);
    		$el_class = $this->getExtraClass($el_class);
            
            if ($width == "col-sm-12") {
            $output .= "\n\t".'<div class="spb_supersearch_widget spb_content_element alt-bg '.$width.$el_class.'">';            
            } else {
            $output .= "\n\t".'<div class="spb_supersearch_widget spb_content_element '.$width.$el_class.'">';
            }
            $output .= "\n\t\t".'<div class="spb_wrapper supersearch-wrap">';
            $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading"><span>'.$title.'</span></h3>' : '';
            $output .= "\n\t\t\t".do_shortcode('[ct_supersearch]');
            $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
            $output .= "\n\t".'</div> '.$this->endBlockComment($width);
    
            $output = $this->startRow($el_position) . $output . $this->endRow($el_position);

            return $output;
		
    }
}

SPBMap::map( 'supersearch', array(
    "name"		=> __("Super Search", "coo-page-builder"),
    "base"		=> "supersearch",
    "class"		=> "spb_supersearch",
    "icon"      => "spb-icon-supersearch",
    "params"	=> array(
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