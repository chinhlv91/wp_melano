<?php

class CooPageBuilderShortcode_spb_products_mini extends CooPageBuilderShortcode {

    protected function content($atts, $content = null) {

		    $title = $asset_type = $width = $el_class = $output = $items = $el_position = '';
		
	        extract(shortcode_atts(array(
		        'title' => '',
		        'asset_type' => 'best-sellers',
	        	'item_count' => '4',
	        	'category' => '',
	        	'el_position' => '',
	        	'width' => '1/4',
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
    		    		
			/* PRODUCT ITEMS
			================================================== */	
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$items = ct_mini_product_items($asset_type, $category, $item_count, $sidebars, $width);
    		} else {
    		$items = __("Please install/active WooCommerce.", "coo-page-builder");
    		}
    		
    		$el_class = $this->getExtraClass($el_class);
            $width = spb_translateColumnWidthToSpan($width);
            
            $output .= "\n\t".'<div class="product_list_widget woocommerce spb_content_element '.$width.$el_class.'">';
            $output .= "\n\t\t".'<div class="spb_wrapper">';
            $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading"><span>'.$title.'</span></h3>' : '';
            $output .= "\n\t\t\t\t".$items;
            $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
            $output .= "\n\t".'</div> '.$this->endBlockComment($width);
    
            $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
            
            global $ct_has_products;
            $ct_has_products = true;
            
            return $output;
		
    }
}

SPBMap::map( 'spb_products_mini', array(
    "name"		=> __("Products (Mini)", "coo-page-builder"),
    "base"		=> "spb_products_mini",
    "class"		=> "spb-products-mini",
    "icon"      => "spb-icon-products-mini",
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
	        "heading" => __("Asset type", "coo-page-builder"),
	        "param_name" => "asset_type",
	        "value" => array(
	        	__('Best Sellers', "coo-page-builder") => "best-sellers",
	        	__('Latest Products', "coo-page-builder") => "latest-products",
	        	__('Top Rated', "coo-page-builder") => "top-rated",
	        	__('Sale Products', "coo-page-builder") => "sale-products",
	        	__('Recently Viewed', "coo-page-builder") => "recently-viewed",
	        	__('Featured Products', "coo-page-builder") => "featured-products"
	        	),
	        "description" => __("Select the order of the products you'd like to show.", "coo-page-builder")
	    ),
	    array(
	        "type" => "textfield",
	        "heading" => __("Product category", "coo-page-builder"),
	        "param_name" => "category",
	        "value" => "",
	        "description" => __("Optionally, provide the category slugs for the products you want to show (comma seperated). i.e. trainer,dress,bag.", "coo-page-builder")
	    ),
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __("Number of items", "coo-page-builder"),
            "param_name" => "item_count",
            "value" => "4",
            "description" => __("The number of products to show.", "coo-page-builder")
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


class CooPageBuilderShortcode_spb_products extends CooPageBuilderShortcode {

    protected function content($atts, $content = null) {

		    $title = $asset_type = $carousel = $product_size = $width = $sidebars = $el_class = $output = $items = $el_position = '';
		
	        extract(shortcode_atts(array(
		        'title' => '',
		        'asset_type' => 'best-sellers',
		        'carousel' => 'no',
		        'product_size' => 'standard',
	        	'item_count' => '8',
	        	'category' => '',
	        	'el_position' => '',
	        	'width' => '1/1',
	        	'el_class' => ''
	        ), $atts));
	        
	   	    		
			/* PRODUCT ITEMS
			================================================== */	
    		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$items = ct_product_items($asset_type, $category, $carousel, $product_size, $item_count, $width);
    		} else {
    		$items = __("Please install/active WooCommerce.", "coo-page-builder");
    		}
    		
    		$el_class = $this->getExtraClass($el_class);
            $width = spb_translateColumnWidthToSpan($width);
            
            $output .= "\n\t".'<div class="product_list_widget products-'.$product_size.' woocommerce spb_content_element '.$width.$el_class.'">';
            $output .= "\n\t\t".'<div class="spb_wrapper">';
            $output .= ($title != '' ) ? "\n\t\t\t".'<h3 class="spb-heading"><span>'.$title.'</span></h3>' : '';
            $output .= "\n\t\t\t\t".$items;
            $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
            $output .= "\n\t".'</div> '.$this->endBlockComment($width);
    
            $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
            
            if ($carousel == "yes") {
            	global $ct_include_carousel;
            	$ct_include_carousel = true;
            	
            }
            global $ct_include_isotope, $ct_has_products;
            $ct_include_isotope = true;
            $ct_has_products = true;

            return $output;
		
    }
}

SPBMap::map( 'spb_products', array(
    "name"		=> __("Products", "coo-page-builder"),
    "base"		=> "spb_products",
    "class"		=> "spb-products",
    "icon"      => "spb-icon-products",
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
	        "heading" => __("Asset type", "coo-page-builder"),
	        "param_name" => "asset_type",
	        "value" => array(
	        	__('Best Sellers', "coo-page-builder") => "best-sellers",
	        	__('Latest Products', "coo-page-builder") => "latest-products",
	        	__('Top Rated', "coo-page-builder") => "top-rated",
	        	__('Sale Products', "coo-page-builder") => "sale-products",
	        	__('Recently Viewed', "coo-page-builder") => "recently-viewed",
	        	__('Featured Products', "coo-page-builder") => "featured-products"
	        	),
	        "description" => __("Select the order of products you'd like to show.", "coo-page-builder")
	    ),
	    array(
	        "type" => "textfield",
	        "heading" => __("Product category", "coo-page-builder"),
	        "param_name" => "category",
	        "value" => "",
	        "description" => __("Optionally, provide the category slugs for the products you want to show (comma seperated). i.e. trainer,dress,bag.", "coo-page-builder")
	    ),
	    array(
	        "type" => "dropdown",
	        "heading" => __("Carousel", "coo-page-builder"),
	        "param_name" => "carousel",
	        "value" => array(
	        	__('Yes', "coo-page-builder") => "yes",
	        	__('No', "coo-page-builder") => "no",
	        	),
	        "description" => __("Select if you'd like the asset to be a carousel.", "coo-page-builder")
	    ),
	    array(
	        "type" => "dropdown",
	        "heading" => __("Product Size", "coo-page-builder"),
	        "param_name" => "product_size",
	        "value" => array(
	        	__('Standard', "coo-page-builder") => "standard",
	        	__('Mini', "coo-page-builder") => "mini",
	        	),
	        "description" => __("Select whether you would like the product size to be standard, or mini. Mini shows 6 products in a row on a page with no sidebars.", "coo-page-builder")
	    ),
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __("Number of items", "coo-page-builder"),
            "param_name" => "item_count",
            "value" => "8",
            "description" => __("The number of products to show.", "coo-page-builder")
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