<?php

class CooPageBuilderShortcode_portfolio extends CooPageBuilderShortcode {

    protected function content($atts, $content = null) {

		   	$title = $width = $el_class = $filter_output = $exclude_categories = $output = $tax_terms = $items = $el_position = '';
		
	        extract(shortcode_atts(array(
	        	'title' => '',
	        	'display_type' => 'standard',
	        	'columns'		=> '4',
	        	'show_title'	=> 'yes',
	        	'show_subtitle'	=> 'yes',
	        	'show_excerpt'	=> 'no',
	        	'show_it_love'	=> 'no',
	        	'hover_show_excerpt' => 'no',
	        	"excerpt_length" => '20',
	        	'item_count'	=> '-1',
	        	'category'		=> '',
	        	"exclude_categories" => '',
	        	'portfolio_filter'		=> 'yes',
	        	'pagination'	=> 'no',
	        	'el_position' => '',
	        	'width' => '1/1',
	        	'el_class' => ''
	        ), $atts));
	        
	        
	        /* SIDEBAR CONFIG
	        ================================================== */ 
	        $sidebar_config = get_post_meta(get_the_ID(), 'ct_sidebar_config', true);
	        	        
	        $sidebars = '';
	        if (($sidebar_config == "left-sidebar") || ($sidebar_config == "right-sidebar")) {
	        $sidebars = 'one-sidebar';
	        } else if ($sidebar_config == "both-sidebars") {
	        $sidebars = 'both-sidebars';
	        } else {
	        $sidebars = 'no-sidebars';
	        }
	        
	        
	        /* PORTFOLIO FILTER
	        ================================================== */ 
	        if ($portfolio_filter == "yes" && $sidebars == "no-sidebars") {
	        	$filter_output = ct_portfolio_filter();
	        }
	        
	        
	        /* PORTFOLIO ITEMS
	        ================================================== */	        
	        $items = ct_portfolio_items($display_type, $columns, $show_title, $show_subtitle, $show_excerpt, $show_it_love, $hover_show_excerpt, $excerpt_length, $item_count, $category, $exclude_categories, $pagination, $sidebars);
	        
	        
			/* PAGE BUILDER OUTPUT
			================================================== */ 
    		$width = spb_translateColumnWidthToSpan($width);
    		$el_class = $this->getExtraClass($el_class);
            
            $output .= "\n\t".'<div class="spb_portfolio_widget spb_content_element '.$width.$el_class.'">';
            $output .= "\n\t\t".'<div class="spb_wrapper portfolio-wrap">';
            $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading mb0"><span>'.$title.'</span></h3><div class="spb_divider standard spb_content_element col-sm-12"><span class="short-line"></span></div>' : '';
            if ($filter_output != "") {
            $output .= "\n\t\t\t".$filter_output;
            }
            $output .= "\n\t\t\t".$items;
            $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
            $output .= "\n\t".'</div> '.$this->endBlockComment($width);
    
            $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
            
            global $ct_include_isotope;
            $ct_include_isotope = true;
            
            global $ct_has_portfolio;
            $ct_has_portfolio = true;

            return $output;
		
    }
}

SPBMap::map( 'portfolio', array(
    "name"		=> __("Portfolio", "coo-page-builder"),
    "base"		=> "portfolio",
    "class"		=> "spb_portfolio",
    "icon"      => "spb-icon-portfolio",
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
            "heading" => __("Display type", "coo-page-builder"),
            "param_name" => "display_type",
            "value" => array(__('Standard', "coo-page-builder") => "standard", __('Gallery', "coo-page-builder") => "gallery", __('Masonry', "coo-page-builder") => "masonry", __('Masonry Gallery', "coo-page-builder") => "masonry-gallery"),
            "description" => __("Select the type of portfolio you'd like to show.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Column count", "coo-page-builder"),
            "param_name" => "columns",
            "value" => array("4", "3", "2"),
            "description" => __("How many portfolio columns to display.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show title text", "coo-page-builder"),
            "param_name" => "show_title",
            "value" => array(__('Yes', "coo-page-builder") => "yes", __('No', "coo-page-builder") => "no"),
            "description" => __("Show the item title text. (Standard/Masonry only)", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show subtitle text", "coo-page-builder"),
            "param_name" => "show_subtitle",
            "value" => array(__('Yes', "coo-page-builder") => "yes", __('No', "coo-page-builder") => "no"),
            "description" => __("Show the item subtitle text. (Standard/Masonry only)", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show item excerpt", "coo-page-builder"),
            "param_name" => "show_excerpt",
            "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
            "description" => __("Show the item excerpt text. (Standard/Masonry only)", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Show It Love", "coo-page-builder"),
            "param_name" => "show_it_love",
            "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
            "description" => __("Show the It Love.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Excerpt Hover", "coo-page-builder"),
            "param_name" => "hover_show_excerpt",
            "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
            "description" => __("Show the item excerpt on hover, instead of the arrow button. (Gallery/Masonry Gallery only)", "coo-page-builder")
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
            "class" => "",
            "heading" => __("Number of items", "coo-page-builder"),
            "param_name" => "item_count",
            "value" => "12",
            "description" => __("The number of portfolio items to show per page. Leave blank to show ALL portfolio items.", "coo-page-builder")
        ),
        array(
            "type" => "select-multiple",
            "heading" => __("Portfolio category", "coo-page-builder"),
            "param_name" => "category",
            "value" => ct_get_category_list('portfolio-category'),
            "description" => __("Choose the category from which you'd like to show the portfolio items.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Filter", "coo-page-builder"),
            "param_name" => "portfolio_filter",
            "value" => array(__('Yes', "coo-page-builder") => "yes", __('No', "coo-page-builder") => "no"),
            "description" => __("Show the portfolio category filter above the items. NOTE: This is only available on a page with the no sidebar setup.", "coo-page-builder")
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Pagination", "coo-page-builder"),
            "param_name" => "pagination",
            "value" => array(__('Yes', "coo-page-builder") => "yes", __('No', "coo-page-builder") => "no"),
            "description" => __("Show portfolio pagination.", "coo-page-builder")
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