<?php
/**
 * Template Name: Contact
 * Contact page with form processing and contact details.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

/* -----------------------------------------------------------------
 * Process contact form submission
 * ----------------------------------------------------------------- */
$fs_contact_status = '';

if ( isset( $_POST['fs_contact_submit'] ) ) {
	// Verify nonce.
	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ), 'fs_contact_form' ) ) {
		wp_die( esc_html__( 'Security check failed. Please go back and try again.', 'flavor-starter' ) );
	}

	// Sanitize inputs.
	$fs_name    = sanitize_text_field( wp_unslash( $_POST['contact_name'] ?? '' ) );
	$fs_email   = sanitize_email( wp_unslash( $_POST['contact_email'] ?? '' ) );
	$fs_phone   = sanitize_text_field( wp_unslash( $_POST['contact_phone'] ?? '' ) );
	$fs_message = sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ?? '' ) );

	// Validate required fields.
	if ( empty( $fs_name ) || empty( $fs_email ) || ! is_email( $fs_email ) || empty( $fs_message ) ) {
		$fs_contact_status = 'error-validation';
	} else {
		$to      = get_option( 'admin_email' );
		$subject = sprintf(
			/* translators: %s: sender name */
			__( 'Website Contact: Message from %s', 'flavor-starter' ),
			$fs_name
		);
		$body = sprintf(
			"Name: %s\nEmail: %s\nPhone: %s\n\n---\n\n%s",
			$fs_name,
			$fs_email,
			$fs_phone ?: __( 'Not provided', 'flavor-starter' ),
			$fs_message
		);
		$headers = array(
			'Content-Type: text/plain; charset=UTF-8',
			'Reply-To: ' . $fs_name . ' <' . $fs_email . '>',
		);

		$sent = wp_mail( $to, $subject, $body, $headers );
		wp_safe_redirect( add_query_arg( 'contact', $sent ? 'sent' : 'error', get_permalink() ) );
		exit;
	}
}

$contact_result = isset( $_GET['contact'] ) ? sanitize_key( $_GET['contact'] ) : '';

get_header();
?>

<main id="primary" class="fs-main" role="main">

	<!-- Page Hero -->
	<div class="fs-page-hero">
		<div class="fs-container">
			<nav class="fs-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'flavor-starter' ); ?>">
				<span class="fs-breadcrumb__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'flavor-starter' ); ?></a></span>
				<span class="fs-breadcrumb__sep">/</span>
				<span class="fs-breadcrumb__item"><?php esc_html_e( 'Contact', 'flavor-starter' ); ?></span>
			</nav>
			<h1 class="fs-page-hero__title"><?php esc_html_e( 'Get in Touch', 'flavor-starter' ); ?></h1>
			<p class="fs-page-hero__subtitle"><?php esc_html_e( 'Questions, order issues, or just want to say hello — we\'d love to hear from you.', 'flavor-starter' ); ?></p>
		</div>
	</div>

	<div class="fs-container fs-info-container">
		<div class="fs-contact-layout">

			<!-- ── Contact Form ─────────────────────────────────── -->
			<div class="fs-contact-form-wrap">
				<h2 class="fs-contact-form-wrap__title"><?php esc_html_e( 'Send Us a Message', 'flavor-starter' ); ?></h2>

				<?php if ( 'sent' === $contact_result ) : ?>
					<div class="fs-contact-notice fs-contact-notice--success" role="alert">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
						<?php esc_html_e( 'Message sent! We\'ll get back to you within 1 business day.', 'flavor-starter' ); ?>
					</div>
				<?php elseif ( 'error' === $contact_result ) : ?>
					<div class="fs-contact-notice fs-contact-notice--error" role="alert">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
						<?php esc_html_e( 'Something went wrong sending your message. Please try again or reach us directly by phone or email.', 'flavor-starter' ); ?>
					</div>
				<?php elseif ( 'error-validation' === $fs_contact_status ) : ?>
					<div class="fs-contact-notice fs-contact-notice--error" role="alert">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
						<?php esc_html_e( 'Please fill in all required fields with a valid email address.', 'flavor-starter' ); ?>
					</div>
				<?php endif; ?>

				<form
					class="fs-contact-form"
					method="post"
					action="<?php echo esc_url( get_permalink() ); ?>"
					novalidate
				>
					<?php wp_nonce_field( 'fs_contact_form' ); ?>

					<div class="fs-form-row fs-form-row--2col">
						<div class="fs-form-group">
							<label class="fs-form-label" for="contact_name">
								<?php esc_html_e( 'Full Name', 'flavor-starter' ); ?>
								<span class="fs-form-required" aria-hidden="true">*</span>
							</label>
							<input
								type="text"
								id="contact_name"
								name="contact_name"
								class="fs-form-input"
								placeholder="<?php esc_attr_e( 'Jane Smith', 'flavor-starter' ); ?>"
								value="<?php echo isset( $fs_name ) ? esc_attr( $fs_name ) : ''; ?>"
								required
								autocomplete="name"
							/>
						</div>
						<div class="fs-form-group">
							<label class="fs-form-label" for="contact_email">
								<?php esc_html_e( 'Email Address', 'flavor-starter' ); ?>
								<span class="fs-form-required" aria-hidden="true">*</span>
							</label>
							<input
								type="email"
								id="contact_email"
								name="contact_email"
								class="fs-form-input"
								placeholder="<?php esc_attr_e( 'you@example.com', 'flavor-starter' ); ?>"
								value="<?php echo isset( $fs_email ) ? esc_attr( $fs_email ) : ''; ?>"
								required
								autocomplete="email"
							/>
						</div>
					</div>

					<div class="fs-form-group">
						<label class="fs-form-label" for="contact_phone">
							<?php esc_html_e( 'Phone Number', 'flavor-starter' ); ?>
							<span class="fs-form-optional"><?php esc_html_e( '(optional)', 'flavor-starter' ); ?></span>
						</label>
						<input
							type="tel"
							id="contact_phone"
							name="contact_phone"
							class="fs-form-input"
							placeholder="<?php esc_attr_e( '(905) 555-0100', 'flavor-starter' ); ?>"
							value="<?php echo isset( $fs_phone ) ? esc_attr( $fs_phone ) : ''; ?>"
							autocomplete="tel"
						/>
					</div>

					<div class="fs-form-group">
						<label class="fs-form-label" for="contact_message">
							<?php esc_html_e( 'Message', 'flavor-starter' ); ?>
							<span class="fs-form-required" aria-hidden="true">*</span>
						</label>
						<textarea
							id="contact_message"
							name="contact_message"
							class="fs-form-input fs-form-textarea"
							rows="6"
							placeholder="<?php esc_attr_e( 'How can we help you today?', 'flavor-starter' ); ?>"
							required
						><?php echo isset( $fs_message ) ? esc_textarea( $fs_message ) : ''; ?></textarea>
					</div>

					<button type="submit" name="fs_contact_submit" value="1" class="fs-btn fs-btn--primary fs-btn--lg fs-contact-submit">
						<?php esc_html_e( 'Send Message', 'flavor-starter' ); ?>
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
					</button>
				</form>
			</div><!-- /.fs-contact-form-wrap -->

			<!-- ── Contact Info ─────────────────────────────────── -->
			<aside class="fs-contact-info" aria-label="<?php esc_attr_e( 'Contact information', 'flavor-starter' ); ?>">

				<div class="fs-contact-info-card">
					<h2 class="fs-contact-info-card__title"><?php esc_html_e( 'Contact Details', 'flavor-starter' ); ?></h2>

					<ul class="fs-contact-details">
						<li class="fs-contact-detail">
							<span class="fs-contact-detail__icon" aria-hidden="true">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.24h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.08 6.08l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 17z"/></svg>
							</span>
							<div class="fs-contact-detail__body">
								<span class="fs-contact-detail__label"><?php esc_html_e( 'Phone', 'flavor-starter' ); ?></span>
								<a href="tel:+19054389494" class="fs-contact-detail__value">(905) 438-9494</a>
								<span class="fs-contact-detail__note"><?php esc_html_e( 'Ext. 2 for Sales', 'flavor-starter' ); ?></span>
							</div>
						</li>

						<li class="fs-contact-detail">
							<span class="fs-contact-detail__icon" aria-hidden="true">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
							</span>
							<div class="fs-contact-detail__body">
								<span class="fs-contact-detail__label"><?php esc_html_e( 'Email', 'flavor-starter' ); ?></span>
								<a href="mailto:sales@vapourscanada.com" class="fs-contact-detail__value">sales@vapourscanada.com</a>
							</div>
						</li>

						<li class="fs-contact-detail">
							<span class="fs-contact-detail__icon" aria-hidden="true">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
							</span>
							<div class="fs-contact-detail__body">
								<span class="fs-contact-detail__label"><?php esc_html_e( 'Address', 'flavor-starter' ); ?></span>
								<span class="fs-contact-detail__value">1885 Clements Rd, Unit 220</span>
								<span class="fs-contact-detail__note">Pickering, ON  L1W 3V4</span>
							</div>
						</li>
					</ul>

					<div class="fs-contact-hours">
						<h3 class="fs-contact-hours__title"><?php esc_html_e( 'Business Hours', 'flavor-starter' ); ?></h3>
						<ul class="fs-contact-hours__list">
							<li>
								<span><?php esc_html_e( 'Mon – Fri', 'flavor-starter' ); ?></span>
								<span>9:00 AM – 5:00 PM ET</span>
							</li>
							<li>
								<span><?php esc_html_e( 'Saturday', 'flavor-starter' ); ?></span>
								<span>10:00 AM – 3:00 PM ET</span>
							</li>
							<li>
								<span><?php esc_html_e( 'Sunday', 'flavor-starter' ); ?></span>
								<span><?php esc_html_e( 'Closed', 'flavor-starter' ); ?></span>
							</li>
						</ul>
					</div>

					<div class="fs-contact-response">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
						<?php esc_html_e( 'We typically respond within 1 business day.', 'flavor-starter' ); ?>
					</div>
				</div>

			</aside><!-- /.fs-contact-info -->

		</div><!-- /.fs-contact-layout -->
	</div><!-- /.fs-container -->

</main>

<?php get_footer(); ?>
