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
 * Fallback menu
 *------------------------------------------------------------*/
function flavor_starter_fallback_menu() {
	echo '<ul class="fs-nav">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'flavor-starter' ) . '</a></li>';
	if ( class_exists( 'WooCommerce' ) ) {
		echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">' . esc_html__( 'Shop', 'flavor-starter' ) . '</a></li>';
	}
	echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Set Menu', 'flavor-starter' ) . '</a></li>';
	echo '</ul>';
}

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
