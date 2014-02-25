<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $yith_wcwl;

$woocommerce->show_messages(); ?>

<?php ct_woo_help_bar(); ?>

<div class="my-account-left">

	<h4 class="lined-heading"><span><?php _e("My Account", "cootheme"); ?></span></h4>
	<ul class="nav my-account-nav">
	  <li class="active"><a href="#my-orders" data-toggle="tab"><?php _e("My Orders", "cootheme"); ?></a></li>
	  <?php if ( $downloads = $woocommerce->customer->get_downloadable_products() ) { ?>
	  <li><a href="#my-downloads" data-toggle="tab"><?php _e("My Downloads", "cootheme"); ?></a></li>
	  <?php } ?>
	  <?php if ( class_exists( 'YITH_WCWL_UI' ) ) { ?>
	  <li><a href="<?php echo $yith_wcwl->get_wishlist_url(); ?>"><?php _e("My Wishlist", "cootheme"); ?></a></li>
	  <?php } ?>
	  <li><a href="#address-book" data-toggle="tab"><?php _e("Address Book", "cootheme"); ?></a></li>
	  <li><a href="#change-password" data-toggle="tab"><?php _e("Change Password", "cootheme"); ?></a></li>
	</ul>

</div>

<div class="my-account-right tab-content">
	
	<?php do_action( 'woocommerce_before_my_account' ); ?>
	
	<div class="tab-pane active" id="my-orders">
	
	<?php 
		if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
			woocommerce_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) );
		} else {
			woocommerce_get_template('myaccount/my-orders.php', array( 'recent_orders' => $recent_orders ));
		}
	?>
	
	</div>
	
	<?php if ( $downloads = $woocommerce->customer->get_downloadable_products() ) { ?>
	
	<div class="tab-pane" id="my-downloads">
	
	<?php woocommerce_get_template( 'myaccount/my-downloads.php' ); ?>
	
	</div>
	
	<?php } ?>
	
	<div class="tab-pane" id="address-book">
	
	<?php woocommerce_get_template( 'myaccount/my-address.php' ); ?>
	
	</div>
	
	<div class="tab-pane" id="change-password">
	
	<?php woocommerce_get_template( 'myaccount/form-change-password.php' ); ?>
	
	</div>		
	
	<?php do_action( 'woocommerce_after_my_account' ); ?>
	
</div>