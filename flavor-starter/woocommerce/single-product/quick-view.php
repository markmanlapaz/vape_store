<?php
/**
 * Quick View template (loaded via AJAX).
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}
?>

<div class="fs-quick-view" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
	<div class="fs-quick-view__gallery">
		<?php
		$image_id    = $product->get_image_id();
		$gallery_ids = $product->get_gallery_image_ids();
		$all_images  = $image_id ? array_merge( array( $image_id ), $gallery_ids ) : $gallery_ids;
		?>
		<div class="fs-quick-view__main-image">
			<?php
			if ( $image_id ) {
				echo wp_get_attachment_image( $image_id, 'woocommerce_single', false, array(
					'class' => 'fs-quick-view__img',
					'id'    => 'fs-qv-main-img',
				) );
			} else {
				echo wc_placeholder_img( 'woocommerce_single' );
			}
			?>
		</div>
		<?php if ( count( $all_images ) > 1 ) : ?>
			<div class="fs-quick-view__thumbs">
				<?php foreach ( $all_images as $idx => $img_id ) : ?>
					<button class="fs-quick-view__thumb <?php echo 0 === $idx ? 'fs-quick-view__thumb--active' : ''; ?>"
						data-full="<?php echo esc_url( wp_get_attachment_image_url( $img_id, 'woocommerce_single' ) ); ?>">
						<?php echo wp_get_attachment_image( $img_id, 'thumbnail' ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="fs-quick-view__info">
		<h2 class="fs-quick-view__title"><?php echo esc_html( $product->get_name() ); ?></h2>

		<div class="fs-quick-view__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>

		<?php if ( $product->get_average_rating() > 0 ) : ?>
			<div class="fs-quick-view__rating">
				<?php flavor_starter_star_rating( $product->get_average_rating() ); ?>
				<span>(<?php echo esc_html( $product->get_review_count() ); ?> <?php esc_html_e( 'reviews', 'flavor-starter' ); ?>)</span>
			</div>
		<?php endif; ?>

		<div class="fs-quick-view__short-desc">
			<?php echo wp_kses_post( $product->get_short_description() ); ?>
		</div>

		<?php if ( $product->is_in_stock() ) : ?>
			<span class="fs-quick-view__stock fs-quick-view__stock--in">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
				<?php esc_html_e( 'In Stock', 'flavor-starter' ); ?>
			</span>
		<?php else : ?>
			<span class="fs-quick-view__stock fs-quick-view__stock--out"><?php esc_html_e( 'Out of Stock', 'flavor-starter' ); ?></span>
		<?php endif; ?>

		<?php if ( $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ) : ?>
			<div class="fs-quick-view__add-to-cart">
				<div class="fs-qty-input">
					<button class="fs-qty-input__btn" data-action="qty-decrease">-</button>
					<input type="number" class="fs-qty-input__field" value="1" min="1" max="<?php echo esc_attr( $product->get_stock_quantity() ?: 99 ); ?>" step="1" />
					<button class="fs-qty-input__btn" data-action="qty-increase">+</button>
				</div>
				<button class="fs-btn fs-btn--primary fs-btn--lg fs-add-to-cart-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
					<?php esc_html_e( 'Add to Cart', 'flavor-starter' ); ?>
				</button>
			</div>
		<?php elseif ( $product->is_type( 'variable' ) ) : ?>
			<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="fs-btn fs-btn--primary fs-btn--lg">
				<?php esc_html_e( 'Select Options', 'flavor-starter' ); ?>
			</a>
		<?php endif; ?>

		<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="fs-quick-view__full-link">
			<?php esc_html_e( 'View Full Details', 'flavor-starter' ); ?>
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
		</a>

		<?php
		// SKU & categories meta.
		?>
		<div class="fs-quick-view__meta">
			<?php if ( $product->get_sku() ) : ?>
				<div class="fs-quick-view__meta-row">
					<span class="fs-quick-view__meta-label"><?php esc_html_e( 'SKU:', 'flavor-starter' ); ?></span>
					<span><?php echo esc_html( $product->get_sku() ); ?></span>
				</div>
			<?php endif; ?>
			<?php
			$cat_list = wc_get_product_category_list( $product->get_id(), ', ' );
			if ( $cat_list ) : ?>
				<div class="fs-quick-view__meta-row">
					<span class="fs-quick-view__meta-label"><?php esc_html_e( 'Category:', 'flavor-starter' ); ?></span>
					<span><?php echo wp_kses_post( $cat_list ); ?></span>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
