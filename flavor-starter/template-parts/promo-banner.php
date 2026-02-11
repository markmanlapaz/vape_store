<?php
/**
 * Template Part: Promo Banner
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

$promo_show    = get_theme_mod( 'fs_promo_show', true );
$promo1_title  = get_theme_mod( 'fs_promo1_title', __( 'Starter Kits', 'flavor-starter' ) );
$promo1_text   = get_theme_mod( 'fs_promo1_text', __( 'Everything you need to get started', 'flavor-starter' ) );
$promo1_btn    = get_theme_mod( 'fs_promo1_btn', __( 'Shop Kits', 'flavor-starter' ) );
$promo1_url    = get_theme_mod( 'fs_promo1_url', '#' );
$promo1_bg     = get_theme_mod( 'fs_promo1_bg', '' );

$promo2_title  = get_theme_mod( 'fs_promo2_title', __( 'Premium E-Liquids', 'flavor-starter' ) );
$promo2_text   = get_theme_mod( 'fs_promo2_text', __( 'Over 200 flavors to choose from', 'flavor-starter' ) );
$promo2_btn    = get_theme_mod( 'fs_promo2_btn', __( 'Browse Flavors', 'flavor-starter' ) );
$promo2_url    = get_theme_mod( 'fs_promo2_url', '#' );
$promo2_bg     = get_theme_mod( 'fs_promo2_bg', '' );

if ( ! $promo_show ) {
	return;
}
?>

<section class="fs-section fs-promo">
	<div class="fs-container">
		<div class="fs-promo__grid">
			<a href="<?php echo esc_url( $promo1_url ); ?>" class="fs-promo-card fs-promo-card--accent1">
				<?php if ( $promo1_bg ) : ?>
					<img src="<?php echo esc_url( $promo1_bg ); ?>" alt="" class="fs-promo-card__bg" loading="lazy" />
				<?php endif; ?>
				<div class="fs-promo-card__content">
					<span class="fs-promo-card__label"><?php esc_html_e( 'Collection', 'flavor-starter' ); ?></span>
					<h3 class="fs-promo-card__title"><?php echo esc_html( $promo1_title ); ?></h3>
					<p class="fs-promo-card__text"><?php echo esc_html( $promo1_text ); ?></p>
					<span class="fs-promo-card__btn"><?php echo esc_html( $promo1_btn ); ?> &rarr;</span>
				</div>
			</a>

			<a href="<?php echo esc_url( $promo2_url ); ?>" class="fs-promo-card fs-promo-card--accent2">
				<?php if ( $promo2_bg ) : ?>
					<img src="<?php echo esc_url( $promo2_bg ); ?>" alt="" class="fs-promo-card__bg" loading="lazy" />
				<?php endif; ?>
				<div class="fs-promo-card__content">
					<span class="fs-promo-card__label"><?php esc_html_e( 'Explore', 'flavor-starter' ); ?></span>
					<h3 class="fs-promo-card__title"><?php echo esc_html( $promo2_title ); ?></h3>
					<p class="fs-promo-card__text"><?php echo esc_html( $promo2_text ); ?></p>
					<span class="fs-promo-card__btn"><?php echo esc_html( $promo2_btn ); ?> &rarr;</span>
				</div>
			</a>
		</div>
	</div>
</section>
