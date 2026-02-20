<?php
/**
 * WooCommerce Shop / Product Archive.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

get_header();

/* -----------------------------------------------------------------------
 * Build active-filter context used by the strip + sidebar
 * --------------------------------------------------------------------- */

$shop_url      = wc_get_page_permalink( 'shop' );
$current_url   = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$active_filters = array();

// Price range.
$min_price = isset( $_GET['min_price'] ) ? (float) wc_clean( wp_unslash( $_GET['min_price'] ) ) : '';
$max_price = isset( $_GET['max_price'] ) ? (float) wc_clean( wp_unslash( $_GET['max_price'] ) ) : '';

if ( '' !== $min_price || '' !== $max_price ) {
	if ( '' !== $min_price && '' !== $max_price ) {
		$price_label = wc_price( $min_price ) . ' &ndash; ' . wc_price( $max_price );
	} elseif ( '' !== $min_price ) {
		/* translators: %s price */
		$price_label = sprintf( __( 'From %s', 'flavor-starter' ), wc_price( $min_price ) );
	} else {
		/* translators: %s price */
		$price_label = sprintf( __( 'Up to %s', 'flavor-starter' ), wc_price( $max_price ) );
	}
	$active_filters[] = array(
		'label'      => $price_label,
		'remove_url' => remove_query_arg( array( 'min_price', 'max_price' ) ),
	);
}

// Attribute filters (brand, series).
$filter_keys   = array( 'brand', 'series' );
$active_brands = array();
$active_series = array();

foreach ( $filter_keys as $attr ) {
	$param = 'filter_' . $attr;
	if ( empty( $_GET[ $param ] ) ) {
		continue;
	}
	$slugs    = array_filter( explode( ',', wc_clean( wp_unslash( $_GET[ $param ] ) ) ) );
	$taxonomy = 'pa_' . $attr;

	if ( $attr === 'brand' ) {
		$active_brands = $slugs;
	} else {
		$active_series = $slugs;
	}

	foreach ( $slugs as $slug ) {
		if ( ! taxonomy_exists( $taxonomy ) ) {
			continue;
		}
		$term = get_term_by( 'slug', $slug, $taxonomy );
		if ( $term && ! is_wp_error( $term ) ) {
			$other_slugs  = array_diff( $slugs, array( $slug ) );
			$remove_url   = empty( $other_slugs )
				? remove_query_arg( $param )
				: add_query_arg( $param, implode( ',', $other_slugs ) );
			$active_filters[] = array(
				'label'      => $term->name,
				'remove_url' => $remove_url,
			);
		}
	}
}

// Clear-all URL.
$clear_all_url = remove_query_arg( array( 'min_price', 'max_price', 'filter_brand', 'filter_series' ) );

/* -----------------------------------------------------------------------
 * Category context
 * --------------------------------------------------------------------- */
$current_cat    = is_product_category() ? get_queried_object() : null;
$current_cat_id = $current_cat ? $current_cat->term_id : 0;

?>

<main id="primary" class="fs-main fs-shop" role="main">
	<div class="fs-container">

		<!-- Shop Header -->
		<header class="fs-shop__header">
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
				<h1 class="fs-shop__title"><?php woocommerce_page_title(); ?></h1>
			<?php endif; ?>
			<?php do_action( 'woocommerce_archive_description' ); ?>
		</header>

		<!-- Toolbar -->
		<div class="fs-shop__toolbar">
			<div class="fs-shop__toolbar-left">
				<button
					class="fs-shop__filter-toggle"
					aria-label="<?php esc_attr_e( 'Toggle filters', 'flavor-starter' ); ?>"
					aria-expanded="false"
					data-action="toggle-shop-sidebar"
				>
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
					<?php esc_html_e( 'Filters', 'flavor-starter' ); ?>
					<?php if ( ! empty( $active_filters ) ) : ?>
						<span class="fs-shop__filter-count"><?php echo count( $active_filters ); ?></span>
					<?php endif; ?>
				</button>
				<?php woocommerce_result_count(); ?>
			</div>
			<div class="fs-shop__toolbar-right">
				<span class="fs-shop__sort-label"><?php esc_html_e( 'Sort:', 'flavor-starter' ); ?></span>
				<?php woocommerce_catalog_ordering(); ?>
				<div class="fs-shop__view-toggle">
					<button class="fs-shop__view-btn fs-shop__view-btn--active" data-view="grid" aria-label="<?php esc_attr_e( 'Grid view', 'flavor-starter' ); ?>">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
					</button>
					<button class="fs-shop__view-btn" data-view="list" aria-label="<?php esc_attr_e( 'List view', 'flavor-starter' ); ?>">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
					</button>
				</div>
			</div>
		</div>

		<!-- Active Filters Strip -->
		<?php if ( ! empty( $active_filters ) ) : ?>
			<div class="fs-active-filters">
				<span class="fs-active-filters__label"><?php esc_html_e( 'Active:', 'flavor-starter' ); ?></span>
				<?php foreach ( $active_filters as $f ) : ?>
					<a href="<?php echo esc_url( $f['remove_url'] ); ?>" class="fs-active-filter-chip">
						<?php echo wp_kses_post( $f['label'] ); ?>
						<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
					</a>
				<?php endforeach; ?>
				<a href="<?php echo esc_url( $clear_all_url ); ?>" class="fs-active-filters__clear">
					<?php esc_html_e( 'Clear all', 'flavor-starter' ); ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="fs-shop__layout">

			<!-- ════════════════════════════════════════════════════════
			     SIDEBAR FILTERS
			     ════════════════════════════════════════════════════════ -->
			<aside
				class="fs-shop__sidebar"
				id="fs-shop-sidebar"
				role="complementary"
				aria-label="<?php esc_attr_e( 'Product Filters', 'flavor-starter' ); ?>"
			>

				<!-- Mobile header -->
				<div class="fs-sidebar-header">
					<span class="fs-sidebar-header__title"><?php esc_html_e( 'Filter Products', 'flavor-starter' ); ?></span>
					<button
						class="fs-sidebar-close"
						data-action="toggle-shop-sidebar"
						aria-label="<?php esc_attr_e( 'Close filters', 'flavor-starter' ); ?>"
					>
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
					</button>
				</div>

				<?php
				/* ── 1. PRODUCT TYPE (Categories) ─────────────────────────── */
				$top_cats = get_terms( array(
					'taxonomy'   => 'product_cat',
					'parent'     => 0,
					'hide_empty' => false,
					'exclude'    => array( absint( get_option( 'default_product_cat' ) ) ),
					'orderby'    => 'name',
				) );

				if ( ! is_wp_error( $top_cats ) && ! empty( $top_cats ) ) : ?>

					<div class="fs-filter-group" id="filter-type">
						<button class="fs-filter-group__toggle" aria-expanded="true" aria-controls="filter-type-body">
							<?php esc_html_e( 'Product Type', 'flavor-starter' ); ?>
							<svg class="fs-filter-group__chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
						</button>
						<div class="fs-filter-group__body" id="filter-type-body">
							<ul class="fs-filter-cats">
								<?php foreach ( $top_cats as $cat ) :
									$is_current = ( $current_cat_id === $cat->term_id );
									$children   = get_terms( array(
										'taxonomy'   => 'product_cat',
										'parent'     => $cat->term_id,
										'hide_empty' => false,
									) );
									$has_children = ! is_wp_error( $children ) && ! empty( $children );
									// If we're inside this top-level cat or one of its children, expand it.
									$is_ancestor  = false;
									if ( $current_cat && $current_cat->parent === $cat->term_id ) {
										$is_ancestor = true;
									}
									?>
									<li class="fs-filter-cat<?php echo ( $is_current || $is_ancestor ) ? ' fs-filter-cat--open' : ''; ?>">
										<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
											class="fs-filter-cat__link<?php echo $is_current ? ' fs-filter-cat__link--active' : ''; ?>">
											<span><?php echo esc_html( $cat->name ); ?></span>
											<span class="fs-filter-cat__count"><?php echo absint( $cat->count ); ?></span>
										</a>

										<?php if ( $has_children ) : ?>
											<ul class="fs-filter-cats fs-filter-cats--sub">
												<?php foreach ( $children as $child ) :
													$is_child_current = ( $current_cat_id === $child->term_id ); ?>
													<li class="fs-filter-cat">
														<a href="<?php echo esc_url( get_term_link( $child ) ); ?>"
															class="fs-filter-cat__link<?php echo $is_child_current ? ' fs-filter-cat__link--active' : ''; ?>">
															<span><?php echo esc_html( $child->name ); ?></span>
															<span class="fs-filter-cat__count"><?php echo absint( $child->count ); ?></span>
														</a>
													</li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>

							<?php if ( $current_cat_id ) : ?>
								<a href="<?php echo esc_url( $shop_url ); ?>" class="fs-filter-cats__all">
									<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
									<?php esc_html_e( 'All Products', 'flavor-starter' ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>

				<?php endif; ?>

				<?php
				/* ── 2. PRICE RANGE ───────────────────────────────────────── */
				?>
				<div class="fs-filter-group" id="filter-price">
					<button class="fs-filter-group__toggle" aria-expanded="true" aria-controls="filter-price-body">
						<?php esc_html_e( 'Price Range', 'flavor-starter' ); ?>
						<svg class="fs-filter-group__chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
					</button>
					<div class="fs-filter-group__body" id="filter-price-body">
						<?php
						the_widget(
							'WC_Widget_Price_Filter',
							array(),
							array(
								'before_widget' => '',
								'after_widget'  => '',
								'before_title'  => '<span class="screen-reader-text">',
								'after_title'   => '</span>',
							)
						);
						?>
					</div>
				</div>

				<?php
				/* ── 3. BRAND (pa_brand attribute) ────────────────────────── */
				if ( taxonomy_exists( 'pa_brand' ) ) :
					$brand_terms = get_terms( array(
						'taxonomy'   => 'pa_brand',
						'hide_empty' => true,
						'orderby'    => 'name',
					) );

					if ( ! is_wp_error( $brand_terms ) && ! empty( $brand_terms ) ) : ?>

						<div class="fs-filter-group" id="filter-brand">
							<button class="fs-filter-group__toggle" aria-expanded="true" aria-controls="filter-brand-body">
								<?php esc_html_e( 'Brand', 'flavor-starter' ); ?>
								<svg class="fs-filter-group__chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
							</button>
							<div class="fs-filter-group__body" id="filter-brand-body">
								<ul class="fs-filter-checks">
									<?php foreach ( $brand_terms as $term ) :
										$is_checked   = in_array( $term->slug, $active_brands, true );
										$new_selected = $is_checked
											? array_diff( $active_brands, array( $term->slug ) )
											: array_merge( $active_brands, array( $term->slug ) );
										$filter_url   = empty( $new_selected )
											? remove_query_arg( 'filter_brand' )
											: add_query_arg( 'filter_brand', implode( ',', $new_selected ) );
										?>
										<li class="fs-filter-check">
											<a href="<?php echo esc_url( $filter_url ); ?>"
												class="fs-filter-check__item<?php echo $is_checked ? ' fs-filter-check__item--active' : ''; ?>"
												role="checkbox"
												aria-checked="<?php echo $is_checked ? 'true' : 'false'; ?>">
												<span class="fs-filter-check__box" aria-hidden="true">
													<?php if ( $is_checked ) : ?>
														<svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
													<?php endif; ?>
												</span>
												<span class="fs-filter-check__label"><?php echo esc_html( $term->name ); ?></span>
												<span class="fs-filter-check__count"><?php echo absint( $term->count ); ?></span>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>

					<?php endif;
				endif; // pa_brand ?>

				<?php
				/* ── 4. SERIES ────────────────────────────────────────────── */
				// Use pa_series attribute if configured, otherwise fall back to
				// the sub-categories of the current browsed category.
				$series_terms    = array();
				$series_use_attr = false;

				if ( taxonomy_exists( 'pa_series' ) ) {
					$series_terms    = get_terms( array(
						'taxonomy'   => 'pa_series',
						'hide_empty' => true,
						'orderby'    => 'name',
					) );
					$series_use_attr = true;
				} elseif ( $current_cat_id ) {
					// Show sub-categories of the currently-browsed category.
					$series_terms = get_terms( array(
						'taxonomy'   => 'product_cat',
						'parent'     => $current_cat_id,
						'hide_empty' => true,
						'orderby'    => 'name',
					) );
				}

				if ( ! is_wp_error( $series_terms ) && ! empty( $series_terms ) ) : ?>

					<div class="fs-filter-group" id="filter-series">
						<button class="fs-filter-group__toggle" aria-expanded="true" aria-controls="filter-series-body">
							<?php esc_html_e( 'Series', 'flavor-starter' ); ?>
							<svg class="fs-filter-group__chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
						</button>
						<div class="fs-filter-group__body" id="filter-series-body">
							<ul class="fs-filter-checks">
								<?php foreach ( $series_terms as $term ) :
									if ( $series_use_attr ) {
										$is_checked   = in_array( $term->slug, $active_series, true );
										$new_selected = $is_checked
											? array_diff( $active_series, array( $term->slug ) )
											: array_merge( $active_series, array( $term->slug ) );
										$filter_url   = empty( $new_selected )
											? remove_query_arg( 'filter_series' )
											: add_query_arg( 'filter_series', implode( ',', $new_selected ) );
									} else {
										// Category-based: navigate to the sub-category.
										$is_checked = ( $current_cat_id === $term->term_id );
										$filter_url = get_term_link( $term );
									}
									?>
									<li class="fs-filter-check">
										<a href="<?php echo esc_url( $filter_url ); ?>"
											class="fs-filter-check__item<?php echo $is_checked ? ' fs-filter-check__item--active' : ''; ?>"
											<?php if ( $series_use_attr ) : ?>
												role="checkbox"
												aria-checked="<?php echo $is_checked ? 'true' : 'false'; ?>"
											<?php endif; ?>>
											<?php if ( $series_use_attr ) : ?>
												<span class="fs-filter-check__box" aria-hidden="true">
													<?php if ( $is_checked ) : ?>
														<svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
													<?php endif; ?>
												</span>
											<?php endif; ?>
											<span class="fs-filter-check__label"><?php echo esc_html( $term->name ); ?></span>
											<span class="fs-filter-check__count"><?php echo absint( $term->count ); ?></span>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>

				<?php endif; ?>

			</aside><!-- /sidebar -->

			<!-- ════════════════════════════════════════════════════════
			     PRODUCTS GRID
			     ════════════════════════════════════════════════════════ -->
			<div class="fs-shop__products">
				<?php if ( woocommerce_product_loop() ) : ?>

					<?php woocommerce_product_loop_start(); ?>

					<?php while ( have_posts() ) : the_post(); ?>
						<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php endwhile; ?>

					<?php woocommerce_product_loop_end(); ?>

					<?php woocommerce_pagination(); ?>

				<?php else : ?>
					<?php do_action( 'woocommerce_no_products_found' ); ?>
				<?php endif; ?>
			</div>

		</div><!-- /.fs-shop__layout -->

	</div><!-- /.fs-container -->
</main>

<!-- Mobile sidebar backdrop -->
<div class="fs-sidebar-overlay" aria-hidden="true"></div>

<?php get_footer(); ?>
