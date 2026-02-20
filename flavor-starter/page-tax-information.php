<?php
/**
 * Template Name: Tax Information
 * Page template for the vaping excise tax information page.
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
				<span class="fs-breadcrumb__item"><?php esc_html_e( 'Tax Information', 'flavor-starter' ); ?></span>
			</nav>
			<h1 class="fs-page-hero__title"><?php esc_html_e( 'Vaping Excise Tax', 'flavor-starter' ); ?></h1>
			<p class="fs-page-hero__subtitle"><?php esc_html_e( 'Everything you need to know about federal and provincial excise taxes on vaping products.', 'flavor-starter' ); ?></p>
		</div>
	</div>

	<div class="fs-container fs-info-container">
		<div class="fs-tax-layout">

			<!-- Tax Info Sections -->
			<div class="fs-tax-content">

				<!-- What is it? -->
				<div class="fs-tax-section">
					<div class="fs-tax-section__icon" aria-hidden="true">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
					</div>
					<div class="fs-tax-section__body">
						<h2 class="fs-tax-section__title"><?php esc_html_e( 'What Is It?', 'flavor-starter' ); ?></h2>
						<p><?php esc_html_e( 'The federal and provincial governments introduced the excise tax on vaping products in October of 2022 and July of 2024. Similar to the excise taxes found on tobacco, cannabis and alcohol. While some provinces only collect federal excise on vaping products, some collect both federal and provincial excise.', 'flavor-starter' ); ?></p>

						<div class="fs-tax-provinces">
							<div class="fs-tax-province-card fs-tax-province-card--federal">
								<h3 class="fs-tax-province-card__label"><?php esc_html_e( 'Federal Excise Only', 'flavor-starter' ); ?></h3>
								<ul class="fs-tax-province-card__list">
									<li><?php esc_html_e( 'British Columbia', 'flavor-starter' ); ?></li>
									<li><?php esc_html_e( 'Saskatchewan', 'flavor-starter' ); ?></li>
									<li><?php esc_html_e( 'Newfoundland', 'flavor-starter' ); ?></li>
									<li><?php esc_html_e( 'Nova Scotia', 'flavor-starter' ); ?></li>
								</ul>
							</div>
							<div class="fs-tax-province-card fs-tax-province-card--both">
								<h3 class="fs-tax-province-card__label"><?php esc_html_e( 'Federal + Provincial Excise', 'flavor-starter' ); ?></h3>
								<ul class="fs-tax-province-card__list">
									<li><?php esc_html_e( 'Alberta', 'flavor-starter' ); ?></li>
									<li><?php esc_html_e( 'Manitoba', 'flavor-starter' ); ?></li>
									<li><?php esc_html_e( 'PEI', 'flavor-starter' ); ?></li>
									<li><?php esc_html_e( 'New Brunswick', 'flavor-starter' ); ?></li>
									<li><?php esc_html_e( 'Ontario', 'flavor-starter' ); ?></li>
									<li><?php esc_html_e( 'Quebec', 'flavor-starter' ); ?></li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<!-- How is it calculated? -->
				<div class="fs-tax-section">
					<div class="fs-tax-section__icon" aria-hidden="true">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="10" x2="16" y2="10"/><line x1="8" y1="14" x2="16" y2="14"/><line x1="8" y1="18" x2="12" y2="18"/></svg>
					</div>
					<div class="fs-tax-section__body">
						<h2 class="fs-tax-section__title"><?php esc_html_e( 'How Is It Calculated?', 'flavor-starter' ); ?></h2>
						<p><?php esc_html_e( 'Excise tax is only applied to vaping liquids and products that contain vaping liquid. The rate is doubled in provinces that collect both federal and provincial excise tax. The rate is calculated based on the volume of liquid:', 'flavor-starter' ); ?></p>

						<div class="fs-tax-rate-box">
							<div class="fs-tax-rate-item">
								<span class="fs-tax-rate-item__amount">$1.12</span>
								<span class="fs-tax-rate-item__desc"><?php esc_html_e( 'per 2ml for the first 10ml of vaping substance', 'flavor-starter' ); ?></span>
							</div>
							<div class="fs-tax-rate-item">
								<span class="fs-tax-rate-item__amount">$1.12</span>
								<span class="fs-tax-rate-item__desc"><?php esc_html_e( 'per additional 10ml', 'flavor-starter' ); ?></span>
							</div>
						</div>

						<div class="fs-tax-examples">
							<div class="fs-tax-example">
								<h3 class="fs-tax-example__title"><?php esc_html_e( 'Federal Excise Only', 'flavor-starter' ); ?></h3>
								<table class="fs-tax-table">
									<thead>
										<tr>
											<th><?php esc_html_e( 'Size', 'flavor-starter' ); ?></th>
											<th><?php esc_html_e( 'Tax', 'flavor-starter' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr><td>30ml</td><td>$7.84</td></tr>
										<tr><td>60ml</td><td>$11.20</td></tr>
										<tr><td>120ml</td><td>$17.92</td></tr>
									</tbody>
								</table>
							</div>
							<div class="fs-tax-example">
								<h3 class="fs-tax-example__title"><?php esc_html_e( 'Federal + Provincial', 'flavor-starter' ); ?></h3>
								<table class="fs-tax-table">
									<thead>
										<tr>
											<th><?php esc_html_e( 'Size', 'flavor-starter' ); ?></th>
											<th><?php esc_html_e( 'Fed', 'flavor-starter' ); ?></th>
											<th><?php esc_html_e( 'Prov', 'flavor-starter' ); ?></th>
											<th><?php esc_html_e( 'Total', 'flavor-starter' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr><td>30ml</td><td>$7.84</td><td>$7.84</td><td class="fs-tax-table__total">$15.68</td></tr>
										<tr><td>60ml</td><td>$11.20</td><td>$11.20</td><td class="fs-tax-table__total">$22.40</td></tr>
										<tr><td>120ml</td><td>$17.92</td><td>$17.92</td><td class="fs-tax-table__total">$35.84</td></tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<!-- How are charges shown? -->
				<div class="fs-tax-section">
					<div class="fs-tax-section__icon" aria-hidden="true">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
					</div>
					<div class="fs-tax-section__body">
						<h2 class="fs-tax-section__title"><?php esc_html_e( 'How Are These Charges Shown When Shopping Online?', 'flavor-starter' ); ?></h2>
						<p><?php esc_html_e( 'When shopping online, the price you see listed on each product is the retail price. This is the price we charge, with no excise tax included. When you proceed to checkout, you will be prompted to accept these taxes so they can be added to your total. You must accept to proceed through checkout. Declining the taxes will remove the product from your cart.', 'flavor-starter' ); ?></p>
						<p><?php esc_html_e( 'Previously these taxes were worked in to our retail price, but we have since separated them in an effort to allow our customers to accurately see exactly what we charge versus what we are required to collect. Similar with how sales tax is shown separately from your subtotal on a bill.', 'flavor-starter' ); ?></p>
					</div>
				</div>

				<!-- Questions? -->
				<div class="fs-tax-section fs-tax-section--cta">
					<div class="fs-tax-section__icon" aria-hidden="true">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
					</div>
					<div class="fs-tax-section__body">
						<h2 class="fs-tax-section__title"><?php esc_html_e( 'Have Questions About These Charges?', 'flavor-starter' ); ?></h2>
						<p><?php esc_html_e( 'Excise taxes can be confusing, especially when it differs from province to province. Don\'t worry, we\'re here to help any way we can.', 'flavor-starter' ); ?></p>
						<div class="fs-tax-contact-links">
							<a href="mailto:sales@vapourscanada.com" class="fs-tax-contact-link">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
								sales@vapourscanada.com
							</a>
							<a href="tel:+19054389494" class="fs-tax-contact-link">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.24h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.08 6.08l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 17z"/></svg>
								(905) 438-9494 ext. 2
							</a>
							<?php
							$contact_page = get_page_by_path( 'contact' );
							if ( $contact_page ) : ?>
								<a href="<?php echo esc_url( get_permalink( $contact_page->ID ) ); ?>" class="fs-btn fs-btn--primary fs-btn--sm">
									<?php esc_html_e( 'Contact Us', 'flavor-starter' ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>

			</div><!-- /.fs-tax-content -->
		</div><!-- /.fs-tax-layout -->
	</div><!-- /.fs-container -->

</main>

<?php get_footer(); ?>
