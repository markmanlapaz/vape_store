<?php
/**
 * Template Part: Featured Products
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$section_title = get_theme_mod( 'fs_featured_title', __( 'Featured Products', 'flavor-starter' ) );
$section_sub   = get_theme_mod( 'fs_featured_subtitle', __( 'Our most popular picks, hand-selected for you', 'flavor-starter' ) );
$per_page      = absint( get_theme_mod( 'fs_featured_count', 8 ) );

$featured = wc_get_products( array(
	'limit'    => $per_page,
	'status'   => 'publish',
	'featured' => true,
	'orderby'  => 'date',
	'order'    => 'DESC',
) );

// Fallback: if no featured products, show latest.
if ( empty( $featured ) ) {
	$featured = wc_get_products( array(
		'limit'   => $per_page,
		'status'  => 'publish',
		'orderby' => 'date',
		'order'   => 'DESC',
	) );
}

if ( empty( $featured ) ) {
	return;
}
?>

<section class="fs-section fs-featured-products">
	<div class="fs-container">
		<div class="fs-section__header">
			<div class="fs-section__header-left">
				<h2 class="fs-section__title"><?php echo esc_html( $section_title ); ?></h2>
				<p class="fs-section__subtitle"><?php echo esc_html( $section_sub ); ?></p>
			</div>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="fs-btn fs-btn--outline fs-btn--sm">
				<?php esc_html_e( 'View All', 'flavor-starter' ); ?>
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
			</a>
		</div>

		<div class="fs-products-grid">
			<?php foreach ( $featured as $product ) :
				// Setup global product data for template functions.
				$GLOBALS['product'] = $product;
				setup_postdata( $product->get_id() );
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

							// Second image on hover.
							$gallery_ids = $product->get_gallery_image_ids();
							if ( ! empty( $gallery_ids ) ) {
								echo wp_get_attachment_image( $gallery_ids[0], 'flavor-product-card', false, array(
									'class'   => 'fs-product-card__img fs-product-card__img--hover',
									'loading' => 'lazy',
								) );
							}
							?>
						</a>

						<div class="fs-product-card__actions">
							<button class="fs-product-card__action fs-quick-view-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" aria-label="<?php esc_attr_e( 'Quick View', 'flavor-starter' ); ?>" title="<?php esc_attr_e( 'Quick View', 'flavor-starter' ); ?>">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
							</button>
							<button class="fs-product-card__action fs-wishlist-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" aria-label="<?php esc_attr_e( 'Add to Wishlist', 'flavor-starter' ); ?>" title="<?php esc_attr_e( 'Add to Wishlist', 'flavor-starter' ); ?>">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
							</button>
						</div>
					</div>

					<div class="fs-product-card__body">
						<?php
						$cats = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'number' => 1 ) );
						if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) : ?>
							<span class="fs-product-card__cat"><?php echo esc_html( $cats[0]->name ); ?></span>
						<?php endif; ?>

						<h3 class="fs-product-card__title">
							<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
								<?php echo esc_html( $product->get_name() ); ?>
							</a>
						</h3>

						<?php if ( $product->get_average_rating() > 0 ) : ?>
							<div class="fs-product-card__rating">
								<?php flavor_starter_star_rating( $product->get_average_rating() ); ?>
								<span class="fs-product-card__rating-count">(<?php echo esc_html( $product->get_review_count() ); ?>)</span>
							</div>
						<?php endif; ?>

						<div class="fs-product-card__footer">
							<span class="fs-product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>

							<?php if ( $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ) : ?>
								<button class="fs-btn fs-btn--primary fs-btn--sm fs-add-to-cart-btn"
									data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
									aria-label="<?php esc_attr_e( 'Add to cart', 'flavor-starter' ); ?>">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
									<span><?php esc_html_e( 'Add', 'flavor-starter' ); ?></span>
								</button>
							<?php else : ?>
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="fs-btn fs-btn--outline fs-btn--sm">
									<?php esc_html_e( 'Select', 'flavor-starter' ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</section>
