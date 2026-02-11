<?php
/**
 * Sidebar template.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

// Determine which sidebar to use.
if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product_category() || is_product_tag() || is_product() ) ) {
	$sidebar_id = 'sidebar-shop';
} else {
	$sidebar_id = 'sidebar-blog';
}

if ( ! is_active_sidebar( $sidebar_id ) ) {
	return;
}
?>

<div class="fs-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'flavor-starter' ); ?>">
	<?php dynamic_sidebar( $sidebar_id ); ?>
</div>
