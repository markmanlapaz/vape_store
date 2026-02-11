<?php
/**
 * Mini-cart (WooCommerce widget & AJAX fragment).
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}
?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<div class="fs-mini-cart__items">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				continue;
			}

			$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
			$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
		?>
			<div class="fs-cart-item" data-key="<?php echo esc_attr( $cart_item_key ); ?>">
				<div class="fs-cart-item__image">
					<?php echo wp_kses_post( $_product->get_image( 'thumbnail' ) ); ?>
				</div>
				<div class="fs-cart-item__details">
					<h4 class="fs-cart-item__name">
						<a href="<?php echo esc_url( $_product->get_permalink() ); ?>"><?php echo esc_html( $product_name ); ?></a>
					</h4>
					<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
					<span class="fs-cart-item__price"><?php echo wp_kses_post( $product_price ); ?></span>
					<div class="fs-cart-item__qty">
						<button class="fs-cart-item__qty-btn" data-action="decrease-qty" data-key="<?php echo esc_attr( $cart_item_key ); ?>">-</button>
						<span class="fs-cart-item__qty-value"><?php echo esc_html( $cart_item['quantity'] ); ?></span>
						<button class="fs-cart-item__qty-btn" data-action="increase-qty" data-key="<?php echo esc_attr( $cart_item_key ); ?>">+</button>
					</div>
				</div>
				<button class="fs-cart-item__remove" data-action="remove-item" data-key="<?php echo esc_attr( $cart_item_key ); ?>" aria-label="<?php esc_attr_e( 'Remove', 'flavor-starter' ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</button>
			</div>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_mini_cart_contents' ); ?>
	</div>

	<div class="fs-mini-cart__footer">
		<div class="fs-mini-cart__total">
			<span><?php esc_html_e( 'Subtotal:', 'flavor-starter' ); ?></span>
			<span class="fs-mini-cart__total-amount"><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></span>
		</div>
		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
		<div class="fs-mini-cart__buttons">
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="fs-btn fs-btn--outline fs-btn--full"><?php esc_html_e( 'View Cart', 'flavor-starter' ); ?></a>
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="fs-btn fs-btn--primary fs-btn--full"><?php esc_html_e( 'Checkout', 'flavor-starter' ); ?></a>
		</div>
		<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
	</div>

<?php else : ?>

	<div class="fs-mini-cart__empty">
		<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
		<p><?php esc_html_e( 'Your cart is empty', 'flavor-starter' ); ?></p>
	</div>

<?php endif; ?>
