<?php
/**
 * 404 template.
 *
 * @package Flavor_Starter
 */

get_header();
?>

<main id="primary" class="fs-main" role="main">
	<div class="fs-container">
		<section class="fs-404">
			<div class="fs-404__content">
				<span class="fs-404__code">404</span>
				<h1 class="fs-404__title"><?php esc_html_e( 'Page Not Found', 'flavor-starter' ); ?></h1>
				<p class="fs-404__text"><?php esc_html_e( 'The page you\'re looking for doesn\'t exist or has been moved. Let\'s get you back on track.', 'flavor-starter' ); ?></p>
				<div class="fs-404__actions">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fs-btn fs-btn--primary">
						<?php esc_html_e( 'Go Home', 'flavor-starter' ); ?>
					</a>
					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="fs-btn fs-btn--outline">
							<?php esc_html_e( 'Browse Shop', 'flavor-starter' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
