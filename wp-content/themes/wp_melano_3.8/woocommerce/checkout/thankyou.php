<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if ( $order ) : ?>

<div class="checkout-confirmation">

	<?php if ( in_array( $order->status, array( 'failed' ) ) ) : ?>

		<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'woocommerce' ); ?></p>

		<p><?php
			if ( is_user_logged_in() )
				_e( 'Please attempt your purchase again or go to your account page.', 'woocommerce' );
			else
				_e( 'Please attempt your purchase again.', 'woocommerce' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>
		
		<?php ct_woo_help_bar(); ?>
		
		<ul class="checkout-process clearfix">
			<li><p><?php _e("1. Sign In", "cootheme"); ?></p></li>
			<li><p><?php _e("2. Billing & Shipping", "cootheme"); ?></p></li>
			<li><p><?php _e("3. Review & Payment", "cootheme"); ?></p></li>
			<li><p class="active"><?php _e("4. Confirmation", "cootheme"); ?></p></li>
		</ul>

		<p class="thank-you"><?php _e( 'Thank you. Your order has been received.', 'woocommerce' ); ?></p>

		<ul class="order_details">
			<li class="order">
				<?php _e( 'Order:', 'woocommerce' ); ?>
				<?php echo $order->get_order_number(); ?>
			</li>
			<li class="date">
				<?php _e( 'Date:', 'woocommerce' ); ?>
				<?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?>
			</li>
			<li class="total">
				<?php _e( 'Total:', 'woocommerce' ); ?>
				<?php echo $order->get_formatted_order_total(); ?>
			</li>
			<?php if ( $order->payment_method_title ) : ?>
			<li class="method">
				<?php _e( 'Payment method:', 'woocommerce' ); ?>
				<?php echo $order->payment_method_title; ?>
			</li>
			<?php endif; ?>
		</ul>
		<div class="clear"></div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>
	
	<a class="continue-shopping" href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>"><?php _e('Continue shopping', 'cootheme'); ?></a>
	
</div>

<?php else : ?>

<div class="checkout-confirmation">
	
	<?php ct_woo_help_bar(); ?>
	
	<ul class="checkout-process clearfix">
		<li><p><?php _e("1. Sign In", "cootheme"); ?></p></li>
		<li><p><?php _e("2. Billing & Shipping", "cootheme"); ?></p></li>
		<li><p><?php _e("3. Review & Payment", "cootheme"); ?></p></li>
		<li><p class="active"><?php _e("4. Confirmation", "cootheme"); ?></p></li>
	</ul>

	<p class="thank-you"><?php _e( 'Thank you. Your order has been received.', 'woocommerce' ); ?></p>

	<a class="continue-shopping" href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>"><?php _e('Continue shopping', 'cootheme'); ?></a>
	
</div>

<?php endif; ?>