<?php
/**
 * Template Part: No results found.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="fs-no-results">
	<div class="fs-no-results__content">
		<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--fs-text-secondary)" stroke-width="1"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
		<?php if ( is_search() ) : ?>
			<h2 class="fs-no-results__title"><?php esc_html_e( 'No results found', 'flavor-starter' ); ?></h2>
			<p class="fs-no-results__text"><?php esc_html_e( 'Sorry, nothing matched your search terms. Try different keywords.', 'flavor-starter' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<h2 class="fs-no-results__title"><?php esc_html_e( 'Nothing here yet', 'flavor-starter' ); ?></h2>
			<p class="fs-no-results__text"><?php esc_html_e( 'Ready to publish your first post?', 'flavor-starter' ); ?></p>
		<?php endif; ?>
	</div>
</section>
