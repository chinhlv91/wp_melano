<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>

<?php if ( ! $product->is_in_stock() ) : ?>

	<a href="<?php echo apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ); ?>" class=""><i class="fa-eye"></i></a><?php echo ct_wishlist_button(); ?>
	
<?php else : ?>

	<?php
		$link = array(
			'url'   => '',
			'label' => '',
			'class' => '',
			'icon' => ''
		);

		$handler = apply_filters( 'woocommerce_add_to_cart_handler', $product->product_type, $product );

		switch ( $handler ) {
			case "variable" :
				$link['url'] 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
				$link['label'] 	= '<i class="ss-sugarpackets"></i><span>' . apply_filters( 'variable_add_to_cart_text', __( 'Select options', 'woocommerce' ) ) . '</span>';
			break;
			case "grouped" :
				$link['url'] 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
				$link['label'] 	= '<i class="ss-sugarpackets"></i><span>' . apply_filters( 'grouped_add_to_cart_text', __( 'View options', 'woocommerce' ) ) . '</span>';
			break;
			case "external" :
				$link['url'] 	= apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
				$link['label'] 	= '<i class="ss-info"></i><span>' . apply_filters( 'external_add_to_cart_text', __( 'Read More', 'woocommerce' ) ) . '</span>';
			break;
			default :
				if ( $product->is_purchasable() ) {
					$link['url'] 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
					$link['label'] 	= '<i class="fa-shopping-cart"></i>';
					$link['class']  = apply_filters( 'add_to_cart_class', 'add_to_cart_button' );
				} else {
					$link['url'] 	= apply_filters( 'not_purchasable_url', get_permalink( $product->id ) );
					$link['label'] 	= '<i class="fa-eye"></i>';
				}
			break;
		}

		$added_text = __( 'Ok', 'cootheme' );

		echo apply_filters( 'woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="%s product_type_%s"  data-added_text="%s">%s</a>', esc_url( $link['url'] ), esc_attr( $product->id ), esc_attr( $product->get_sku() ), esc_attr( $link['class'] ), esc_attr( $product->product_type ), $added_text, $link['label'] ), $product, $link);
		
		echo ct_wishlist_button();
		
	?>

<?php endif; ?>
