<?php
/**
 * Template tags — reusable display helpers.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

/*--------------------------------------------------------------
 * Pagination
 *------------------------------------------------------------*/
function flavor_starter_pagination() {
	the_posts_pagination( array(
		'mid_size'  => 2,
		'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>',
		'next_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>',
		'class'     => 'fs-pagination',
	) );
}

/*--------------------------------------------------------------
 * Star Rating
 *------------------------------------------------------------*/
function flavor_starter_star_rating( $rating ) {
	$rating  = floatval( $rating );
	$full    = floor( $rating );
	$half    = ( $rating - $full ) >= 0.5 ? 1 : 0;
	$empty   = 5 - $full - $half;

	echo '<span class="fs-stars" aria-label="' . esc_attr( sprintf( __( '%s out of 5 stars', 'flavor-starter' ), $rating ) ) . '">';
	for ( $i = 0; $i < $full; $i++ ) {
		echo '<svg class="fs-star fs-star--full" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>';
	}
	if ( $half ) {
		echo '<svg class="fs-star fs-star--half" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><defs><linearGradient id="half-grad"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="transparent"/></linearGradient></defs><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" fill="url(#half-grad)"/></svg>';
	}
	for ( $i = 0; $i < $empty; $i++ ) {
		echo '<svg class="fs-star fs-star--empty" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>';
	}
	echo '</span>';
}

/*--------------------------------------------------------------
 * Product Badges
 *------------------------------------------------------------*/
function flavor_starter_product_badges( $product ) {
	if ( ! is_a( $product, 'WC_Product' ) ) {
		return;
	}

	$badges = array();

	if ( $product->is_on_sale() ) {
		$regular = floatval( $product->get_regular_price() );
		$sale    = floatval( $product->get_sale_price() );
		if ( $regular > 0 ) {
			$pct = round( ( ( $regular - $sale ) / $regular ) * 100 );
			$badges[] = '<span class="fs-badge fs-badge--sale">-' . esc_html( $pct ) . '%</span>';
		} else {
			$badges[] = '<span class="fs-badge fs-badge--sale">' . esc_html__( 'Sale', 'flavor-starter' ) . '</span>';
		}
	}

	// "New" if published in the last 30 days.
	$thirty_days_ago = strtotime( '-30 days' );
	$post_date       = get_post_time( 'U', false, $product->get_id() );
	if ( $post_date && $post_date >= $thirty_days_ago ) {
		$badges[] = '<span class="fs-badge fs-badge--new">' . esc_html__( 'New', 'flavor-starter' ) . '</span>';
	}

	// Featured = Popular.
	if ( $product->is_featured() ) {
		$badges[] = '<span class="fs-badge fs-badge--popular">' . esc_html__( 'Popular', 'flavor-starter' ) . '</span>';
	}

	if ( ! $product->is_in_stock() ) {
		$badges[] = '<span class="fs-badge fs-badge--sold-out">' . esc_html__( 'Sold Out', 'flavor-starter' ) . '</span>';
	}

	if ( ! empty( $badges ) ) {
		echo '<div class="fs-badges">' . implode( '', $badges ) . '</div>';
	}
}

/*--------------------------------------------------------------
 * Social Media Links
 *------------------------------------------------------------*/
function flavor_starter_social_links() {
	$socials = array(
		'fs_social_facebook'  => array( 'Facebook',  '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>' ),
		'fs_social_instagram' => array( 'Instagram', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>' ),
		'fs_social_twitter'   => array( 'X',         '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>' ),
		'fs_social_youtube'   => array( 'YouTube',   '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>' ),
		'fs_social_tiktok'    => array( 'TikTok',    '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1v-3.5a6.37 6.37 0 0 0-.79-.05A6.34 6.34 0 0 0 3.15 15a6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.34-6.34V8.52a8.27 8.27 0 0 0 4.85 1.56V6.69h-1.09z"/></svg>' ),
	);

	$output = '<div class="fs-social-links">';
	$has_any = false;

	foreach ( $socials as $mod => $data ) {
		$url = get_theme_mod( $mod, '' );
		if ( $url ) {
			$has_any = true;
			$output .= '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer" class="fs-social-link" aria-label="' . esc_attr( $data[0] ) . '">' . $data[1] . '</a>';
		}
	}

	$output .= '</div>';

	if ( $has_any ) {
		echo $output;
	}
}

/*--------------------------------------------------------------
 * Fallback menu — shown when no WordPress menu is assigned.
 *------------------------------------------------------------*/
function flavor_starter_fallback_menu() {
	$wc   = class_exists( 'WooCommerce' );
	$shop = $wc ? wc_get_page_permalink( 'shop' ) : home_url( '/' );

	/**
	 * Return a WooCommerce product-category archive URL.
	 * Falls back to the shop URL with a query-string filter if the term
	 * does not exist yet.
	 */
	$cat = function( $slug ) use ( $wc, $shop ) {
		if ( ! $wc ) {
			return $shop;
		}
		$term = get_term_by( 'slug', $slug, 'product_cat' );
		if ( $term && ! is_wp_error( $term ) ) {
			$url = get_term_link( $term );
			return is_wp_error( $url ) ? $shop : $url;
		}
		return add_query_arg( 'product_cat', $slug, $shop );
	};

	/**
	 * Return a WordPress page URL by its path/slug.
	 * Falls back to home_url( '/slug/' ) if the page does not exist yet.
	 */
	$pg = function( $path ) {
		$page = get_page_by_path( $path );
		return $page ? get_permalink( $page->ID ) : home_url( '/' . ltrim( $path, '/' ) . '/' );
	};

	$chevron = '<svg class="fs-nav__chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>';

	$items = array(
		array(
			'label'    => __( 'Devices', 'flavor-starter' ),
			'url'      => $cat( 'devices-kits' ),
			'children' => array(
				array( 'label' => __( 'Disposable Vapes',   'flavor-starter' ), 'url' => $cat( 'disposable-vapes' ) ),
				array( 'label' => __( 'Closed Pod Devices', 'flavor-starter' ), 'url' => $cat( 'closed-pod-devices' ) ),
				array( 'label' => __( 'Open Pod Devices',   'flavor-starter' ), 'url' => $cat( 'open-pod-devices' ) ),
				array( 'label' => __( 'Devices & Kits',     'flavor-starter' ), 'url' => $cat( 'devices-kits' ) ),
				array( 'label' => __( 'RDA & RDTA',         'flavor-starter' ), 'url' => $cat( 'rda-rdta' ) ),
			),
		),
		array(
			'label'    => __( 'E-Liquid', 'flavor-starter' ),
			'url'      => $cat( 'e-liquid' ),
			'children' => array(
				array( 'label' => __( 'Salt Nic', 'flavor-starter' ), 'url' => $cat( 'salt-nic' ) ),
				array( 'label' => __( 'Freebase', 'flavor-starter' ), 'url' => $cat( 'freebase' ) ),
			),
		),
		array(
			'label' => __( 'Coils & Pods', 'flavor-starter' ),
			'url'   => $cat( 'coils-pods' ),
		),
		array(
			'label'    => __( 'Accessories', 'flavor-starter' ),
			'url'      => $cat( 'accessories' ),
			'children' => array(
				array( 'label' => __( 'Vape Parts', 'flavor-starter' ), 'url' => $cat( 'vape-parts' ) ),
			),
		),
		array(
			'label'    => __( 'Information', 'flavor-starter' ),
			'url'      => '#',
			'children' => array(
				array( 'label' => __( 'Tax Information', 'flavor-starter' ), 'url' => $pg( 'tax-information' ) ),
				array( 'label' => __( 'About Us',        'flavor-starter' ), 'url' => $pg( 'about' ) ),
				array( 'label' => __( 'Contact',         'flavor-starter' ), 'url' => $pg( 'contact' ) ),
			),
		),
	);

	echo '<ul class="fs-nav">';
	foreach ( $items as $item ) {
		$has = ! empty( $item['children'] );
		echo '<li' . ( $has ? ' class="menu-item-has-children"' : '' ) . '>';
		echo '<a href="' . esc_url( $item['url'] ) . '"' . ( $has ? ' aria-haspopup="true" aria-expanded="false"' : '' ) . '>';
		echo esc_html( $item['label'] );
		if ( $has ) {
			echo $chevron; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo '</a>';
		if ( $has ) {
			echo '<ul class="sub-menu">';
			foreach ( $item['children'] as $child ) {
				echo '<li><a href="' . esc_url( $child['url'] ) . '">' . esc_html( $child['label'] ) . '</a></li>';
			}
			echo '</ul>';
		}
		echo '</li>';
	}
	echo '</ul>';
}

/*--------------------------------------------------------------
 * Inject chevron SVG into top-level items that have children
 * when WordPress renders a real assigned menu.
 *------------------------------------------------------------*/
function flavor_starter_nav_item_chevron( $item_output, $item, $depth, $args ) {
	if ( $depth > 0 ) {
		return $item_output;
	}
	if ( ! in_array( $args->theme_location, array( 'primary', 'mobile' ), true ) ) {
		return $item_output;
	}
	if ( ! in_array( 'menu-item-has-children', $item->classes, true ) ) {
		return $item_output;
	}
	$chevron = '<svg class="fs-nav__chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>';
	return str_replace( '</a>', $chevron . '</a>', $item_output );
}
add_filter( 'walker_nav_menu_start_el', 'flavor_starter_nav_item_chevron', 10, 4 );

/*--------------------------------------------------------------
 * Auto-create the primary navigation menu on theme activation.
 * Runs once via after_switch_theme; skips if already created.
 *------------------------------------------------------------*/
function flavor_starter_create_default_menus() {
	if ( get_option( 'fs_default_menu_created' ) ) {
		return;
	}

	$wc   = class_exists( 'WooCommerce' );
	$shop = $wc ? wc_get_page_permalink( 'shop' ) : home_url( '/' );

	$cat = function( $slug ) use ( $wc, $shop ) {
		if ( ! $wc ) {
			return $shop;
		}
		$term = get_term_by( 'slug', $slug, 'product_cat' );
		if ( $term && ! is_wp_error( $term ) ) {
			$url = get_term_link( $term );
			return is_wp_error( $url ) ? $shop : $url;
		}
		return add_query_arg( 'product_cat', $slug, $shop );
	};

	$pg = function( $path ) {
		$page = get_page_by_path( $path );
		return $page ? get_permalink( $page->ID ) : home_url( '/' . ltrim( $path, '/' ) . '/' );
	};

	$menu_name = _x( 'Primary Menu', 'nav menu name', 'flavor-starter' );
	$menu_id   = wp_create_nav_menu( $menu_name );
	if ( is_wp_error( $menu_id ) ) {
		$existing = wp_get_nav_menu_object( $menu_name );
		if ( ! $existing ) {
			update_option( 'fs_default_menu_created', true );
			return;
		}
		$menu_id = (int) $existing->term_id;
	}

	$structure = array(
		array(
			'title'    => __( 'Devices', 'flavor-starter' ),
			'url'      => $cat( 'devices-kits' ),
			'children' => array(
				array( 'title' => __( 'Disposable Vapes',   'flavor-starter' ), 'url' => $cat( 'disposable-vapes' ) ),
				array( 'title' => __( 'Closed Pod Devices', 'flavor-starter' ), 'url' => $cat( 'closed-pod-devices' ) ),
				array( 'title' => __( 'Open Pod Devices',   'flavor-starter' ), 'url' => $cat( 'open-pod-devices' ) ),
				array( 'title' => __( 'Devices & Kits',     'flavor-starter' ), 'url' => $cat( 'devices-kits' ) ),
				array( 'title' => __( 'RDA & RDTA',         'flavor-starter' ), 'url' => $cat( 'rda-rdta' ) ),
			),
		),
		array(
			'title'    => __( 'E-Liquid', 'flavor-starter' ),
			'url'      => $cat( 'e-liquid' ),
			'children' => array(
				array( 'title' => __( 'Salt Nic', 'flavor-starter' ), 'url' => $cat( 'salt-nic' ) ),
				array( 'title' => __( 'Freebase', 'flavor-starter' ), 'url' => $cat( 'freebase' ) ),
			),
		),
		array(
			'title' => __( 'Coils & Pods', 'flavor-starter' ),
			'url'   => $cat( 'coils-pods' ),
		),
		array(
			'title'    => __( 'Accessories', 'flavor-starter' ),
			'url'      => $cat( 'accessories' ),
			'children' => array(
				array( 'title' => __( 'Vape Parts', 'flavor-starter' ), 'url' => $cat( 'vape-parts' ) ),
			),
		),
		array(
			'title'    => __( 'Information', 'flavor-starter' ),
			'url'      => '#',
			'children' => array(
				array( 'title' => __( 'Tax Information', 'flavor-starter' ), 'url' => $pg( 'tax-information' ) ),
				array( 'title' => __( 'About Us',        'flavor-starter' ), 'url' => $pg( 'about' ) ),
				array( 'title' => __( 'Contact',         'flavor-starter' ), 'url' => $pg( 'contact' ) ),
			),
		),
	);

	foreach ( $structure as $item ) {
		$parent_id = wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'  => $item['title'],
			'menu-item-url'    => $item['url'],
			'menu-item-status' => 'publish',
			'menu-item-type'   => 'custom',
		) );
		if ( ! is_wp_error( $parent_id ) && ! empty( $item['children'] ) ) {
			foreach ( $item['children'] as $child ) {
				wp_update_nav_menu_item( $menu_id, 0, array(
					'menu-item-title'     => $child['title'],
					'menu-item-url'       => $child['url'],
					'menu-item-status'    => 'publish',
					'menu-item-type'      => 'custom',
					'menu-item-parent-id' => $parent_id,
				) );
			}
		}
	}

	// Assign to primary and mobile locations only if not already set.
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	foreach ( array( 'primary', 'mobile' ) as $location ) {
		if ( empty( $locations[ $location ] ) ) {
			$locations[ $location ] = $menu_id;
		}
	}
	set_theme_mod( 'nav_menu_locations', $locations );
	update_option( 'fs_default_menu_created', true );
}
add_action( 'after_switch_theme', 'flavor_starter_create_default_menus' );

/*--------------------------------------------------------------
 * Comment callback
 *------------------------------------------------------------*/
function flavor_starter_comment( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	?>
	<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'fs-comment' ); ?>>
		<article class="fs-comment__body">
			<header class="fs-comment__header">
				<?php echo get_avatar( $comment, 40, '', '', array( 'class' => 'fs-comment__avatar' ) ); ?>
				<div class="fs-comment__meta">
					<span class="fs-comment__author"><?php echo get_comment_author_link(); ?></span>
					<time class="fs-comment__date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>">
						<?php echo esc_html( get_comment_date() ); ?>
					</time>
				</div>
			</header>
			<?php if ( '0' === $comment->comment_approved ) : ?>
				<p class="fs-comment__moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'flavor-starter' ); ?></p>
			<?php endif; ?>
			<div class="fs-comment__content"><?php comment_text(); ?></div>
			<?php
			comment_reply_link( array_merge( $args, array(
				'depth'     => $depth,
				'max_depth' => $args['max_depth'],
				'before'    => '<div class="fs-comment__reply">',
				'after'     => '</div>',
			) ) );
			?>
		</article>
	<?php
}
