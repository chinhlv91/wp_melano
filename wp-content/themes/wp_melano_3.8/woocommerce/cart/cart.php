<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$woocommerce->show_messages();

$cart_count = ct_product_items_text($woocommerce->cart->cart_contents_count);

global $ct_include_isotope, $ct_has_products;
$ct_include_isotope = true;
$ct_has_products = true;
?>

<?php do_action( 'woocommerce_before_cart' ); ?>
	
<form action="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" method="post">

	<div class="row">
		
		<div class="col-sm-12 col-md-12">
		
			<h3 class="bag-summary"><?php _e('Your selection', 'cootheme');?> <span>(<?php echo $cart_count; ?>)</span></h3>
			
			<?php do_action( 'woocommerce_before_cart_table' ); ?>
			
			<table class="shop_table cart" cellspacing="0">
				<thead>
					<tr>
						<th class="product-thumbnail"><?php _e( 'Item', 'cootheme' ); ?></th>
						<th class="product-name"><?php _e( 'Description', 'cootheme' ); ?></th>
						<th class="product-price"><?php _e( 'Unit Price', 'cootheme' ); ?></th>
						<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
						<th class="product-subtotal"><?php _e( 'Subtotal', 'cootheme' ); ?></th>
						<th class="product-remove">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php do_action( 'woocommerce_before_cart_contents' ); ?>
			
					<?php
					if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) {
						foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
							$_product = $values['data'];
							if ( $_product->exists() && $values['quantity'] > 0 ) {
								?>
								<tr class = "<?php echo esc_attr( apply_filters('woocommerce_cart_table_item_class', 'cart_table_item', $values, $cart_item_key ) ); ?>">	
									<!-- The thumbnail -->
									<td class="product-thumbnail">
										<?php
											$thumbnail = apply_filters( 'woocommerce_in_cart_product_thumbnail', $_product->get_image(), $values, $cart_item_key );
			
											if ( ! $_product->is_visible() || ( ! empty( $_product->variation_id ) && ! $_product->parent_is_visible() ) )
												echo $thumbnail;
											else
												printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), $thumbnail );
										?>
									</td>
			
									<!-- Product Name -->
									<td class="product-name">
										<?php
											if ( ! $_product->is_visible() || ( ! empty( $_product->variation_id ) && ! $_product->parent_is_visible() ) )
												echo apply_filters( 'woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key );
											else
												printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), apply_filters('woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key ) );
			
											// Meta data
											echo $woocommerce->cart->get_item_data( $values );
			
			                   				// Backorder notification
			                   				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $values['quantity'] ) )
			                   					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
			                   					
			                   				if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
			                   													
												$product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
													
												echo '<span class="price">'.apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $values, $cart_item_key ).'</span>';
											
											} else {
											
												$product_price = get_option('woocommerce_display_cart_prices_excluding_tax') == 'yes' || $woocommerce->customer->is_vat_exempt() ? $_product->get_price_excluding_tax() : $_product->get_price();
											
												echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $values, $cart_item_key );
											
											}
										?>
									</td>
			
									<!-- Product price -->
									<td class="product-price">
										<?php
											if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
												
												$product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
			
												echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $values, $cart_item_key );
											
											} else {
											
												$product_price = get_option('woocommerce_display_cart_prices_excluding_tax') == 'yes' || $woocommerce->customer->is_vat_exempt() ? $_product->get_price_excluding_tax() : $_product->get_price();
											
												echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $values, $cart_item_key );
											
											}
										?>
									</td>
			
									<!-- Quantity inputs -->
									<td class="product-quantity">
										<?php
											if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
												
												if ( $_product->is_sold_individually() ) {
													$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
												} else {
				
													$step	= apply_filters( 'woocommerce_quantity_input_step', '1', $_product );
													$min 	= apply_filters( 'woocommerce_quantity_input_min', '', $_product );
													$max 	= apply_filters( 'woocommerce_quantity_input_max', $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(), $_product );
				
													$product_quantity = sprintf( '<div class="quantity"><input type="number" name="cart[%s][qty]" step="%s" min="%s" max="%s" value="%s" size="4" title="' . _x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) . '" class="input-text qty text" maxlength="12" /></div>', $cart_item_key, $step, $min, $max, esc_attr( $values['quantity'] ) );
												}
				
												echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
											
											} else {
												
												if ( $_product->is_sold_individually() ) {
													$product_quantity = '1';
												} else {
													$data_min = apply_filters( 'woocommerce_cart_item_data_min', '', $_product );
													$data_max = ( $_product->backorders_allowed() ) ? '' : $_product->get_stock_quantity();
													$data_max = apply_filters( 'woocommerce_cart_item_data_max', $data_max, $_product );
				
													$product_quantity = sprintf( '<div class="quantity"><input name="cart[%s][qty]" data-min="%s" data-max="%s" value="%s" size="4" title="Qty" class="input-text qty text" maxlength="12" /></div>', $cart_item_key, $data_min, $data_max, esc_attr( $values['quantity'] ) );
												}
				
												echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
												
											}
										?>
									</td>
			
									<!-- Product subtotal -->
									<td class="product-subtotal">
										<?php
											echo apply_filters( 'woocommerce_cart_item_subtotal', $woocommerce->cart->get_product_subtotal( $_product, $values['quantity'] ), $values, $cart_item_key );
										?>
									</td>
									
									<!-- Remove from cart link -->
									<td class="product-remove">
										<?php
											echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s"><i class="ss-delete"></i></a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
										?>
									</td>
								</tr>
								<?php
							}
						}
					}
			
					do_action( 'woocommerce_cart_contents' );
					?>
					
					<?php do_action( 'woocommerce_after_cart_contents' ); ?>
				</tbody>
			</table>
		
			<?php do_action( 'woocommerce_after_cart_table' ); ?>
		
		</div>
		
	</div>
    <div class="row">
        <div class="col-sm-5 col-md-5">
            <div class="shipping-calc">
                <?php woocommerce_shipping_calculator(); ?>
            </div>
        </div>
        <div class="col-sm-4 col-md-4">
            <?php if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) { ?>
            <?php if ( $woocommerce->cart->coupons_enabled() ) { ?>
                <div class="coupon">

                    <h4 class="lined-heading"><span><?php _e('Promotional Code', 'cootheme'); ?></span></h4>

                    <input name="coupon_code" class="input-text" id="coupon_code" placeholder="<?php _e('Enter promotion code', 'cootheme'); ?>" value="" /> <input type="submit" class="apply-coupon" name="apply_coupon" value="<?php _e( 'Apply', 'woocommerce' ); ?>" />

                    <?php do_action('woocommerce_cart_coupon'); ?>

                </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="col-sm-3 col-md-3">

            <?php woocommerce_cart_totals(); ?>

            <input type="submit" class="update-cart-button button" name="update_cart" value="<?php _e( 'Update Shopping Bag', 'cootheme' ); ?>" /> <input type="submit" class="checkout-button button alt" name="proceed" value="<?php _e( 'Proceed to Checkout', 'cootheme' ); ?>" />

            <?php do_action('woocommerce_proceed_to_checkout'); ?>

            <?php $woocommerce->nonce_field('cart') ?>

            <a class="continue-shopping" href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>"><?php _e('Continue shopping', 'cootheme'); ?></a>

        </div>
    </div>
		
</form>

<div class="cart-collaterals">

	<?php do_action('woocommerce_cart_collaterals'); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>