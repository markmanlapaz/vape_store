<?php
/**
 * WooCommerce integration — hooks, overrides, customizations.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

/*--------------------------------------------------------------
 * Remove default WooCommerce wrappers & add our own
 *------------------------------------------------------------*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

function flavor_starter_wc_wrapper_before() {
	echo '<div class="fs-wc-content">';
}
add_action( 'woocommerce_before_main_content', 'flavor_starter_wc_wrapper_before' );

function flavor_starter_wc_wrapper_after() {
	echo '</div>';
}
add_action( 'woocommerce_after_main_content', 'flavor_starter_wc_wrapper_after' );

/*--------------------------------------------------------------
 * Remove default WooCommerce sidebar
 *------------------------------------------------------------*/
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/*--------------------------------------------------------------
 * Products per page
 *------------------------------------------------------------*/
function flavor_starter_products_per_page( $cols ) {
	return 12;
}
add_filter( 'loop_shop_per_page', 'flavor_starter_products_per_page' );

/*--------------------------------------------------------------
 * Product columns
 *------------------------------------------------------------*/
function flavor_starter_loop_columns() {
	return 4;
}
add_filter( 'loop_shop_columns', 'flavor_starter_loop_columns' );

/*--------------------------------------------------------------
 * Remove default product loop actions (we use our custom card)
 *------------------------------------------------------------*/
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

/*--------------------------------------------------------------
 * Breadcrumb defaults
 *------------------------------------------------------------*/
function flavor_starter_wc_breadcrumb_defaults( $defaults ) {
	$defaults['delimiter']   = '<span class="fs-breadcrumb__sep">/</span>';
	$defaults['wrap_before'] = '<nav class="fs-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'flavor-starter' ) . '">';
	$defaults['wrap_after']  = '</nav>';
	$defaults['before']      = '<span class="fs-breadcrumb__item">';
	$defaults['after']       = '</span>';
	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'flavor_starter_wc_breadcrumb_defaults' );

/*--------------------------------------------------------------
 * Related products args
 *------------------------------------------------------------*/
function flavor_starter_related_products_args( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'flavor_starter_related_products_args' );

/*--------------------------------------------------------------
 * Cart fragments (update cart count in header)
 *------------------------------------------------------------*/
function flavor_starter_cart_fragments( $fragments ) {
	$fragments['.fs-header__cart-count']    = '<span class="fs-header__badge fs-header__cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
	$fragments['.fs-cart-drawer__count']    = '<span class="fs-cart-drawer__count">(' . WC()->cart->get_cart_contents_count() . ')</span>';
	$fragments['.fs-cart-drawer__subtotal'] = '<span class="fs-cart-drawer__subtotal">' . WC()->cart->get_cart_subtotal() . '</span>';

	// Update the cart drawer body.
	ob_start();
	get_template_part( 'template-parts/cart-drawer' );
	$fragments['.fs-cart-drawer'] = ob_get_clean();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'flavor_starter_cart_fragments' );

/*--------------------------------------------------------------
 * Single product: re-arrange elements
 *------------------------------------------------------------*/
// Move price after short description.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );

/*--------------------------------------------------------------
 * Custom "New" / "Sale" / "Popular" flash on single product
 *------------------------------------------------------------*/
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
function flavor_starter_single_product_badges() {
	global $product;
	flavor_starter_product_badges( $product );
}
add_action( 'woocommerce_before_single_product_summary', 'flavor_starter_single_product_badges', 10 );

/*--------------------------------------------------------------
 * Wrap single product gallery + summary for layout
 *------------------------------------------------------------*/
function flavor_starter_single_product_wrap_open() {
	echo '<div class="fs-container"><div class="fs-single-product">';
}
add_action( 'woocommerce_before_single_product_summary', 'flavor_starter_single_product_wrap_open', 1 );

function flavor_starter_single_product_wrap_close() {
	echo '</div></div>';
}
add_action( 'woocommerce_after_single_product_summary', 'flavor_starter_single_product_wrap_close', 1 );

/*--------------------------------------------------------------
 * Wrap tabs + related + upsells in a container.
 * The gallery/summary wrap closes at priority 1; we open at 5 and
 * close at 99 so everything in between is inside the container.
 *------------------------------------------------------------*/
function flavor_starter_product_extra_open() {
	echo '<div class="fs-container fs-product-extra">';
}
add_action( 'woocommerce_after_single_product_summary', 'flavor_starter_product_extra_open', 5 );

function flavor_starter_product_extra_close() {
	echo '</div>';
}
add_action( 'woocommerce_after_single_product_summary', 'flavor_starter_product_extra_close', 99 );

/*--------------------------------------------------------------
 * Wishlist button alongside Add to Cart on single product.
 *------------------------------------------------------------*/
function flavor_starter_single_product_wishlist() {
	global $product;
	if ( ! $product ) {
		return;
	}
	?>
	<button
		type="button"
		class="fs-btn fs-btn--outline fs-single-wishlist-btn fs-wishlist-btn"
		data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
		aria-label="<?php esc_attr_e( 'Add to Wishlist', 'flavor-starter' ); ?>"
	>
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
		<?php esc_html_e( 'Wishlist', 'flavor-starter' ); ?>
	</button>
	<?php
}
add_action( 'woocommerce_after_add_to_cart_button', 'flavor_starter_single_product_wishlist' );

/*--------------------------------------------------------------
 * Empty cart message
 *------------------------------------------------------------*/
function flavor_starter_empty_cart_message() {
	?>
	<div class="fs-empty-cart">
		<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--fs-text-secondary)" stroke-width="1"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
		<p class="fs-empty-cart__text"><?php esc_html_e( 'Your cart is currently empty.', 'flavor-starter' ); ?></p>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="fs-btn fs-btn--primary">
			<?php esc_html_e( 'Continue Shopping', 'flavor-starter' ); ?>
		</a>
	</div>
	<?php
}
