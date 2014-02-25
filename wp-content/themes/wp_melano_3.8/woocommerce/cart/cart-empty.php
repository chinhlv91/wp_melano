<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<h4><?php _e( 'Your Shopping Bag is empty', 'cootheme' ) ?></h4>

<p class="no-items"><?php _e( 'You currently have no items in your Shopping Bag.', 'cootheme' ) ?></p>

<?php do_action('woocommerce_cart_is_empty'); ?>

<a class="continue-shopping" href="<?php echo get_permalink(woocommerce_get_page_id('shop')); ?>"><?php _e( 'Continue shopping', 'cootheme' ) ?></a>