<?php
	
	/*
	*
	*	Coo Page Builder - Builder Class
	*	------------------------------------------------
	*	Cootheme
	* 	http://www.cootheme.com
	*
	*/
	
	class CooPageBuilder extends CTPageBuilderAbstract {
	    private $is_theme = false;
	    private $postTypes;
	    private $layout;
	    protected $shortcodes, $images_media_tab;
	
	    public static function getInstance() {
	        static $instance=null;
	        if ($instance === null)
	            $instance = new CooPageBuilder();
	        return $instance;
	    }
	
	    public function setTheme() {
	        $this->is_theme = true;
	        $this->postTypes = null;
	    }

	    public function getPostTypes() {
	        if(is_array($this->postTypes)) return $this->postTypes;
	
            $pt_array = get_option('spb_js_theme_content_types');
            
            $options = get_option('ct_coo_options');
            if (isset($options['enable_pb_product_pages'])) {
            	$enable_pb_product_pages = $options['enable_pb_product_pages'];
            } else {
            	$enable_pb_product_pages = false;
            }
            if ($enable_pb_product_pages) {
            $this->postTypes = $pt_array ? $pt_array : array('page', 'post', 'portfolio', 'product');
            } else {
            $this->postTypes = $pt_array ? $pt_array : array('page', 'post', 'portfolio');	            
            }
	        return $this->postTypes;
	    }
	
	    public function getLayout() {
	        if($this->layout==null)
	            $this->layout = new SPBLayout();
	        return $this->layout;
	    }
	
	    /* Add shortCode to plugin */
	    public function addShortCode($shortcode, $function = false) {
	        $name = 'CooPageBuilderShortcode_' . $shortcode['base'];
	        if( class_exists( $name ) && is_subclass_of( $name, 'CooPageBuilderShortcode' ) ) $this->shortcodes[$shortcode['base']] = new $name($shortcode);
	    }
	
	    public function createShortCodes() {
	        remove_all_shortcodes();
	        foreach( SPBMap::getShortCodes() as $sc_base => $el) {
	            $name = 'CooPageBuilderShortcode_' . $el['base'];
	            if( class_exists( $name ) && is_subclass_of( $name, 'CooPageBuilderShortcode' ) ) $this->shortcodes[$sc_base] = new $name($el);
	        }	
	    }
	
	    /* Save generated shortcodes, html and builder status in post meta
	    ---------------------------------------------------------- */
	    public function saveMetaBoxes($post_id) {
	        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
	        $value = $this->post( 'spb_js_status' );
	        if ($value !== null) {
	            //var_dump(get_post_meta($post_id, '_spb_js_status'));
	            // Get the value
	            //var_dump($value);
	
	            // Add value
	            if ( get_post_meta( $post_id, '_spb_js_status' ) == '' ) { add_post_meta( $post_id, '_spb_js_status', $value, true );	}
	            // Update value
	            elseif ( $value != get_post_meta( $post_id, '_spb_js_status', true ) ) { update_post_meta( $post_id, '_spb_js_status', $value ); }
	            // Delete value
	            elseif ( $value == '' ) { delete_post_meta( $post_id, '_spb_js_status', get_post_meta( $post_id, '_spb_js_status', true ) ); }
	        }
	    }
	
	    public function elementBackendHtmlJavascript_callback() {
	        $output = '';
	        $element = $this->post( 'element' );
	        $data_element = $this->post( 'data_element' );
	
	        if ( $data_element == 'spb_column' && $this->post( 'data_width' )!==null ) {
	            $output = do_shortcode( '[spb_column width="'. $this->post( 'data_width' ).'"]' );
	            echo $output;
	        } else {
	            $output = do_shortcode( '['.$data_element.']' );
	            echo $output;
	        }
	        die();
	    }
	
	    public function spbShortcodesJS_callback() {
	        $content = $this->post( 'content' );
	
	        $content = stripslashes( $content );
	        $output = spb_format_content( $content );
	        echo $output;
	        die();
	    }
	
	
	    public function showEditFormJavascript_callback() {
	        $element = $this->post( 'element' );
	        $shortCode = $this->post( 'shortcode' );
	        $shortCode = stripslashes( $shortCode );
	
	        $this->removeShortCode($element);
	        $settings = SPBMap::getShortCode($element);
	
	        new CooPageBuilderShortcode_Settings($settings);
	
	        echo do_shortcode($shortCode);
	
	        die();
	    }
	
	    public function saveTemplateJavascript_callback() {
	        $output = '';
	        $template_name = $this->post( 'template_name' );
	        $template = $this->post( 'template' );
	
	        if ( !isset($template_name) || $template_name == "" || !isset($template) || $template == "" ) { echo 'Error: TPL-01'; die(); }
	
	        $template_arr = array( "name" => $template_name, "template" => $template );
	
	        $option_name = 'spb_js_templates';
	        $saved_templates = get_option($option_name);
	
	        /*if ( $saved_templates == false ) {
	            update_option('spb_js_templates', $template_arr);
	        }*/
	
	        $template_id = sanitize_title($template_name)."_".rand();
	        if ( $saved_templates == false ) {
	            $deprecated = '';
	            $autoload = 'no';
	            //
	            $new_template = array();
	            $new_template[$template_id] = $template_arr;
	            //
	            add_option( $option_name, $new_template, $deprecated, $autoload );
	        } else {
	            $saved_templates[$template_id] = $template_arr;
	            update_option($option_name, $saved_templates);
	        }
	
	        echo $this->getLayout()->getNavBar()->getTemplateMenu();
	
	        //delete_option('spb_js_templates');
	
	        die();
	    }
	
	    public function loadTemplateJavascript_callback() {
	        $output = '';
	        $template_id = $this->post( 'template_id' );
	
	        if ( !isset($template_id) || $template_id == "" ) { echo 'Error: TPL-02'; die(); }
	
	        $option_name = 'spb_js_templates';
	        $saved_templates = get_option($option_name);
	
	        $content = $saved_templates[$template_id]['template'];
	        $content = str_ireplace('\"', '"', $content);
	        //echo $content;
	        echo do_shortcode($content);
	
	        die();
	    }
	   
	    public function deleteTemplateJavascript_callback() {
	        $output = '';
	        $template_id = $this->post( 'template_id' );
	
	        if ( !isset($template_id) || $template_id == "" ) { echo 'Error: TPL-03'; die(); }
	
	        $option_name = 'spb_js_templates';
	        $saved_templates = get_option($option_name);
	
	        unset($saved_templates[$template_id]);
	        if ( count($saved_templates) > 0 ) {
	            update_option($option_name, $saved_templates);
	        } else {
	            delete_option($option_name);
	        }
	
	        echo $this->getLayout()->getNavBar()->getTemplateMenu();
	
	        die();
	    }
	
	     public function loadCTTemplateJavascript_callback() {
	        $output = $content = '';
	        $template_id = $this->post( 'template_id' );
	
	        if ( !isset($template_id) || $template_id == "" ) { echo 'Error: TPL-02'; die(); }
	        
	        $content = get_prebuilt_template_code($template_id);
				        
	        echo do_shortcode($content);
	
	        die();
	    }
	}
	
?>