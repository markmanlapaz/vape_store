<?php
/**
 * Template Part: Featured Categories
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$section_title = get_theme_mod( 'fs_categories_title', __( 'Shop by Category', 'flavor-starter' ) );
$section_sub   = get_theme_mod( 'fs_categories_subtitle', __( 'Find exactly what you\'re looking for', 'flavor-starter' ) );

$categories = get_terms( array(
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'parent'     => 0,
	'number'     => 6,
	'orderby'    => 'count',
	'order'      => 'DESC',
) );

if ( is_wp_error( $categories ) || empty( $categories ) ) {
	return;
}
?>

<section class="fs-section fs-categories">
	<div class="fs-container">
		<div class="fs-section__header">
			<h2 class="fs-section__title"><?php echo esc_html( $section_title ); ?></h2>
			<p class="fs-section__subtitle"><?php echo esc_html( $section_sub ); ?></p>
		</div>

		<div class="fs-categories__grid">
			<?php foreach ( $categories as $cat ) :
				$thumb_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
				$image    = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'flavor-category' ) : '';
			?>
				<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="fs-category-card">
					<div class="fs-category-card__image">
						<?php if ( $image ) : ?>
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $cat->name ); ?>" loading="lazy" />
						<?php else : ?>
							<div class="fs-category-card__placeholder">
								<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="2" width="20" height="20" rx="4"/><circle cx="12" cy="12" r="4"/></svg>
							</div>
						<?php endif; ?>
						<div class="fs-category-card__overlay"></div>
					</div>
					<div class="fs-category-card__info">
						<h3 class="fs-category-card__name"><?php echo esc_html( $cat->name ); ?></h3>
						<span class="fs-category-card__count">
							<?php
							/* translators: %d: product count */
							printf( esc_html( _n( '%d Product', '%d Products', $cat->count, 'flavor-starter' ) ), $cat->count );
							?>
						</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
