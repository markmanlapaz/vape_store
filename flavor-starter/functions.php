<?php
/**
 * Flavor Starter — functions and definitions.
 *
 * @package Flavor_Starter
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/*--------------------------------------------------------------
 * Constants
 *------------------------------------------------------------*/
define( 'FS_VERSION', '1.0.0' );
define( 'FS_DIR', get_template_directory() );
define( 'FS_URI', get_template_directory_uri() );

/*--------------------------------------------------------------
 * Theme Setup
 *------------------------------------------------------------*/
function flavor_starter_setup() {
	// Translation support.
	load_theme_textdomain( 'flavor-starter', FS_DIR . '/languages' );

	// Core supports.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
	) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => '0a0a0f',
	) );

	// WooCommerce supports.
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 400,
		'single_image_width'    => 600,
		'product_grid'          => array(
			'default_rows'    => 4,
			'min_rows'        => 1,
			'default_columns' => 4,
			'min_columns'     => 1,
			'max_columns'     => 6,
		),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Image sizes.
	set_post_thumbnail_size( 400, 400, true );
	add_image_size( 'flavor-hero', 1920, 800, true );
	add_image_size( 'flavor-product-card', 400, 480, true );
	add_image_size( 'flavor-category', 600, 400, true );

	// Navigation menus.
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary Menu', 'flavor-starter' ),
		'mobile'    => esc_html__( 'Mobile Menu', 'flavor-starter' ),
		'footer'    => esc_html__( 'Footer Menu', 'flavor-starter' ),
		'topbar'    => esc_html__( 'Top Bar Menu', 'flavor-starter' ),
	) );
}
add_action( 'after_setup_theme', 'flavor_starter_setup' );

/*--------------------------------------------------------------
 * Content Width
 *------------------------------------------------------------*/
function flavor_starter_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'flavor_starter_content_width', 1280 );
}
add_action( 'after_setup_theme', 'flavor_starter_content_width', 0 );

/*--------------------------------------------------------------
 * Widget Areas
 *------------------------------------------------------------*/
function flavor_starter_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'flavor-starter' ),
		'id'            => 'sidebar-blog',
		'description'   => esc_html__( 'Appears on blog pages.', 'flavor-starter' ),
		'before_widget' => '<section id="%1$s" class="fs-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="fs-widget__title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'flavor-starter' ),
		'id'            => 'sidebar-shop',
		'description'   => esc_html__( 'Appears on WooCommerce shop pages.', 'flavor-starter' ),
		'before_widget' => '<section id="%1$s" class="fs-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="fs-widget__title">',
		'after_title'   => '</h3>',
	) );

	// Footer widget columns.
	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar( array(
			/* translators: %d: footer column number */
			'name'          => sprintf( esc_html__( 'Footer Column %d', 'flavor-starter' ), $i ),
			'id'            => 'footer-' . $i,
			'before_widget' => '<div id="%1$s" class="fs-footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="fs-footer-widget__title">',
			'after_title'   => '</h4>',
		) );
	}
}
add_action( 'widgets_init', 'flavor_starter_widgets_init' );

/*--------------------------------------------------------------
 * Enqueue Styles & Scripts
 *------------------------------------------------------------*/
function flavor_starter_scripts() {
	// Google Fonts — Outfit (headings) + Space Mono (accents) + DM Sans (body).
	wp_enqueue_style(
		'flavor-starter-fonts',
		'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300..700;1,9..40,300..700&family=Outfit:wght@300;400;500;600;700;800;900&family=Space+Mono:wght@400;700&display=swap',
		array(),
		null
	);

	// Main theme stylesheet.
	wp_enqueue_style( 'flavor-starter-style', get_stylesheet_uri(), array(), FS_VERSION );

	// Theme CSS.
	wp_enqueue_style( 'flavor-starter-theme', FS_URI . '/assets/css/theme.css', array(), FS_VERSION );

	// WooCommerce CSS (only when WC is active).
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'flavor-starter-woocommerce', FS_URI . '/assets/css/woocommerce.css', array(), FS_VERSION );
	}

	// Main theme JS.
	wp_enqueue_script( 'flavor-starter-theme', FS_URI . '/assets/js/theme.js', array(), FS_VERSION, true );

	// Localise main script.
	wp_localize_script( 'flavor-starter-theme', 'flavorStarter', array(
		'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
		'nonce'     => wp_create_nonce( 'flavor_starter_nonce' ),
		'cartUrl'   => class_exists( 'WooCommerce' ) ? wc_get_cart_url() : '',
		'shopUrl'   => class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '',
		'i18n'      => array(
			'addedToCart'  => esc_html__( 'Added to cart!', 'flavor-starter' ),
			'viewCart'     => esc_html__( 'View Cart', 'flavor-starter' ),
			'loading'      => esc_html__( 'Loading…', 'flavor-starter' ),
			'quickView'    => esc_html__( 'Quick View', 'flavor-starter' ),
		),
	) );

	// AJAX cart.
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_script( 'flavor-starter-ajax-cart', FS_URI . '/assets/js/ajax-cart.js', array( 'jquery', 'flavor-starter-theme' ), FS_VERSION, true );
		wp_enqueue_script( 'flavor-starter-quick-view', FS_URI . '/assets/js/quick-view.js', array( 'jquery', 'flavor-starter-theme' ), FS_VERSION, true );
	}

	// Age verification.
	$age_verify_enabled = get_theme_mod( 'fs_age_verify_enable', true );
	if ( $age_verify_enabled ) {
		wp_enqueue_script( 'flavor-starter-age-verify', FS_URI . '/assets/js/age-verify.js', array(), FS_VERSION, true );
		wp_localize_script( 'flavor-starter-age-verify', 'flavorAgeVerify', array(
			'title'       => get_theme_mod( 'fs_age_verify_title', __( 'Age Verification', 'flavor-starter' ) ),
			'message'     => get_theme_mod( 'fs_age_verify_message', __( 'You must be at least 21 years old to enter this site.', 'flavor-starter' ) ),
			'confirmText' => get_theme_mod( 'fs_age_verify_confirm', __( 'I am 21 or older', 'flavor-starter' ) ),
			'denyText'    => get_theme_mod( 'fs_age_verify_deny', __( 'I am under 21', 'flavor-starter' ) ),
			'denyUrl'     => get_theme_mod( 'fs_age_verify_deny_url', 'https://www.google.com' ),
			'cookieDays'  => absint( get_theme_mod( 'fs_age_verify_cookie_days', 30 ) ),
		) );
	}

	// Comment reply script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'flavor_starter_scripts' );

/*--------------------------------------------------------------
 * Admin Editor Styles
 *------------------------------------------------------------*/
function flavor_starter_editor_styles() {
	add_editor_style( 'assets/css/theme.css' );
}
add_action( 'admin_init', 'flavor_starter_editor_styles' );

/*--------------------------------------------------------------
 * Include Files
 *------------------------------------------------------------*/
require FS_DIR . '/inc/customizer.php';
require FS_DIR . '/inc/template-tags.php';
require FS_DIR . '/inc/template-functions.php';
require FS_DIR . '/inc/widgets.php';

// WooCommerce integration (only when WC is active).
if ( class_exists( 'WooCommerce' ) ) {
	require FS_DIR . '/inc/woocommerce.php';
	require FS_DIR . '/inc/ajax-handlers.php';
}

/*--------------------------------------------------------------
 * Inline CSS for Customizer values
 *------------------------------------------------------------*/
function flavor_starter_customizer_css() {
	$accent_primary   = get_theme_mod( 'fs_color_accent_primary', '#8b5cf6' );
	$accent_secondary = get_theme_mod( 'fs_color_accent_secondary', '#06b6d4' );
	$accent_tertiary  = get_theme_mod( 'fs_color_accent_tertiary', '#ec4899' );
	$bg_primary       = get_theme_mod( 'fs_color_bg_primary', '#0a0a0f' );
	$bg_secondary     = get_theme_mod( 'fs_color_bg_secondary', '#12121a' );
	$bg_card          = get_theme_mod( 'fs_color_bg_card', '#1a1a25' );
	$text_primary     = get_theme_mod( 'fs_color_text_primary', '#f1f1f4' );
	$text_secondary   = get_theme_mod( 'fs_color_text_secondary', '#a1a1b5' );
	$font_body        = get_theme_mod( 'fs_font_body', "'DM Sans', sans-serif" );
	$font_heading     = get_theme_mod( 'fs_font_heading', "'Outfit', sans-serif" );
	$font_accent      = get_theme_mod( 'fs_font_accent', "'Space Mono', monospace" );

	$css = ":root {
		--fs-accent-primary: {$accent_primary};
		--fs-accent-secondary: {$accent_secondary};
		--fs-accent-tertiary: {$accent_tertiary};
		--fs-bg-primary: {$bg_primary};
		--fs-bg-secondary: {$bg_secondary};
		--fs-bg-card: {$bg_card};
		--fs-text-primary: {$text_primary};
		--fs-text-secondary: {$text_secondary};
		--fs-font-body: {$font_body};
		--fs-font-heading: {$font_heading};
		--fs-font-accent: {$font_accent};
	}";

	wp_add_inline_style( 'flavor-starter-theme', $css );
}
add_action( 'wp_enqueue_scripts', 'flavor_starter_customizer_css', 20 );

/*--------------------------------------------------------------
 * Excerpt length & more
 *------------------------------------------------------------*/
function flavor_starter_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'flavor_starter_excerpt_length' );

function flavor_starter_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'flavor_starter_excerpt_more' );

/*--------------------------------------------------------------
 * Body classes
 *------------------------------------------------------------*/
function flavor_starter_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if ( is_singular() && ! is_page() ) {
		$classes[] = 'has-sidebar';
	}
	$header_layout = get_theme_mod( 'fs_header_layout', 'default' );
	$classes[] = 'header-layout-' . sanitize_html_class( $header_layout );
	return $classes;
}
add_filter( 'body_class', 'flavor_starter_body_classes' );

/*--------------------------------------------------------------
 * Schema.org JSON-LD for shop pages
 *------------------------------------------------------------*/
function flavor_starter_schema_organization() {
	if ( ! is_front_page() ) {
		return;
	}
	$schema = array(
		'@context' => 'https://schema.org',
		'@type'    => 'Store',
		'name'     => get_bloginfo( 'name' ),
		'url'      => home_url( '/' ),
	);
	$logo_id = get_theme_mod( 'custom_logo' );
	if ( $logo_id ) {
		$schema['logo'] = wp_get_attachment_url( $logo_id );
	}
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'flavor_starter_schema_organization' );
