<?php
/**
 * Template Part: Cart Drawer (slide-out)
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}
?>

<aside class="fs-cart-drawer" aria-hidden="true" role="complementary" aria-label="<?php esc_attr_e( 'Shopping Cart', 'flavor-starter' ); ?>">
	<div class="fs-cart-drawer__header">
		<h3 class="fs-cart-drawer__title">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
			<?php esc_html_e( 'Your Cart', 'flavor-starter' ); ?>
			<span class="fs-cart-drawer__count">(<?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?>)</span>
		</h3>
		<button class="fs-cart-drawer__close" data-action="toggle-cart" aria-label="<?php esc_attr_e( 'Close cart', 'flavor-starter' ); ?>">&times;</button>
	</div>

	<div class="fs-cart-drawer__body">
		<?php if ( WC()->cart->is_empty() ) : ?>
			<div class="fs-cart-drawer__empty">
				<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
				<p><?php esc_html_e( 'Your cart is empty', 'flavor-starter' ); ?></p>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="fs-btn fs-btn--primary">
					<?php esc_html_e( 'Start Shopping', 'flavor-starter' ); ?>
				</a>
			</div>
		<?php else : ?>
			<div class="fs-cart-drawer__items">
				<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
					$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 ) {
						continue;
					}
				?>
					<div class="fs-cart-item" data-key="<?php echo esc_attr( $cart_item_key ); ?>">
						<div class="fs-cart-item__image">
							<?php echo wp_kses_post( $_product->get_image( 'thumbnail' ) ); ?>
						</div>
						<div class="fs-cart-item__details">
							<h4 class="fs-cart-item__name">
								<a href="<?php echo esc_url( $_product->get_permalink() ); ?>">
									<?php echo esc_html( $_product->get_name() ); ?>
								</a>
							</h4>
							<span class="fs-cart-item__price"><?php echo wp_kses_post( WC()->cart->get_product_price( $_product ) ); ?></span>
							<div class="fs-cart-item__qty">
								<button class="fs-cart-item__qty-btn" data-action="decrease-qty" data-key="<?php echo esc_attr( $cart_item_key ); ?>" aria-label="<?php esc_attr_e( 'Decrease quantity', 'flavor-starter' ); ?>">-</button>
								<span class="fs-cart-item__qty-value"><?php echo esc_html( $cart_item['quantity'] ); ?></span>
								<button class="fs-cart-item__qty-btn" data-action="increase-qty" data-key="<?php echo esc_attr( $cart_item_key ); ?>" aria-label="<?php esc_attr_e( 'Increase quantity', 'flavor-starter' ); ?>">+</button>
							</div>
						</div>
						<button class="fs-cart-item__remove" data-action="remove-item" data-key="<?php echo esc_attr( $cart_item_key ); ?>" aria-label="<?php esc_attr_e( 'Remove item', 'flavor-starter' ); ?>">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
						</button>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( ! WC()->cart->is_empty() ) : ?>
		<div class="fs-cart-drawer__footer">
			<?php
			$free_shipping_min = get_theme_mod( 'fs_free_shipping_min', 50 );
			$cart_total_raw    = WC()->cart->get_subtotal();
			$remaining         = $free_shipping_min - $cart_total_raw;
			$progress_pct      = min( 100, ( $cart_total_raw / max( $free_shipping_min, 1 ) ) * 100 );
			?>
			<div class="fs-cart-drawer__shipping-bar">
				<?php if ( $remaining > 0 ) : ?>
					<p class="fs-cart-drawer__shipping-text">
						<?php
						printf(
							/* translators: %s: remaining amount */
							esc_html__( 'Add %s more for free shipping!', 'flavor-starter' ),
							wp_kses_post( wc_price( $remaining ) )
						);
						?>
					</p>
				<?php else : ?>
					<p class="fs-cart-drawer__shipping-text fs-cart-drawer__shipping-text--free">
						<?php esc_html_e( 'You qualify for free shipping!', 'flavor-starter' ); ?>
					</p>
				<?php endif; ?>
				<div class="fs-cart-drawer__progress">
					<div class="fs-cart-drawer__progress-bar" style="width: <?php echo esc_attr( $progress_pct ); ?>%"></div>
				</div>
			</div>

			<div class="fs-cart-drawer__totals">
				<div class="fs-cart-drawer__total-row">
					<span><?php esc_html_e( 'Subtotal:', 'flavor-starter' ); ?></span>
					<span class="fs-cart-drawer__subtotal"><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></span>
				</div>
			</div>

			<div class="fs-cart-drawer__buttons">
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="fs-btn fs-btn--outline fs-btn--full">
					<?php esc_html_e( 'View Cart', 'flavor-starter' ); ?>
				</a>
				<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="fs-btn fs-btn--primary fs-btn--full">
					<?php esc_html_e( 'Checkout', 'flavor-starter' ); ?>
				</a>
			</div>
		</div>
	<?php endif; ?>
</aside>
