<?php
/**
 * The header template.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary">
	<?php esc_html_e( 'Skip to content', 'flavor-starter' ); ?>
</a>

<?php
// Age verification overlay is injected by JS — see age-verify.js
// Top bar (optional).
$topbar_text = get_theme_mod( 'fs_topbar_text', '' );
$topbar_show = get_theme_mod( 'fs_topbar_show', true );
if ( $topbar_show && $topbar_text ) : ?>
<div class="fs-topbar" role="banner">
	<div class="fs-container fs-topbar__inner">
		<span class="fs-topbar__text"><?php echo wp_kses_post( $topbar_text ); ?></span>
		<?php
		if ( has_nav_menu( 'topbar' ) ) {
			wp_nav_menu( array(
				'theme_location' => 'topbar',
				'container'      => false,
				'menu_class'     => 'fs-topbar__menu',
				'depth'          => 1,
			) );
		}
		?>
		<button class="fs-topbar__close" aria-label="<?php esc_attr_e( 'Close top bar', 'flavor-starter' ); ?>">&times;</button>
	</div>
</div>
<?php endif; ?>

<header id="masthead" class="fs-header" role="banner">
	<div class="fs-container fs-header__inner">

		<!-- Logo / Site Title -->
		<div class="fs-header__brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fs-header__site-title" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<!-- Primary Navigation -->
		<nav class="fs-header__nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'flavor-starter' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'fs-nav',
				'depth'          => 2,
				'fallback_cb'    => 'flavor_starter_fallback_menu',
			) );
			?>
		</nav>

		<!-- Header Actions -->
		<div class="fs-header__actions">
			<!-- Search Toggle -->
			<button class="fs-header__action fs-header__search-toggle" aria-label="<?php esc_attr_e( 'Toggle Search', 'flavor-starter' ); ?>" data-action="toggle-search">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
			</button>

			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<!-- Account -->
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>" class="fs-header__action" aria-label="<?php esc_attr_e( 'My Account', 'flavor-starter' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
				</a>

				<!-- Wishlist (if stored in session/cookie) -->
				<button class="fs-header__action fs-header__wishlist" aria-label="<?php esc_attr_e( 'Wishlist', 'flavor-starter' ); ?>" data-action="toggle-wishlist">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
					<span class="fs-header__badge fs-header__wishlist-count">0</span>
				</button>

				<!-- Cart Drawer Toggle -->
				<button class="fs-header__action fs-header__cart-toggle" aria-label="<?php esc_attr_e( 'Open cart', 'flavor-starter' ); ?>" data-action="toggle-cart">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
					<span class="fs-header__badge fs-header__cart-count"><?php echo class_exists( 'WooCommerce' ) ? esc_html( WC()->cart->get_cart_contents_count() ) : '0'; ?></span>
				</button>
			<?php endif; ?>

			<!-- Mobile Menu Toggle -->
			<button class="fs-header__action fs-header__burger" aria-label="<?php esc_attr_e( 'Toggle Menu', 'flavor-starter' ); ?>" aria-expanded="false" data-action="toggle-mobile-menu">
				<span class="fs-burger-bar"></span>
				<span class="fs-burger-bar"></span>
				<span class="fs-burger-bar"></span>
			</button>
		</div>

	</div>

	<!-- Search Overlay -->
	<div class="fs-search-overlay" aria-hidden="true">
		<div class="fs-container">
			<form role="search" method="get" class="fs-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="search" class="fs-search-form__input" placeholder="<?php esc_attr_e( 'Search products…', 'flavor-starter' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<input type="hidden" name="post_type" value="product" />
				<?php endif; ?>
				<button type="submit" class="fs-search-form__submit" aria-label="<?php esc_attr_e( 'Search', 'flavor-starter' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
				</button>
				<button type="button" class="fs-search-form__close" data-action="toggle-search" aria-label="<?php esc_attr_e( 'Close search', 'flavor-starter' ); ?>">&times;</button>
			</form>
		</div>
	</div>
</header>

<!-- Mobile Navigation Drawer -->
<aside class="fs-mobile-nav" aria-hidden="true" role="navigation" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'flavor-starter' ); ?>">
	<div class="fs-mobile-nav__header">
		<span class="fs-mobile-nav__title"><?php esc_html_e( 'Menu', 'flavor-starter' ); ?></span>
		<button class="fs-mobile-nav__close" data-action="toggle-mobile-menu" aria-label="<?php esc_attr_e( 'Close menu', 'flavor-starter' ); ?>">&times;</button>
	</div>
	<div class="fs-mobile-nav__body">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'mobile',
			'container'      => false,
			'menu_class'     => 'fs-mobile-menu',
			'depth'          => 2,
			'fallback_cb'    => 'flavor_starter_fallback_menu',
		) );
		?>
	</div>
</aside>
<div class="fs-overlay" data-action="close-all" aria-hidden="true"></div>

<?php
// Cart Drawer.
if ( class_exists( 'WooCommerce' ) ) {
	get_template_part( 'template-parts/cart-drawer' );
}
?>
