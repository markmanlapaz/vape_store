<?php
/**
 * Template Part: New Arrivals
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$section_title = get_theme_mod( 'fs_arrivals_title', __( 'New Arrivals', 'flavor-starter' ) );
$section_sub   = get_theme_mod( 'fs_arrivals_subtitle', __( 'Just dropped — be the first to try', 'flavor-starter' ) );

$products = wc_get_products( array(
	'limit'   => 4,
	'status'  => 'publish',
	'orderby' => 'date',
	'order'   => 'DESC',
) );

if ( empty( $products ) ) {
	return;
}
?>

<section class="fs-section fs-new-arrivals">
	<div class="fs-container">
		<div class="fs-section__header">
			<div class="fs-section__header-left">
				<h2 class="fs-section__title"><?php echo esc_html( $section_title ); ?></h2>
				<p class="fs-section__subtitle"><?php echo esc_html( $section_sub ); ?></p>
			</div>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) . '?orderby=date' ); ?>" class="fs-btn fs-btn--outline fs-btn--sm">
				<?php esc_html_e( 'See All New', 'flavor-starter' ); ?>
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
			</a>
		</div>

		<div class="fs-products-grid fs-products-grid--4">
			<?php foreach ( $products as $product ) :
				$GLOBALS['product'] = $product;
			?>
				<div class="fs-product-card" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
					<?php flavor_starter_product_badges( $product ); ?>

					<div class="fs-product-card__image">
						<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
							<?php
							$image_id = $product->get_image_id();
							if ( $image_id ) {
								echo wp_get_attachment_image( $image_id, 'flavor-product-card', false, array(
									'class'   => 'fs-product-card__img',
									'loading' => 'lazy',
								) );
							} else {
								echo wc_placeholder_img( 'flavor-product-card' );
							}
							?>
						</a>
						<div class="fs-product-card__actions">
							<button class="fs-product-card__action fs-quick-view-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" aria-label="<?php esc_attr_e( 'Quick View', 'flavor-starter' ); ?>">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
							</button>
							<button class="fs-product-card__action fs-wishlist-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" aria-label="<?php esc_attr_e( 'Add to Wishlist', 'flavor-starter' ); ?>">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
							</button>
						</div>
					</div>

					<div class="fs-product-card__body">
						<h3 class="fs-product-card__title">
							<a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
						</h3>
						<div class="fs-product-card__footer">
							<span class="fs-product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
							<?php if ( $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ) : ?>
								<button class="fs-btn fs-btn--primary fs-btn--sm fs-add-to-cart-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
								</button>
							<?php else : ?>
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="fs-btn fs-btn--outline fs-btn--sm"><?php esc_html_e( 'Select', 'flavor-starter' ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</section>
