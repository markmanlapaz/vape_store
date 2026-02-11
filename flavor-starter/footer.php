<?php
/**
 * The footer template.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

$footer_layout = get_theme_mod( 'fs_footer_layout', 'default' );
$show_back_to_top = get_theme_mod( 'fs_footer_back_to_top', true );
?>

<footer id="colophon" class="fs-footer fs-footer--<?php echo esc_attr( $footer_layout ); ?>" role="contentinfo">

	<?php
	// Newsletter section (optional).
	$newsletter_show = get_theme_mod( 'fs_footer_newsletter', true );
	if ( $newsletter_show ) :
	?>
	<div class="fs-newsletter">
		<div class="fs-container fs-newsletter__inner">
			<div class="fs-newsletter__content">
				<h3 class="fs-newsletter__title"><?php echo esc_html( get_theme_mod( 'fs_newsletter_title', __( 'Get 15% Off Your First Order', 'flavor-starter' ) ) ); ?></h3>
				<p class="fs-newsletter__text"><?php echo esc_html( get_theme_mod( 'fs_newsletter_text', __( 'Subscribe for exclusive deals, new arrivals, and vaping tips.', 'flavor-starter' ) ) ); ?></p>
			</div>
			<form class="fs-newsletter__form" action="#" method="post">
				<div class="fs-newsletter__input-wrap">
					<input type="email" name="email" class="fs-newsletter__input" placeholder="<?php esc_attr_e( 'Enter your email', 'flavor-starter' ); ?>" required />
					<button type="submit" class="fs-newsletter__btn"><?php esc_html_e( 'Subscribe', 'flavor-starter' ); ?></button>
				</div>
			</form>
		</div>
	</div>
	<?php endif; ?>

	<!-- Footer Widgets -->
	<div class="fs-footer__widgets">
		<div class="fs-container">
			<div class="fs-footer__grid">
				<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
					<div class="fs-footer__col">
						<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
							<?php dynamic_sidebar( 'footer-' . $i ); ?>
						<?php else : ?>
							<?php if ( 1 === $i ) : ?>
								<div class="fs-footer-widget">
									<div class="fs-footer__brand">
										<?php if ( has_custom_logo() ) : ?>
											<?php the_custom_logo(); ?>
										<?php else : ?>
											<span class="fs-footer__site-title"><?php bloginfo( 'name' ); ?></span>
										<?php endif; ?>
									</div>
									<p class="fs-footer__desc"><?php bloginfo( 'description' ); ?></p>
									<?php flavor_starter_social_links(); ?>
								</div>
							<?php elseif ( 2 === $i ) : ?>
								<div class="fs-footer-widget">
									<h4 class="fs-footer-widget__title"><?php esc_html_e( 'Quick Links', 'flavor-starter' ); ?></h4>
									<?php
									wp_nav_menu( array(
										'theme_location' => 'footer',
										'container'      => false,
										'menu_class'     => 'fs-footer-menu',
										'depth'          => 1,
										'fallback_cb'    => false,
									) );
									?>
								</div>
							<?php elseif ( 3 === $i ) : ?>
								<div class="fs-footer-widget">
									<h4 class="fs-footer-widget__title"><?php esc_html_e( 'Categories', 'flavor-starter' ); ?></h4>
									<?php if ( class_exists( 'WooCommerce' ) ) : ?>
										<ul class="fs-footer-menu">
											<?php
											$cats = get_terms( array(
												'taxonomy'   => 'product_cat',
												'hide_empty' => true,
												'number'     => 6,
											) );
											if ( ! is_wp_error( $cats ) ) {
												foreach ( $cats as $cat ) {
													printf(
														'<li><a href="%s">%s</a></li>',
														esc_url( get_term_link( $cat ) ),
														esc_html( $cat->name )
													);
												}
											}
											?>
										</ul>
									<?php endif; ?>
								</div>
							<?php else : ?>
								<div class="fs-footer-widget">
									<h4 class="fs-footer-widget__title"><?php esc_html_e( 'Contact', 'flavor-starter' ); ?></h4>
									<ul class="fs-footer-contact">
										<?php
										$email = get_theme_mod( 'fs_contact_email', get_bloginfo( 'admin_email' ) );
										$phone = get_theme_mod( 'fs_contact_phone', '' );
										$address = get_theme_mod( 'fs_contact_address', '' );
										if ( $email ) :
										?>
											<li>
												<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
												<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
											</li>
										<?php endif; ?>
										<?php if ( $phone ) : ?>
											<li>
												<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
												<a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a>
											</li>
										<?php endif; ?>
										<?php if ( $address ) : ?>
											<li>
												<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
												<span><?php echo esc_html( $address ); ?></span>
											</li>
										<?php endif; ?>
									</ul>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</div>

	<!-- Footer Bottom -->
	<div class="fs-footer__bottom">
		<div class="fs-container fs-footer__bottom-inner">
			<p class="fs-footer__copyright">
				<?php
				$copyright_text = get_theme_mod( 'fs_footer_copyright', '' );
				if ( $copyright_text ) {
					echo wp_kses_post( $copyright_text );
				} else {
					printf(
						/* translators: %1$s: current year, %2$s: site name */
						esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'flavor-starter' ),
						esc_html( date_i18n( 'Y' ) ),
						esc_html( get_bloginfo( 'name' ) )
					);
				}
				?>
			</p>
			<div class="fs-footer__payments">
				<span class="fs-footer__payment-label"><?php esc_html_e( 'We accept:', 'flavor-starter' ); ?></span>
				<div class="fs-footer__payment-icons">
					<span class="fs-payment-icon" title="Visa">Visa</span>
					<span class="fs-payment-icon" title="Mastercard">MC</span>
					<span class="fs-payment-icon" title="PayPal">PayPal</span>
					<span class="fs-payment-icon" title="Apple Pay">Apple</span>
				</div>
			</div>
		</div>
	</div>
</footer>

<?php if ( $show_back_to_top ) : ?>
<button class="fs-back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'flavor-starter' ); ?>" data-action="back-to-top">
	<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>
</button>
<?php endif; ?>

<!-- Quick View Modal -->
<div class="fs-quick-view-modal" aria-hidden="true" role="dialog" aria-label="<?php esc_attr_e( 'Quick View', 'flavor-starter' ); ?>">
	<div class="fs-quick-view-modal__backdrop" data-action="close-quick-view"></div>
	<div class="fs-quick-view-modal__content">
		<button class="fs-quick-view-modal__close" data-action="close-quick-view" aria-label="<?php esc_attr_e( 'Close', 'flavor-starter' ); ?>">&times;</button>
		<div class="fs-quick-view-modal__body">
			<div class="fs-quick-view__loader"><?php esc_html_e( 'Loading…', 'flavor-starter' ); ?></div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
