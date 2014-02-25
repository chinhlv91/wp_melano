<?php

/*
*
*	Coo Shortcodes & Generator Class
*	------------------------------------------------
*	Cootheme
* 	http://www.cootheme.com
*
*/


/* ==================================================

SHORTCODE GENERATOR SETUP

================================================== */

// Create TinyMCE's editor button & plugin for Cootheme Shortcodes
add_action('init', 'ct_sc_button');

function ct_sc_button() {
    if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
    {
        add_filter('mce_external_plugins', 'ct_add_tinymce_plugin');
        add_filter('mce_buttons', 'ct_register_shortcode_button');
    }
}

function ct_register_shortcode_button($button) {
    array_push($button, 'separator', 'cootheme_shortcodes' );
    return $button;
}

function ct_add_tinymce_plugin($plugins) {
    $plugins['cootheme_shortcodes'] = get_template_directory_uri() . '/coo-theme/ct-shortcodes/tinymce.editor.plugin.js';
    return $plugins;
}

function ct_custom_mce_styles( $init ) {
    $init['theme_advanced_buttons2_add_before'] = 'styleselect';
    //First, we define the styles we want to add in format 'Style Name' => 'css classes'
    $classes = array(
        __('Impact Text', 'coo-theme-admin')     => 'impact-text',
        __('Impact Text Large', 'coo-theme-admin')     => 'impact-text-large',
    );

    //Delimit styles by semicolon in format 'Title=classes;' so TinyMCE can use it
    if ( ! empty($settings['theme_advanced_styles']) )
    {
        $settings['theme_advanced_styles'] .= ';';
    }
    else
    {
        //If there's nothing defined yet, define it
        $settings['theme_advanced_styles'] = '';
    }

    //Loop through our newly defined classes and add them to TinyMCE
    $class_settings = '';
    foreach ( $classes as $name => $value )
    {
        $class_settings .= "{$name}={$value};";
    }

    //Add our new class settings to the TinyMCE $settings array
    $settings['theme_advanced_styles'] .= trim($class_settings, '; ');

    return $init;
}

add_filter('tiny_mce_before_init', 'ct_custom_mce_styles');

function ct_mce_css() {
    return get_template_directory_uri() . '/css/editor-style.css';
}

add_filter( 'mce_css', 'ct_mce_css' );



/* ==================================================

SHORTCODES OUTPUT

================================================== */


/* ALERT SHORTCODE
================================================== */

function ct_alert( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "type"			=> "info"
    ), $atts));
    return '<div class="alert '. $type .'">' . do_shortcode($content) . '</div>';
}
add_shortcode('alert', 'ct_alert');


/* BUTTON SHORTCODE
================================================== */

function ct_button($atts, $content = null) {
    extract(shortcode_atts(array(
        "size"			=> "standard",
        "colour"		=> "",
        "type"			=> "",
        "link" 			=> "#",
        "target"		=> '_self',
        "dropshadow"    => '',
        "icon"			=> '',
        "extraclass"   => ''
    ), $atts));

    $button_output = "";
    $button_class = 'ct-button '.$size.' '. $colour .' '. $type .' '. $extraclass;

    if ($dropshadow == "yes") {
        $button_class .= " dropshadow";
    }

    if ($type == "ct-icon-reveal" || $type == "ct-icon-stroke") {
        $button_output .= '<a class="'.$button_class.'" href="'.$link.'" target="'.$target.'">';
        $button_output .= '<i class="'.$icon.'"></i>';
        $button_output .= '<span class="text">'. do_shortcode($content) .'</span>';
        $button_output .= '</a>';
    } else {
        $button_output .= '<a class="'.$button_class.'" href="'.$link.'" target="'.$target.'"><span class="text">' . do_shortcode($content) . '</span></a>';
    }

    return $button_output;
}
add_shortcode('ct_button', 'ct_button');


/* ICON SHORTCODE
================================================== */

function ct_icon($atts, $content = null) {
    extract(shortcode_atts(array(
        "size"			=> "",
        "image"			=> "",
        "character"		=> "",
        "cont" 			=> "",
        "float" 		=> ""
    ), $atts));

    if (strlen($character) > 1) {
        $character = substr($character, 0, 1);
    }

    if ($cont == "yes") {
        if ($character != "") {
            return '<div class="ct-icon-cont cont-'.$size.' ct-icon-float-'.$float.'"><span class="ct-icon-character ct-icon ct-icon-'.$size.'">'.$character.'</span></div>';
        } else {
            return '<div class="ct-icon-cont cont-'.$size.' ct-icon-float-'.$float.'"><i class="'.$image.' ct-icon ct-icon-'.$size.'"></i></div>';
        }
    } else {
        if ($character != "") {
            return '<span class="ct-icon-character ct-icon ct-icon-float-'.$float.' ct-icon-'.$size.'">'.$character.'</span>';
        } else {
            return '<i class="'.$image.' ct-icon ct-icon-float-'.$float.' ct-icon-'.$size.'"></i>';
        }
    }
}
add_shortcode('icon', 'ct_icon');


/* ICON BOX SHORTCODE
================================================== */

function ct_iconbox($atts, $content = null) {
    extract(shortcode_atts(array(
        "type"			=> "",
        "image"			=> "",
        "character"		=> "",
        "title" 		=> "",
        "animation" 	=> "",
        "animation_delay"	=> ""
    ), $atts));

    $icon_box = "";

    if ($animation != "" && $type != "animated") {
        $icon_box .= '<div class="ct-icon-box ct-icon-box-'.$type.' ct-animation" data-animation="'.$animation.'" data-delay="'.$animation_delay.'">';
    } else {
        $icon_box .= '<div class="ct-icon-box ct-icon-box-'.$type.'">';
    }

    if ($type == "animated") {
        $icon_box .= '<div class="inner">';
        $icon_box .= '<div class="front">';
        $icon_box .= do_shortcode('[icon size="large" image="'.$image.'" character="'.$character.'" float="none" cont="no"]');
    }

    if ($type == "left-icon-alt") {
        $icon_box .= do_shortcode('[icon size="medium" image="'.$image.'" character="'.$character.'" float="none" cont="no"]');
    } else if ($type != "boxed-two" && $type != "boxed-four" && $type != "standard-title" && $type != "animated") {
        $icon_box .= do_shortcode('[icon size="small" image="'.$image.'" character="'.$character.'" float="none" cont="yes"]');
    }
    $icon_box .= '<div class="ct-icon-box-content-wrap clearfix">';

    if ($type == "boxed-two") {
        $icon_box .= do_shortcode('[icon size="medium" image="'.$image.'" character="'.$character.'" float="none" cont="no"]');
    }

    if ($type == "boxed-four" || $type == "standard-title") {
        if ($character != "") {
            $icon_box .= '<h3><span class="ct-icon-character">'.$character.'</span> '.$title.'</h3>';
        } else {
            $icon_box .= '<h3><i class="'.$image.'"></i> '.$title.'</h3>';
        }
    } else {
        $icon_box .= '<h3>'.$title.'</h3>';
    }
    if ($type != "animated") {
        $icon_box .= '<div class="ct-icon-box-content">'.do_shortcode($content).'</div>';
    }

    $icon_box .= '</div>';

    if ($type == "animated") {
        $icon_box .= '</div>';
        $icon_box .= '<div class="back"><table>';
        $icon_box .= '<tbody><tr>';
        $icon_box .= '<td>';
        $icon_box .= '<h3>'.$title.'</h3>';
        $icon_box .= '<div class="ct-icon-box-content">'.do_shortcode($content).'</div>';
        $icon_box .= '</td>';
        $icon_box .= '</tr>';
        $icon_box .= '</tbody></table></div>';
        $icon_box .= '</div>';
    }

    $icon_box .= '</div>';

    return $icon_box;

}
add_shortcode('ct_iconbox', 'ct_iconbox');


/* IMAGE BANNER SHORTCODE
================================================== */

function ct_imagebanner($atts, $content = null) {
    extract(shortcode_atts(array(
        "image"			=> "",
        "animation" 	=> "fade-in",
        "contentpos"	=> "center",
        "textalign"	=> "center",
        "extraclass"	=> ""
    ), $atts));

    $image_banner = "";

    $image_banner .= '<div class="ct-image-banner '.$extraclass.'">';

    $image_banner .= '<div class="image-banner-content ct-animation content-'.$contentpos.' text-'.$textalign.'" data-animation="'.$animation.'" data-delay="200">';
    $image_banner .= do_shortcode($content);
    $image_banner .= '</div>';

    $image_banner .= '<img src="'.$image.'" alt="" />';

    $image_banner .= '</div>';

    global $ct_has_imagebanner;
    $ct_has_imagebanner = true;

    return $image_banner;

}
add_shortcode('ct_imagebanner', 'ct_imagebanner');


/* COLUMN SHORTCODES
================================================== */

function ct_one_third( $atts, $content = null ) {
    return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'ct_one_third');

function ct_one_third_last( $atts, $content = null ) {
    return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_third_last', 'ct_one_third_last');

function ct_two_third( $atts, $content = null ) {
    return '<div class="two_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'ct_two_third');

function ct_two_third_last( $atts, $content = null ) {
    return '<div class="two_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_third_last', 'ct_two_third_last');

function ct_one_half( $atts, $content = null ) {
    return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'ct_one_half');

function ct_one_half_last( $atts, $content = null ) {
    return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_half_last', 'ct_one_half_last');

function ct_one_fourth( $atts, $content = null ) {
    return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'ct_one_fourth');

function ct_one_fourth_last( $atts, $content = null ) {
    return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fourth_last', 'ct_one_fourth_last');

function ct_three_fourth( $atts, $content = null ) {
    return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'ct_three_fourth');

function ct_three_fourth_last( $atts, $content = null ) {
    return '<div class="three_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fourth_last', 'ct_three_fourth_last');


/* TABLE SHORTCODES
================================================= */

function ct_table_wrap( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "type" => ''
    ), $atts));

    $output = '<table class="ct-table '.$type.'"><tbody>';
    $output .= do_shortcode($content) .'</tbody></table>';

    return $output;

}
add_shortcode('table', 'ct_table_wrap');

function ct_table_row( $atts, $content = null ) {

    $output = '<tr>';
    $output .= do_shortcode($content) .'</tr>';

    return $output;
}
add_shortcode('trow', 'ct_table_row');

function ct_table_column( $atts, $content = null ) {

    $output = '<td>';
    $output .= do_shortcode($content) .'</td>';

    return $output;
}
add_shortcode('tcol', 'ct_table_column');

function ct_table_head( $atts, $content = null ) {

    $output = '<th>';
    $output .= do_shortcode($content) .'</th>';

    return $output;
}
add_shortcode('thcol', 'ct_table_head');


/* PRICING TABLE SHORTCODES
================================================= */

function ct_pt_wrap( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "type" => '',
        "columns" => ''
    ), $atts));

    $output = '<div class="pricing-table-wrap '.$type.' columns-'. $columns .'">' . do_shortcode($content) .'</div>';
    return $output;

}
add_shortcode('pricing_table', 'ct_pt_wrap');

function ct_pt_column( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "highlight" => ''
    ), $atts));

    if ($highlight == "yes") {
        $output = '<div class="pricing-table-column column-highlight">' . do_shortcode($content) .'</div>';
    } else {
        $output = '<div class="pricing-table-column">' . do_shortcode($content) .'</div>';
    }

    return $output;
}
add_shortcode('pt_column', 'ct_pt_column');

function ct_pt_price( $atts, $content = null ) {

    $output = '<div class="pricing-table-price">' . do_shortcode($content) .'</div>';

    return $output;
}
add_shortcode('pt_price', 'ct_pt_price');

function ct_pt_package( $atts, $content = null ) {

    $output = '<div class="pricing-table-package">' . do_shortcode($content) .'</div>';

    return $output;
}
add_shortcode('pt_package', 'ct_pt_package');

function ct_pt_details( $atts, $content = null ) {

    $output = '<div class="pricing-table-details">' . do_shortcode($content) .'</div>';

    return $output;
}
add_shortcode('pt_details', 'ct_pt_details');

function ct_pt_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "link" 			=> "#",
        "target"		=> '_self'
    ), $atts));

    $output = '<br/>'.do_shortcode('[ct_button link="'.$link.'" target="'.$target.'" type="standard" colour="accent"]' . $content .'[/ct_button]');

    return $output;
}
add_shortcode('pt_button', 'ct_pt_button');


/* LABELLED PRICING TABLE SHORTCODES
================================================= */

function ct_lpt_wrap( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "columns" => ''
    ), $atts));

    $output = '<div class="pricing-table-wrap labelled-pricing-table columns-'. $columns .'">' . do_shortcode($content) .'</div>';
    return $output;

}
add_shortcode('labelled_pricing_table', 'ct_lpt_wrap');

function ct_lpt_label_column( $atts, $content = null ) {

    $output = '<div class="pricing-table-column label-column">' . do_shortcode($content) .'</div>';

    return $output;
}
add_shortcode('lpt_label_column', 'ct_lpt_label_column');

function ct_lpt_column( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "highlight" => ''
    ), $atts));

    if ($highlight == "yes") {
        $output = '<div class="pricing-table-column column-highlight">' . do_shortcode($content) .'</div>';
    } else {
        $output = '<div class="pricing-table-column">' . do_shortcode($content) .'</div>';
    }

    return $output;
}
add_shortcode('lpt_column', 'ct_lpt_column');

function ct_lpt_price( $atts, $content = null ) {

    $output = '<div class="pricing-table-price">' . do_shortcode($content) .'</div>';

    return $output;
}
add_shortcode('lpt_price', 'ct_lpt_price');

function ct_lpt_package( $atts, $content = null ) {

    $output = '<div class="pricing-table-package">' . do_shortcode($content) .'</div>';

    return $output;
}
add_shortcode('lpt_package', 'ct_pt_package');

function ct_lpt_row_label( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "alt" 			=> "",
    ), $atts));

    if ($alt == "yes") {
        $output = '<div class="pricing-table-label-row alt-row">' . do_shortcode($content) .'</div>';
    } else {
        $output = '<div class="pricing-table-label-row">' . do_shortcode($content) .'</div>';
    }

    return $output;
}
add_shortcode('lpt_row_label', 'ct_lpt_row_label');

function ct_lpt_row( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "alt" 			=> "",
    ), $atts));

    if ($alt == "yes") {
        $output = '<div class="pricing-table-row alt-row">' . do_shortcode($content) .'</div>';
    } else {
        $output = '<div class="pricing-table-row">' . do_shortcode($content) .'</div>';
    }

    return $output;
}
add_shortcode('lpt_row', 'ct_lpt_row');

function ct_lpt_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "link" 			=> "#",
        "target"		=> '_self'
    ), $atts));

    $output = '<div class="lpt-button-wrap">'.do_shortcode('[ct_button link="'.$link.'" target="'.$target.'" type="standard" colour="accent"]' . $content .'[/ct_button]</div>');

    return $output;
}
add_shortcode('lpt_button', 'ct_lpt_button');


/* TYPOGRAPHY SHORTCODES
================================================= */

// Highlight Text
function ct_highlighted($atts, $content = null) {
    return '<span class="highlighted">'. do_shortcode($content) .'</span>';
}
add_shortcode("highlight", "ct_highlighted");

// Decorative Ampersand
function ct_decorative_ampersand($atts, $content = null) {
    return '<span class="decorative-ampersand">&</span>';
}
add_shortcode("decorative_ampersand", "ct_decorative_ampersand");

// Dropcap type 1
function ct_dropcap1($atts, $content = null) {
    return '<span class="dropcap1">'. do_shortcode($content) .'</span>';
}
add_shortcode("dropcap1", "ct_dropcap1");

// Dropcap type 2
function ct_dropcap2($atts, $content = null) {
    return '<span class="dropcap2">'. do_shortcode($content) .'</span>';
}
add_shortcode("dropcap2", "ct_dropcap2");

// Dropcap type 3
function ct_dropcap3($atts, $content = null) {
    return '<span class="dropcap3">'. do_shortcode($content) .'</span>';
}
add_shortcode("dropcap3", "ct_dropcap3");

// Dropcap type 4
function ct_dropcap4($atts, $content = null) {
    return '<span class="dropcap4">'. do_shortcode($content) .'</span>';
}
add_shortcode("dropcap4", "ct_dropcap4");

// Blockquote type 1
function ct_blockquote1($atts, $content = null) {
    return '<blockquote class="blockquote1">'. do_shortcode($content) .'</blockquote>';
}
add_shortcode("blockquote1", "ct_blockquote1");

// Blockquote type 2
function ct_blockquote2($atts, $content = null) {
    return '<blockquote class="blockquote2">'. do_shortcode($content) .'</blockquote>';
}
add_shortcode("blockquote2", "ct_blockquote2");

// Blockquote type 3
function ct_blockquote3($atts, $content = null) {
    return '<blockquote class="blockquote3">'. do_shortcode($content) .'</blockquote>';
}
add_shortcode("blockquote3", "ct_blockquote3");

// Blockquote type 4
function ct_pullquote($atts, $content = null) {
    return '<blockquote class="pullquote">'. do_shortcode($content) .'</blockquote>';
}
add_shortcode("pullquote", "ct_pullquote");


/* LISTS SHORTCODES
================================================= */

function ct_list( $atts, $content = null ) {
    $output = '<ul class="ct-list">' . do_shortcode($content) .'</ul>';
    return $output;
}
add_shortcode('list', 'ct_list');

function ct_list_item( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "icon" => ''
    ), $atts));
    $output = '<li><i class="'.$icon.'"></i><span>' . do_shortcode($content) .'</span></li>';
    return $output;
}
add_shortcode('list_item', 'ct_list_item');


/* DIVIDER SHORTCODE
================================================= */

function ct_horizontal_break($atts, $content = null) {
    return '<div class="horizontal-break"> </div>';
}
add_shortcode("hr", "ct_horizontal_break");


/* SOCIAL SHORTCODE
================================================= */

function ct_social_icons($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => '',
        "size" => 'standard',
        "style" => ''
    ), $atts));

    $options = get_option('ct_coo_options');

    $twitter = $options['twitter_username'];
    $facebook = $options['facebook_page_url'];
    $dribbble = $options['dribbble_username'];
    $vimeo = $options['vimeo_username'];
    $tumblr = $options['tumblr_username'];
    $skype = $options['skype_username'];
    $linkedin = $options['linkedin_page_url'];
    $googleplus = $options['googleplus_page_url'];
    $flickr = $options['flickr_page_url'];
    $youtube = $options['youtube_url'];
    $pinterest = $options['pinterest_username'];
    $foursquare = $options['foursquare_url'];
    $instagram = $options['instagram_username'];
    $github = $options['github_url'];
    $xing = $options['xing_url'];

    $social_icons = '';

    if ($type == '') {
        if ($twitter) {
            $social_icons .= '<li class="twitter"><a href="http://www.twitter.com/'.$twitter.'" target="_blank"><i class="fa-twitter"></i><i class="fa-twitter"></i></a></li>'."\n";
        }
        if ($facebook) {
            $social_icons .= '<li class="facebook"><a href="'.$facebook.'" target="_blank"><i class="fa-facebook"></i><i class="fa-facebook"></i></a></li>'."\n";
        }
        if ($dribbble) {
            $social_icons .= '<li class="dribbble"><a href="http://www.dribbble.com/'.$dribbble.'" target="_blank"><i class="fa-dribbble"></i><i class="fa-dribbble"></i></a></li>'."\n";
        }
        if ($youtube) {
            $social_icons .= '<li class="youtube"><a href="'.$youtube.'" target="_blank"><i class="fa-youtube"></i><i class="fa-youtube"></i></a></li>'."\n";
        }
        if ($vimeo) {
            $social_icons .= '<li class="vimeo"><a href="http://www.vimeo.com/'.$vimeo.'" target="_blank"><i class="fa-vimeo-square"></i><i class="fa-vimeo-square"></i></a></li>'."\n";
        }
        if ($tumblr) {
            $social_icons .= '<li class="tumblr"><a href="http://'.$tumblr.'.tumblr.com/" target="_blank"><i class="fa-tumblr"></i><i class="fa-tumblr"></i></a></li>'."\n";
        }
        if ($skype) {
            $social_icons .= '<li class="skype"><a href="skype:'.$skype.'" target="_blank"><i class="fa-skype"></i><i class="fa-skype"></i></a></li>'."\n";
        }
        if ($linkedin) {
            $social_icons .= '<li class="linkedin"><a href="'.$linkedin.'" target="_blank"><i class="fa-linkedin"></i><i class="fa-linkedin"></i></a></li>'."\n";
        }
        if ($googleplus) {
            $social_icons .= '<li class="googleplus"><a href="'.$googleplus.'" target="_blank"><i class="fa-google-plus"></i><i class="fa-google-plus"></i></a></li>'."\n";
        }
        if ($flickr) {
            $social_icons .= '<li class="flickr"><a href="'.$flickr.'" target="_blank"><i class="fa-flickr"></i><i class="fa-flickr"></i></a></li>'."\n";
        }
        if ($pinterest) {
            $social_icons .= '<li class="pinterest"><a href="http://www.pinterest.com/'.$pinterest.'/" target="_blank"><i class="fa-pinterest"></i><i class="fa-pinterest"></i></a></li>'."\n";
        }
        if ($foursquare) {
            $social_icons .= '<li class="foursquare"><a href="'.$foursquare.'" target="_blank"><i class="fa-foursquare"></i><i class="fa-foursquare"></i></a></li>'."\n";
        }
        if ($instagram) {
            $social_icons .= '<li class="instagram"><a href="http://instagram.com/'.$instagram.'" target="_blank"><i class="fa-instagram"></i><i class="fa-instagram"></i></a></li>'."\n";
        }
        if ($github) {
            $social_icons .= '<li class="github"><a href="'.$github.'" target="_blank"><i class="fa-github"></i><i class="fa-github"></i></a></li>'."\n";
        }
        if ($xing) {
            $social_icons .= '<li class="xing"><a href="'.$xing.'" target="_blank"><i class="fa-xing"></i><i class="fa-xing"></i></a></li>'."\n";
        }
    } else {

        $social_type = explode(',', $type);
        foreach ($social_type as $id) {
            if ($id == "twitter") {
                $social_icons .= '<li class="twitter"><a href="http://www.twitter.com/'.$twitter.'" target="_blank"><i class="fa-twitter"></i><i class="fa-twitter"></i></a></li>'."\n";
            }
            if ($id == "facebook") {
                $social_icons .= '<li class="facebook"><a href="'.$facebook.'" target="_blank"><i class="fa-facebook"></i><i class="fa-facebook"></i></a></li>'."\n";
            }
            if ($id == "dribbble") {
                $social_icons .= '<li class="dribbble"><a href="http://www.dribbble.com/'.$dribbble.'" target="_blank"><i class="fa-dribbble"></i><i class="fa-dribbble"></i></a></li>'."\n";
            }
            if ($id == "youtube") {
                $social_icons .= '<li class="youtube"><a href="'.$youtube.'" target="_blank"><i class="fa-youtube"></i><i class="fa-youtube"></i></a></li>'."\n";
            }
            if ($id == "vimeo") {
                $social_icons .= '<li class="vimeo"><a href="http://www.vimeo.com/'.$vimeo.'" target="_blank"><i class="fa-vimeo-square"></i><i class="fa-vimeo-square"></i></a></li>'."\n";
            }
            if ($id == "tumblr") {
                $social_icons .= '<li class="tumblr"><a href="http://'.$tumblr.'.tumblr.com/" target="_blank"><i class="fa-tumblr"></i><i class="fa-tumblr"></i></a></li>'."\n";
            }
            if ($id == "skype") {
                $social_icons .= '<li class="skype"><a href="skype:'.$skype.'" target="_blank"><i class="fa-skype"></i><i class="fa-skype"></i></a></li>'."\n";
            }
            if ($id == "linkedin") {
                $social_icons .= '<li class="linkedin"><a href="'.$linkedin.'" target="_blank"><i class="fa-linkedin"></i><i class="fa-linkedin"></i></a></li>'."\n";
            }
            if ($id == "googleplus" || $id == "google-plus" || $id == "google+") {
                $social_icons .= '<li class="googleplus"><a href="'.$googleplus.'" target="_blank"><i class="fa-google-plus"></i><i class="fa-google-plus"></i></a></li>'."\n";
            }
            if ($id == "flickr") {
                $social_icons .= '<li class="flickr"><a href="'.$flickr.'" target="_blank"><i class="fa-flickr"></i><i class="fa-flickr"></i></a></li>'."\n";
            }
            if ($id == "pinterest") {
                $social_icons .= '<li class="pinterest"><a href="http://www.pinterest.com/'.$pinterest.'/" target="_blank"><i class="fa-pinterest"></i><i class="fa-pinterest"></i></a></li>'."\n";
            }
            if ($id == "foursquare") {
                $social_icons .= '<li class="foursquare"><a href="'.$foursquare.'" target="_blank"><i class="fa-foursquare"></i><i class="fa-foursquare"></i></a></li>'."\n";
            }
            if ($id == "instagram") {
                $social_icons .= '<li class="instagram"><a href="http://instagram.com/'.$instagram.'" target="_blank"><i class="fa-instagram"></i><i class="fa-instagram"></i></a></li>'."\n";
            }
            if ($id == "github") {
                $social_icons .= '<li class="github"><a href="'.$github.'" target="_blank"><i class="fa-github"></i><i class="fa-github"></i></a></li>'."\n";
            }
            if ($id == "xing") {
                $social_icons .= '<li class="xing"><a href="'.$xing.'" target="_blank"><i class="fa-xing"></i><i class="fa-xing"></i></a></li>'."\n";
            }
        }
    }

    $output = '<ul class="social-icons '.$size.' '.$style.'">'."\n";
    $output .= $social_icons;
    $output .= '</ul>'."\n";

    return $output;
}
add_shortcode("social", "ct_social_icons");


/* SITEMAP SHORTCODE
================================================= */

function ct_sitemap($params = array()) {
    // default parameters
    extract(shortcode_atts(array(
        'title' => 'Site map',
        'id' => 'sitemap',
        'depth' => 2
    ), $params));
    // create sitemap

    $sitemap = '<div class="sitemap-wrap clearfix">';

    $sitemap .= '<div class="sitemap-col">';

    $sitemap .= '<h3>'.__("Pages", "cootheme").'</h3>';

    $page_list = wp_list_pages("title_li=&depth=$depth&sort_column=menu_order&echo=0");
    if ($page_list != '') {
        $sitemap .= '<ul>'.$page_list.'</ul>';
    }

    $sitemap .= '</div>';

    $sitemap .= '<div class="sitemap-col">';

    $sitemap .= '<h3>'.__("Posts", "cootheme").'</h3>';

    $post_list = wp_get_archives('type=postbypost&limit=20&echo=0');
    if ($post_list != '') {
        $sitemap .= '<ul>'.$post_list.'</ul>';
    }

    $sitemap .= '</div>';

    $sitemap .= '<div class="sitemap-col">';

    $sitemap .= '<h3>'.__("Categories", "cootheme").'</h3>';

    $category_list = wp_list_categories('sort_column=name&title_li=&depth=1&number=10&echo=0');
    if ($category_list != '') {
        $sitemap .= '<ul>'.$category_list.'</ul>';
    }

    $sitemap .= '<h3>'.__("Archives", "cootheme").'</h3>';

    $archive_list =  wp_get_archives('type=monthly&limit=12&echo=0');
    if ($archive_list != '') {
        $sitemap .= '<ul>'.$archive_list.'</ul>';
    }

    $sitemap .= '</div>';

    $sitemap .= '</div>';

    return $sitemap;

}
add_shortcode('ct_sitemap', 'ct_sitemap');


/* SERVICES PROGRESS BAR SHORTCODE
================================================= */

function ct_progress_bar($atts) {
    extract(shortcode_atts(array(
        "percentage" => '',
        "name" => '',
        "type" => '',
        "value" => '',
        "colour" => ''
    ), $atts));

    if ($type == "") { $type = "standard"; }

    $service_bar_output = '';

    $service_bar_output .= '<div class="progress-bar-wrap progress-'.$type.'">'. "\n";
    if ($colour != "") {
        $service_bar_output .= '<div class="bar-text"><span class="bar-name">'.$name.':</span> <span class="progress-value" style="color:'.$colour.'!important;">'.$value.'</span></div>'. "\n";
        $service_bar_output .= '<div class="progress '.$type.'">'. "\n";
        $service_bar_output .= '<div class="bar" data-value="'.$percentage.'" style="background-color:'.$colour.'!important;">'. "\n";
    } else {
        $service_bar_output .= '<div class="bar-text"><span class="bar-name">'.$name.':</span> <span class="progress-value">'.$value.'</span></div>'. "\n";
        $service_bar_output .= '<div class="progress '.$type.'">'. "\n";
        $service_bar_output .= '<div class="bar" data-value="'.$percentage.'">'. "\n";
    }
    $service_bar_output .= '</div>'. "\n";
    $service_bar_output .= '</div>'. "\n";
    $service_bar_output .= '</div>'. "\n";

    global $ct_has_progress_bar;
    $ct_has_progress_bar = true;

    return $service_bar_output;
}

add_shortcode('progress_bar', 'ct_progress_bar');


/* CHART SHORTCODE
================================================= */

function ct_chart($atts) {
    extract(shortcode_atts(array(
        "percentage" => '50',
        "size" => '70',
        "barcolour" => '',
        "trackcolour" => '',
        "content" => '',
        "align" => ''
    ), $atts));

    $chart_output = $linewidth = '';

    if ($barcolour == "") { $barcolour = get_option('accent_color', '#fb3c2d'); }
    if ($trackcolour == "") { $trackcolour = '#f2f2f2'; }

    if ($size == "70") { $linewidth = "5"; }
    if ($size == "170") { $linewidth = "5"; }

    $chart_output .= '<div class="chart-shortcode chart-'.$size.' chart-'.$align.'" data-linewidth="'.$linewidth.'" data-percent="0" data-animatepercent="'.$percentage.'" data-size="'.$size.'" data-barcolor="'.$barcolour.'" data-trackcolor="'.$trackcolour.'">';
    if ($content != "") {
        if (strpos($content, 'fa-') !== false || strpos($content, 'ss-') !== false) {
            $chart_output .= '<span><i class="'.$content.'"></i></span>';
        } else {
            $chart_output .= '<span>'.$content.'</span>';
        }
    }
    $chart_output .= '</div>';

    global $ct_has_chart;
    $ct_has_chart = true;

    return $chart_output;
}

add_shortcode('chart', 'ct_chart');


/* TOOLTIP SHORTCODE
================================================= */

function ct_tooltip($atts, $content = null) {
    extract(shortcode_atts(array(
        "title" => '',
        "link" => '#',
        "direction" => 'top'
    ), $atts));

    $tooltip_output = '<a href="'.$link.'" rel="tooltip" data-original-title="'.$title.'" data-placement="'.$direction.'">'.do_shortcode($content).'</a>';

    return $tooltip_output;
}

add_shortcode('ct_tooltip', 'ct_tooltip');


/* MODAL SHORTCODE
================================================= */

function ct_modal($atts, $content = null) {
    extract(shortcode_atts(array(
        "header" => '',
        "btn_type" => '',
        "btn_colour" => '',
        "btn_size" => '',
        "btn_icon" => '',
        "btn_text" => ''
    ), $atts));

    global $ct_modalCount;

    if ($ct_modalCount >= 0) {
        $ct_modalCount++;
    } else {
        $ct_modalCount = 0;
    }

    $modal_output = "";

    $button_class = 'ct-button '.$btn_size.' '. $btn_colour .' '. $btn_type;

    if ($btn_type == "ct-icon-reveal" || $btn_type == "ct-icon-stroke") {
        $modal_output .= '<a class="'.$button_class.'" href="#modal-'.$ct_modalCount.'" role="button" data-toggle="modal">';
        $modal_output .= '<i class="'.$btn_icon.'"></i>';
        $modal_output .= '<span class="text">'. $btn_text .'</span>';
        $modal_output .= '</a>';
    } else {
        $modal_output .= '<a class="'.$button_class.'" href="#modal-'.$ct_modalCount.'" role="button" data-toggle="modal"><span class="text">' . $btn_text . '</span></a>';
    }

    $modal_output .= '<div id="modal-'.$ct_modalCount.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="'.$header.'" aria-hidden="true">';
    $modal_output .= '<div class="modal-dialog">';
    $modal_output .= '<div class="modal-content">';
    $modal_output .= '<div class="modal-header">';
    $modal_output .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ss-delete"></i></button>';
    $modal_output .= '<h3 id="modal-label">'.$header.'</h3>';
    $modal_output .= '</div>';
    $modal_output .= '<div class="modal-body">'.do_shortcode($content).'</div>';
    $modal_output .= '</div>';
    $modal_output .= '</div>';
    $modal_output .= '</div>';

    return $modal_output;
}

add_shortcode('ct_modal', 'ct_modal');


/* FULLSCREEN VIDEO SHORTCODE
================================================= */

function ct_fullscreen_video($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => '',
        "imageurl" => '',
        "btntext" => '',
        "videourl" => '',
        "extraclass" => ''
    ), $atts));

    $fw_video_output = "";

    $video_embed_url = ct_get_embed_src($videourl);

    if ($type == "image-button") {

        $fw_video_output .= '<a href="#" class="fw-video-link fw-video-link-image '.$extraclass.'" data-video="'.$video_embed_url.'">';

        $fw_video_output .= '<i class="ss-play"></i>';

        $fw_video_output .= '<img src="'.$imageurl.'" alt="'.$btntext.'" />';

        $fw_video_output .= '</a>';

    } else if ($type == "text-button") {

        $fw_video_output .= '<a href="#" class="fw-video-link fw-video-link-text ct-button ct-icon-stroke accent '.$extraclass.'" data-video="'.$video_embed_url.'">';

        $fw_video_output .= '<i class="ss-play"></i>';
        $fw_video_output .= '<span class="text">'.$btntext.'</span>';

        $fw_video_output .= '</a>';

    } else {

        $fw_video_output .= '<a href="#" class="fw-video-link fw-video-link-icon '.$extraclass.'" data-video="'.$video_embed_url.'">';

        $fw_video_output .= '<i class="ss-play"></i>';

        $fw_video_output .= '</a>';
    }

    return $fw_video_output;
}

add_shortcode('ct_fullscreenvideo', 'ct_fullscreen_video');


/* RESPONSIVE VISIBILITY SHORTCODE
================================================= */

function ct_visibility($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
    ), $atts));

    $visibility_output = '<div class="'.$class.'">'.do_shortcode($content).'</div>';

    return $visibility_output;
}

add_shortcode('ct_visibility', 'ct_visibility');


/* YEAR SHORTCODE
================================================= */

function ct_year_shortcode() {
    $year = date('Y');
    return $year;
}

add_shortcode('the-year', 'ct_year_shortcode');


/* WORDPRESS LINK SHORTCODE
================================================= */

function ct_wordpress_link() {
    return '<a href="http://wordpress.org/" target="_blank">WordPress</a>';
}

add_shortcode('wp-link', 'ct_wordpress_link');


/* COUNT SHORTCODE
================================================= */

function ct_count($atts) {
    extract(shortcode_atts(array(
        "speed" => '2000',
        "refresh" => '25',
        "from" => '0',
        "to" => '',
        "subject" => '',
        "textstyle" => ''
    ), $atts));

    $count_output = '';

    if ($speed == "") {$speed = '2000'; }
    if ($refresh == "") {$refresh = '25'; }

    $count_output .= '<div class="ct-count-asset">';
    $count_output .= '<div class="count-number" data-from="'.$from.'" data-to="'.$to.'" data-speed="'.$speed.'" data-refresh-interval="'.$refresh.'"></div>';
    $count_output .= '<div class="count-divider"><span></span></div>';
    if ($textstyle == "h3") {
        $count_output .= '<h3 class="count-subject">'.$subject.'</h3>';
    } else if ($textstyle == "h6") {
        $count_output .= '<h6 class="count-subject">'.$subject.'</h6>';
    } else {
        $count_output .= '<div class="count-subject">'.$subject.'</div>';
    }
    $count_output .= '</div>';

    return $count_output;
}

add_shortcode('ct_count', 'ct_count');


/* COUNTDOWN SHORTCODE
================================================= */

function ct_countdown($atts) {
    extract(shortcode_atts(array(
        "year" => '',
        "month" => '',
        "day" => '',
        "fontsize" => 'large',
        "displaytext" => ''
    ), $atts));

    $countdown_output = '';

    $countdown_output .= '<div class="ct-countdown text-'.$fontsize.'" data-year="'.$year.'" data-month="'.$month.'" data-day="'.$day.'"></div>';
    if ($displaytext != "") {
        $countdown_output .= '<h3 class="countdown-subject">'.$displaytext.'</h3>';
    }

    global $ct_has_countdown;
    $ct_has_countdown = true;

    return $countdown_output;
}

add_shortcode('ct_countdown', 'ct_countdown');


/* SOCIAL SHARE SHORTCODE
================================================= */

function ct_social_share() {

    global $post;

    $title = get_the_title();
    $permalink = get_permalink();
    $image = wp_get_attachment_url(get_post_thumbnail_id());
    $excerpt = strip_tags(get_the_excerpt());

    $share_output = "";

    $share_output .= '<div class="share-links curved-bar-styling clearfix">';
    $share_output .= '<div class="share-text">'.__("Share this:", "cootheme").'</div>';
    $share_output .= '<ul class="social-icons">';
    $share_output .= '<li class="facebook"><a href="http://www.facebook.com/sharer.php?u='.$permalink.'" class="post_share_facebook" onclick="javascript:window.open(this.href,
			      "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600");return false;"><i class="fa-facebook"></i><i class="fa-facebook"></i></a></li>';
    $share_output .= '<li class="twitter"><a href="https://twitter.com/share?url='.$permalink.'" onclick="javascript:window.open(this.href,
			      "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600");return false;" class="product_share_twitter"><i class="fa-twitter"></i><i class="fa-twitter"></i></a></li>  ';
    $share_output .= '<li class="googleplus"><a href="https://plus.google.com/share?url='.$permalink.'" onclick="javascript:window.open(this.href,
			      "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;"><i class="fa-google-plus"></i><i class="fa-google-plus"></i></a></li>';
    $share_output .= '<li class="pinterest"><a href="http://pinterest.com/pin/create/button/?url='.$permalink.'&media='.$image.'&description='.$title.'"><i class="fa-pinterest"></i><i class="fa-pinterest"></i></a></li>';
    $share_output .= '<li class="mail"><a href="mailto:?subject='.$title.'&body='.$excerpt.' '.$permalink.'" class="product_share_email"><i class="ss-mail"></i><i class="ss-mail"></i></a></li>';
    $share_output .= '</ul>';
    $share_output .= '</div>';

    return $share_output;
}

add_shortcode('ct_social_share', 'ct_social_share');


/* COO SUPER SEARCH SHORTCODE
================================================= */

function ct_supersearch() {

    return ct_super_search();

}
add_shortcode('ct_supersearch', 'ct_supersearch');



/* COO GALLERY SHORTCODE
================================================= */

// Remove built in shortcode
remove_shortcode('gallery', 'gallery_shortcode');

// Replace with custom shortcode
function ct_gallery($attr) {
    $post = get_post();

    static $instance = 0;
    $instance++;

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) ) {
            $attr['orderby'] = 'post__in';
            $attr['include'] = $attr['ids'];
        }
    }

    // Allow plugins/themes to override the default gallery template.
    $output = apply_filters('post_gallery', '', $attr);
    if ( $output != '' ) {
        return $output;
    }

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'large',
        'include'    => '',
        'exclude'    => ''
    ), $attr, 'gallery'));

    $id = intval($id);
    if ( 'RAND' == $order ) {
        $orderby = 'none';
    }

    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) ) {
        return '';
    }

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $icontag = tag_escape($icontag);
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) ) {
        $itemtag = 'dl';
    }
    if ( ! isset( $valid_tags[ $captiontag ] ) ) {
        $captiontag = 'dd';
    }
    if ( ! isset( $valid_tags[ $icontag ] ) ) {
        $icontag = 'dt';
    }

    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = '';
    $size_class = sanitize_html_class( $size );
    $output = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {

        $image_output = '<figure class="animated-overlay">';

        $image_file_url = wp_get_attachment_image_src( $id, $size );
        $image_file_lightbox_url = wp_get_attachment_url( $id, "full" );
        $image_caption = wptexturize($attachment->post_excerpt);
        $image_meta  = wp_get_attachment_metadata( $id );
        $image_alt = get_post_meta($id, '_wp_attachment_image_alt', true);

        $image_output .= '<img src="'.$image_file_url[0].'" alt="'.$image_alt.'" />';

        if ( ! empty( $attr['link'] ) && 'file' === $attr['link'] ) {
            $image_output .= '<a href="'.$image_file_lightbox_url.'" class="view" rel="'.$selector.'" title="'.$image_alt.'"></a>';
        } elseif ( ! empty( $attr['link'] ) && 'none' === $attr['link'] ) {
        } else {
            $image_output .= '<a href="'.get_attachment_link( $id ).'"></a>';
        }

        if ($captiontag && trim($attachment->post_excerpt) && $columns <= 3) {
            $image_output .= '<figcaption><div class="thumb-info">';
            $image_output .= '<h4 itemprop="name headline">'.wptexturize($attachment->post_excerpt).'</h4>';
        } else {
            $image_output .= '<figcaption><div class="thumb-info thumb-info-alt">';
        }

        $image_output .= '<i class="ss-search"></i>';
        $image_output .= '</div></figcaption>';
        $image_output .= '</figure>';

        $orientation = '';
        if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
            $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
        }

        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
			$image_output
			</{$icontag}>";
        $output .= "</{$itemtag}>";
        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= '<br style="clear: both" />';
    }

    $output .= "
		<br style='clear: both;' />
		</div>\n";

    return $output;
}
add_shortcode('gallery', 'ct_gallery');

?>