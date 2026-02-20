<?php
/**
 * Template Name: About Us
 * Page template for the About Us page.
 *
 * @package Flavor_Starter
 */

get_header();
?>

<main id="primary" class="fs-main" role="main">

	<!-- Page Hero -->
	<div class="fs-page-hero">
		<div class="fs-container">
			<nav class="fs-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'flavor-starter' ); ?>">
				<span class="fs-breadcrumb__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'flavor-starter' ); ?></a></span>
				<span class="fs-breadcrumb__sep">/</span>
				<span class="fs-breadcrumb__item"><?php esc_html_e( 'About Us', 'flavor-starter' ); ?></span>
			</nav>
			<h1 class="fs-page-hero__title"><?php esc_html_e( 'About Flavour Starter', 'flavor-starter' ); ?></h1>
			<p class="fs-page-hero__subtitle"><?php esc_html_e( 'Ontario\'s trusted source for premium vaping products since 2016.', 'flavor-starter' ); ?></p>
		</div>
	</div>

	<!-- Mission Section -->
	<section class="fs-section fs-about-mission">
		<div class="fs-container">
			<div class="fs-about-mission__grid">
				<div class="fs-about-mission__content">
					<span class="fs-section__eyebrow"><?php esc_html_e( 'Our Story', 'flavor-starter' ); ?></span>
					<h2 class="fs-about-mission__title"><?php esc_html_e( 'Built by Vapers, for Vapers', 'flavor-starter' ); ?></h2>
					<p><?php esc_html_e( 'Flavour Starter was founded in 2026 by a small group of vaping enthusiasts who were frustrated with the lack of quality and transparency in the local market. What started as a single storefront in the Scarborough Region of Ontario has grown into one of Canada\'s most trusted online vape retailers.', 'flavor-starter' ); ?></p>
					<p><?php esc_html_e( 'We believe that adults who choose to vape deserve access to genuinely premium products at fair prices, backed by honest information and real customer support. That philosophy hasn\'t changed since day one.', 'flavor-starter' ); ?></p>
					<div class="fs-about-mission__actions">
						<?php
						$shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
						$contact_page = get_page_by_path( 'contact' );
						?>
						<a href="<?php echo esc_url( $shop_url ); ?>" class="fs-btn fs-btn--primary"><?php esc_html_e( 'Shop Now', 'flavor-starter' ); ?></a>
						<?php if ( $contact_page ) : ?>
							<a href="<?php echo esc_url( get_permalink( $contact_page->ID ) ); ?>" class="fs-btn fs-btn--outline"><?php esc_html_e( 'Get in Touch', 'flavor-starter' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
				<div class="fs-about-mission__visual">
					<div class="fs-about-visual-card">
						<div class="fs-about-visual-card__inner">
							<svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" width="120" height="120" aria-hidden="true">
								<circle cx="100" cy="100" r="90" stroke="var(--fs-accent-primary)" stroke-width="2" stroke-dasharray="8 4" opacity="0.3"/>
								<circle cx="100" cy="100" r="60" fill="var(--fs-bg-card)" stroke="var(--fs-accent-primary)" stroke-width="1.5" opacity="0.6"/>
								<path d="M80 80 Q100 60 120 80 Q130 100 120 120 Q100 140 80 120 Q70 100 80 80Z" fill="var(--fs-accent-primary)" opacity="0.15"/>
								<text x="100" y="107" text-anchor="middle" font-family="inherit" font-size="14" font-weight="700" fill="var(--fs-accent-primary)">VC</text>
							</svg>
							<div class="fs-about-visual-card__badge">
								<span><?php esc_html_e( 'Est. 2016', 'flavor-starter' ); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Stats -->
	<section class="fs-about-stats">
		<div class="fs-container">
			<div class="fs-about-stats__grid">
				<div class="fs-about-stat">
					<span class="fs-about-stat__number">8+</span>
					<span class="fs-about-stat__label"><?php esc_html_e( 'Years in Business', 'flavor-starter' ); ?></span>
				</div>
				<div class="fs-about-stat">
					<span class="fs-about-stat__number">500+</span>
					<span class="fs-about-stat__label"><?php esc_html_e( 'Products Available', 'flavor-starter' ); ?></span>
				</div>
				<div class="fs-about-stat">
					<span class="fs-about-stat__number">50+</span>
					<span class="fs-about-stat__label"><?php esc_html_e( 'Top Brands', 'flavor-starter' ); ?></span>
				</div>
				<div class="fs-about-stat">
					<span class="fs-about-stat__number">24h</span>
					<span class="fs-about-stat__label"><?php esc_html_e( 'Order Processing', 'flavor-starter' ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<!-- Values -->
	<section class="fs-section fs-about-values">
		<div class="fs-container">
			<div class="fs-section__header">
				<h2 class="fs-section__title"><?php esc_html_e( 'What We Stand For', 'flavor-starter' ); ?></h2>
				<p class="fs-section__subtitle"><?php esc_html_e( 'Every decision we make comes back to these core principles.', 'flavor-starter' ); ?></p>
			</div>
			<div class="fs-about-values__grid">
				<div class="fs-about-value-card">
					<div class="fs-about-value-card__icon">
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					</div>
					<h3 class="fs-about-value-card__title"><?php esc_html_e( 'Product Authenticity', 'flavor-starter' ); ?></h3>
					<p class="fs-about-value-card__text"><?php esc_html_e( 'Every product we carry is sourced directly from authorized distributors and verified manufacturers. No fakes, no grey-market imports — ever.', 'flavor-starter' ); ?></p>
				</div>
				<div class="fs-about-value-card">
					<div class="fs-about-value-card__icon">
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
					</div>
					<h3 class="fs-about-value-card__title"><?php esc_html_e( 'Fast & Reliable Shipping', 'flavor-starter' ); ?></h3>
					<p class="fs-about-value-card__text"><?php esc_html_e( 'Orders placed before 2PM ET ship the same business day. We use tracked Canada Post and courier services to ensure your order arrives safely and on time.', 'flavor-starter' ); ?></p>
				</div>
				<div class="fs-about-value-card">
					<div class="fs-about-value-card__icon">
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
					</div>
					<h3 class="fs-about-value-card__title"><?php esc_html_e( 'Real Customer Support', 'flavor-starter' ); ?></h3>
					<p class="fs-about-value-card__text"><?php esc_html_e( 'Our team is made up of actual vapers who know the products inside and out. Whether you\'re a first-timer or a seasoned enthusiast, we\'re here to help you find exactly what you need.', 'flavor-starter' ); ?></p>
				</div>
				<div class="fs-about-value-card">
					<div class="fs-about-value-card__icon">
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
					</div>
					<h3 class="fs-about-value-card__title"><?php esc_html_e( 'Curated Selection', 'flavor-starter' ); ?></h3>
					<p class="fs-about-value-card__text"><?php esc_html_e( 'We don\'t just list everything that exists. Our buying team tests and evaluates products before they make it onto our shelves, so you can shop with confidence.', 'flavor-starter' ); ?></p>
				</div>
				<div class="fs-about-value-card">
					<div class="fs-about-value-card__icon">
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
					</div>
					<h3 class="fs-about-value-card__title"><?php esc_html_e( 'Fair & Transparent Pricing', 'flavor-starter' ); ?></h3>
					<p class="fs-about-value-card__text"><?php esc_html_e( 'The price you see is the price we charge. Excise taxes are shown separately at checkout — just like GST/HST — so you always know exactly what you\'re paying and why.', 'flavor-starter' ); ?></p>
				</div>
				<div class="fs-about-value-card">
					<div class="fs-about-value-card__icon">
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
					</div>
					<h3 class="fs-about-value-card__title"><?php esc_html_e( 'Community First', 'flavor-starter' ); ?></h3>
					<p class="fs-about-value-card__text"><?php esc_html_e( 'We\'re active advocates for sensible vaping regulations in Canada. We believe informed adults should have access to quality alternatives to smoking, and we work to support that cause.', 'flavor-starter' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="fs-about-cta">
		<div class="fs-container">
			<div class="fs-about-cta__inner">
				<h2 class="fs-about-cta__title"><?php esc_html_e( 'Ready to Explore Our Selection?', 'flavor-starter' ); ?></h2>
				<p class="fs-about-cta__text"><?php esc_html_e( 'Browse hundreds of products from the world\'s top vaping brands, all verified and in-stock.', 'flavor-starter' ); ?></p>
				<div class="fs-about-cta__actions">
					<a href="<?php echo esc_url( $shop_url ); ?>" class="fs-btn fs-btn--primary fs-btn--lg">
						<?php esc_html_e( 'Shop All Products', 'flavor-starter' ); ?>
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				</div>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
