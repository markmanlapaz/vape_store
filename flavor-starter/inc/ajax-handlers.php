<?php
/**
 * AJAX handlers — cart operations, quick view, wishlist.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

/*--------------------------------------------------------------
 * AJAX Add to Cart
 *------------------------------------------------------------*/
function flavor_starter_ajax_add_to_cart() {
	check_ajax_referer( 'flavor_starter_nonce', 'nonce' );

	$product_id = absint( $_POST['product_id'] ?? 0 );
	$quantity   = absint( $_POST['quantity'] ?? 1 );

	if ( ! $product_id ) {
		wp_send_json_error( array( 'message' => __( 'Invalid product.', 'flavor-starter' ) ) );
	}

	$product = wc_get_product( $product_id );
	if ( ! $product || ! $product->is_purchasable() || ! $product->is_in_stock() ) {
		wp_send_json_error( array( 'message' => __( 'Product cannot be purchased.', 'flavor-starter' ) ) );
	}

	$cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity );

	if ( ! $cart_item_key ) {
		wp_send_json_error( array( 'message' => __( 'Could not add to cart.', 'flavor-starter' ) ) );
	}

	// Return updated fragments.
	ob_start();
	woocommerce_mini_cart();
	$mini_cart = ob_get_clean();

	ob_start();
	get_template_part( 'template-parts/cart-drawer' );
	$cart_drawer = ob_get_clean();

	$data = array(
		'message'    => sprintf(
			/* translators: %s: product name */
			__( '"%s" has been added to your cart.', 'flavor-starter' ),
			$product->get_name()
		),
		'cartCount'  => WC()->cart->get_cart_contents_count(),
		'cartTotal'  => WC()->cart->get_cart_subtotal(),
		'miniCart'   => $mini_cart,
		'cartDrawer' => $cart_drawer,
		'fragments'  => apply_filters( 'woocommerce_add_to_cart_fragments', array() ),
	);

	wp_send_json_success( $data );
}
add_action( 'wp_ajax_flavor_add_to_cart', 'flavor_starter_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_flavor_add_to_cart', 'flavor_starter_ajax_add_to_cart' );

/*--------------------------------------------------------------
 * AJAX Update Cart Item Quantity
 *------------------------------------------------------------*/
function flavor_starter_ajax_update_cart() {
	check_ajax_referer( 'flavor_starter_nonce', 'nonce' );

	$cart_item_key = sanitize_text_field( $_POST['cart_item_key'] ?? '' );
	$quantity      = absint( $_POST['quantity'] ?? 0 );

	if ( ! $cart_item_key ) {
		wp_send_json_error( array( 'message' => __( 'Invalid cart item.', 'flavor-starter' ) ) );
	}

	if ( 0 === $quantity ) {
		WC()->cart->remove_cart_item( $cart_item_key );
	} else {
		WC()->cart->set_quantity( $cart_item_key, $quantity );
	}

	WC()->cart->calculate_totals();

	ob_start();
	get_template_part( 'template-parts/cart-drawer' );
	$cart_drawer = ob_get_clean();

	wp_send_json_success( array(
		'cartCount'  => WC()->cart->get_cart_contents_count(),
		'cartTotal'  => WC()->cart->get_cart_subtotal(),
		'cartDrawer' => $cart_drawer,
	) );
}
add_action( 'wp_ajax_flavor_update_cart', 'flavor_starter_ajax_update_cart' );
add_action( 'wp_ajax_nopriv_flavor_update_cart', 'flavor_starter_ajax_update_cart' );

/*--------------------------------------------------------------
 * AJAX Remove Cart Item
 *------------------------------------------------------------*/
function flavor_starter_ajax_remove_cart_item() {
	check_ajax_referer( 'flavor_starter_nonce', 'nonce' );

	$cart_item_key = sanitize_text_field( $_POST['cart_item_key'] ?? '' );

	if ( ! $cart_item_key ) {
		wp_send_json_error( array( 'message' => __( 'Invalid cart item.', 'flavor-starter' ) ) );
	}

	WC()->cart->remove_cart_item( $cart_item_key );
	WC()->cart->calculate_totals();

	ob_start();
	get_template_part( 'template-parts/cart-drawer' );
	$cart_drawer = ob_get_clean();

	wp_send_json_success( array(
		'cartCount'  => WC()->cart->get_cart_contents_count(),
		'cartTotal'  => WC()->cart->get_cart_subtotal(),
		'cartDrawer' => $cart_drawer,
	) );
}
add_action( 'wp_ajax_flavor_remove_cart_item', 'flavor_starter_ajax_remove_cart_item' );
add_action( 'wp_ajax_nopriv_flavor_remove_cart_item', 'flavor_starter_ajax_remove_cart_item' );

/*--------------------------------------------------------------
 * AJAX Quick View
 *------------------------------------------------------------*/
function flavor_starter_ajax_quick_view() {
	check_ajax_referer( 'flavor_starter_nonce', 'nonce' );

	$product_id = absint( $_POST['product_id'] ?? 0 );

	if ( ! $product_id ) {
		wp_send_json_error( array( 'message' => __( 'Invalid product.', 'flavor-starter' ) ) );
	}

	global $post, $product;
	$post    = get_post( $product_id );
	$product = wc_get_product( $product_id );

	if ( ! $product ) {
		wp_send_json_error( array( 'message' => __( 'Product not found.', 'flavor-starter' ) ) );
	}

	setup_postdata( $post );

	ob_start();
	wc_get_template( 'single-product/quick-view.php' );
	$html = ob_get_clean();

	wp_reset_postdata();

	wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_flavor_quick_view', 'flavor_starter_ajax_quick_view' );
add_action( 'wp_ajax_nopriv_flavor_quick_view', 'flavor_starter_ajax_quick_view' );

/*--------------------------------------------------------------
 * AJAX Wishlist Toggle (cookie-based)
 *------------------------------------------------------------*/
function flavor_starter_ajax_toggle_wishlist() {
	check_ajax_referer( 'flavor_starter_nonce', 'nonce' );

	$product_id = absint( $_POST['product_id'] ?? 0 );

	if ( ! $product_id ) {
		wp_send_json_error( array( 'message' => __( 'Invalid product.', 'flavor-starter' ) ) );
	}

	// Get current wishlist from cookie.
	$wishlist = array();
	if ( isset( $_COOKIE['fs_wishlist'] ) ) {
		$wishlist = json_decode( sanitize_text_field( wp_unslash( $_COOKIE['fs_wishlist'] ) ), true );
		if ( ! is_array( $wishlist ) ) {
			$wishlist = array();
		}
	}

	$key = array_search( $product_id, $wishlist, true );
	if ( false !== $key ) {
		unset( $wishlist[ $key ] );
		$wishlist = array_values( $wishlist );
		$action   = 'removed';
	} else {
		$wishlist[] = $product_id;
		$action     = 'added';
	}

	// Set cookie (30 days).
	setcookie( 'fs_wishlist', wp_json_encode( $wishlist ), time() + ( 30 * DAY_IN_SECONDS ), COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );

	wp_send_json_success( array(
		'action' => $action,
		'count'  => count( $wishlist ),
		'ids'    => $wishlist,
	) );
}
add_action( 'wp_ajax_flavor_toggle_wishlist', 'flavor_starter_ajax_toggle_wishlist' );
add_action( 'wp_ajax_nopriv_flavor_toggle_wishlist', 'flavor_starter_ajax_toggle_wishlist' );
