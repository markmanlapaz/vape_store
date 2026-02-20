<?php
/**
 * Template Part: Hero Banner
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

$hero_title    = get_theme_mod( 'fs_hero_title', __( 'Premium Vape &amp; E-Liquids', 'flavor-starter' ) );
$hero_subtitle = get_theme_mod( 'fs_hero_subtitle', __( 'Experience the finest flavors crafted for enthusiasts', 'flavor-starter' ) );
$hero_btn_text = get_theme_mod( 'fs_hero_btn_text', __( 'Shop Now', 'flavor-starter' ) );
$hero_btn2_text = get_theme_mod( 'fs_hero_btn2_text', __( 'New Arrivals', 'flavor-starter' ) );

// Resolve smart defaults for button URLs at render time.
$_wc_active   = class_exists( 'WooCommerce' );
$_shop_url    = $_wc_active ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$hero_btn_url  = get_theme_mod( 'fs_hero_btn_url', '' );
if ( empty( $hero_btn_url ) || '#' === $hero_btn_url ) {
	$hero_btn_url = $_shop_url;
}
$hero_btn2_url = get_theme_mod( 'fs_hero_btn2_url', '' );
if ( empty( $hero_btn2_url ) || '#' === $hero_btn2_url ) {
	$hero_btn2_url = add_query_arg( 'orderby', 'date', $_shop_url );
}
$hero_bg       = get_theme_mod( 'fs_hero_bg_image', '' );
$hero_style    = get_theme_mod( 'fs_hero_style', 'gradient' ); // gradient | image | video
?>

<section class="fs-hero fs-hero--<?php echo esc_attr( $hero_style ); ?>">
	<?php if ( 'image' === $hero_style && $hero_bg ) : ?>
		<div class="fs-hero__bg" style="background-image: url('<?php echo esc_url( $hero_bg ); ?>');" aria-hidden="true"></div>
	<?php endif; ?>
	<div class="fs-hero__particles" aria-hidden="true">
		<div class="fs-hero__particle fs-hero__particle--1"></div>
		<div class="fs-hero__particle fs-hero__particle--2"></div>
		<div class="fs-hero__particle fs-hero__particle--3"></div>
		<div class="fs-hero__particle fs-hero__particle--4"></div>
		<div class="fs-hero__particle fs-hero__particle--5"></div>
	</div>
	<div class="fs-hero__glow" aria-hidden="true"></div>
	<div class="fs-container fs-hero__inner">
		<div class="fs-hero__content">
			<span class="fs-hero__badge"><?php esc_html_e( 'Free Shipping on Orders $50+', 'flavor-starter' ); ?></span>
			<h1 class="fs-hero__title"><?php echo wp_kses_post( $hero_title ); ?></h1>
			<p class="fs-hero__subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
			<div class="fs-hero__actions">
				<?php if ( $hero_btn_text ) : ?>
					<a href="<?php echo esc_url( $hero_btn_url ); ?>" class="fs-btn fs-btn--primary fs-btn--lg">
						<?php echo esc_html( $hero_btn_text ); ?>
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				<?php endif; ?>
				<?php if ( $hero_btn2_text ) : ?>
					<a href="<?php echo esc_url( $hero_btn2_url ); ?>" class="fs-btn fs-btn--outline fs-btn--lg">
						<?php echo esc_html( $hero_btn2_text ); ?>
					</a>
				<?php endif; ?>
			</div>
			<div class="fs-hero__stats">
				<div class="fs-hero__stat">
					<span class="fs-hero__stat-number">500+</span>
					<span class="fs-hero__stat-label"><?php esc_html_e( 'Products', 'flavor-starter' ); ?></span>
				</div>
				<div class="fs-hero__stat">
					<span class="fs-hero__stat-number">50+</span>
					<span class="fs-hero__stat-label"><?php esc_html_e( 'Brands', 'flavor-starter' ); ?></span>
				</div>
				<div class="fs-hero__stat">
					<span class="fs-hero__stat-number">24h</span>
					<span class="fs-hero__stat-label"><?php esc_html_e( 'Shipping', 'flavor-starter' ); ?></span>
				</div>
			</div>
		</div>
		<div class="fs-hero__visual">
			<div class="fs-hero__image-wrap">
				<?php
				$hero_product_img = get_theme_mod( 'fs_hero_product_image', '' );
				if ( $hero_product_img ) : ?>
					<img src="<?php echo esc_url( $hero_product_img ); ?>" alt="<?php esc_attr_e( 'Featured product', 'flavor-starter' ); ?>" class="fs-hero__product-image" loading="eager" />
				<?php else : ?>
					<div class="fs-hero__placeholder">
						<svg viewBox="0 0 200 300" fill="none" xmlns="http://www.w3.org/2000/svg" class="fs-hero__placeholder-svg">
							<rect x="60" y="20" width="80" height="260" rx="16" fill="var(--fs-bg-card)" stroke="var(--fs-accent-primary)" stroke-width="2"/>
							<rect x="70" y="60" width="60" height="100" rx="8" fill="var(--fs-bg-secondary)"/>
							<circle cx="100" cy="220" r="20" fill="var(--fs-accent-primary)" opacity="0.3"/>
							<circle cx="100" cy="220" r="10" fill="var(--fs-accent-primary)"/>
						</svg>
					</div>
				<?php endif; ?>
				<div class="fs-hero__image-glow" aria-hidden="true"></div>
			</div>
		</div>
	</div>
</section>
