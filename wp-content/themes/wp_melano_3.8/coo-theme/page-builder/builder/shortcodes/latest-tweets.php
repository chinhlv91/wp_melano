<?php

class CooPageBuilderShortcode_latest_tweets extends CooPageBuilderShortcode {

    protected function content($atts, $content = null) {

		    $width = $tweets_count = $pb_margin_bottom = $pb_border_bottom = $pb_border_top = $el_class = $output = $items = $el_position = '';
		
	        extract(shortcode_atts(array(
	        	'el_position' => '',
	        	'tweets_count' => '1',
	        	'pb_margin_bottom' => 'no',
	        	'pb_border_bottom' => 'no',
	        	'pb_border_top' => 'no',
	        	'width' => '1/1',
	        	'twitter_username' => '',
	        	'el_class' => ''
	        ), $atts));
	        
	        if ($pb_margin_bottom == "yes") {
	        $el_class .= ' pb-margin-bottom';
	        }
	        if ($pb_border_bottom == "yes") {
	        $el_class .= ' pb-border-bottom';
	        }
	        if ($pb_border_top == "yes") {
	        $el_class .= ' pb-border-top';
	        }
	        	        
	        $tweet_output = ct_get_tweets($twitter_username, $tweets_count);
		    
    		$el_class = $this->getExtraClass($el_class);
            $width = spb_translateColumnWidthToSpan($width);
            
            $output .= "\n\t".'<div class="spb_latest_tweets_widget '.$width.$el_class.'">';
            $output .= "\n\t\t".'<div class="spb_wrapper latest-tweets-wrap clearfix">';
            $output .= "\n\t\t\t".'<div class="twitter-bird"><i class="fa-twitter"></i></div><ul class="tweet-wrap">'. $tweet_output ."</ul>";
            $output .= "\n\t\t".'</div> '.$this->endBlockComment('.spb_wrapper');
            $output .= "\n\t".'</div> '.$this->endBlockComment($width);
    
            $output = $this->startRow($el_position) . $output . $this->endRow($el_position);
            return $output;
		
    }
}

SPBMap::map( 'latest_tweets', array(
    "name"		=> __("Latest Tweets", "coo-page-builder"),
    "base"		=> "latest_tweets",
    "class"		=> "spb-latest-tweets",
    "icon"      => "spb-icon-latest-tweets",
    "params"	=> array(
    	array(
    	    "type" => "textfield",
    	    "heading" => __("Twitter username", "coo-page-builder"),
    	    "param_name" => "twitter_username",
    	    "value" => "",
    	    "description" => __("The twitter username you'd like to show the latest tweet for. Make sure to not include the @.", "coo-page-builder")
    	),
    	array(
    	    "type" => "textfield",
    	    "heading" => __("Number of Tweets", "coo-page-builder"),
    	    "param_name" => "tweets_count",
    	    "value" => "1",
    	    "description" => __("The number of tweets you'd like to show.", "coo-page-builder")
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
    	    "type" => "dropdown",
    	    "heading" => __("Border above widget", "coo-page-builder"),
    	    "param_name" => "pb_border_top",
    	    "value" => array(__('No', "coo-page-builder") => "no", __('Yes', "coo-page-builder") => "yes"),
    	    "description" => __("Add a top border to the widget.", "coo-page-builder")
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