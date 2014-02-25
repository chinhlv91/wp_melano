<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post;

$options = get_option('ct_coo_options');
if (isset($options['enable_pb_product_pages'])) {
	$enable_pb_product_pages = $options['enable_pb_product_pages'];
} else {
	$enable_pb_product_pages = false;
}

$product_description = get_post_meta($post->ID, 'ct_product_description', true);

?>

<?php 
if ($enable_pb_product_pages) {
		echo do_shortcode(ct_add_formatting($product_description));
	} else {
		the_content();
	}
?>