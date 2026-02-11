<?php
/**
 * Template functions — hooks that modify default output.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

/*--------------------------------------------------------------
 * Move Yoast SEO breadcrumbs into our own container if present
 *------------------------------------------------------------*/
function flavor_starter_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<nav class="fs-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'flavor-starter' ) . '">', '</nav>' );
	}
}

/*--------------------------------------------------------------
 * Wrap search form in our class
 *------------------------------------------------------------*/
function flavor_starter_search_form( $form ) {
	$form = '<form role="search" method="get" class="fs-search-form" action="' . esc_url( home_url( '/' ) ) . '">
		<input type="search" class="fs-search-form__input" placeholder="' . esc_attr__( 'Search…', 'flavor-starter' ) . '" value="' . get_search_query() . '" name="s" />
		<button type="submit" class="fs-search-form__submit" aria-label="' . esc_attr__( 'Search', 'flavor-starter' ) . '">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
		</button>
	</form>';
	return $form;
}
add_filter( 'get_search_form', 'flavor_starter_search_form' );

/*--------------------------------------------------------------
 * Add lazy loading to content images
 *------------------------------------------------------------*/
function flavor_starter_lazy_load_content_images( $content ) {
	if ( is_admin() || wp_doing_ajax() ) {
		return $content;
	}
	// WordPress 5.5+ natively adds loading="lazy", but ensure older embeds also get it.
	$content = preg_replace( '/<img((?!loading=)[^>]*)>/i', '<img$1 loading="lazy">', $content );
	return $content;
}
add_filter( 'the_content', 'flavor_starter_lazy_load_content_images', 99 );

/*--------------------------------------------------------------
 * Preload critical assets
 *------------------------------------------------------------*/
function flavor_starter_preload_assets() {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action( 'wp_head', 'flavor_starter_preload_assets', 1 );
