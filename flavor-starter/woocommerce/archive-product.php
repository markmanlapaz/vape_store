<?php
/**
 * WooCommerce Shop / Product Archive.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

get_header();
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
				<button class="fs-shop__filter-toggle" data-action="toggle-shop-sidebar" aria-label="<?php esc_attr_e( 'Toggle filters', 'flavor-starter' ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
					<?php esc_html_e( 'Filters', 'flavor-starter' ); ?>
				</button>
				<?php woocommerce_result_count(); ?>
			</div>
			<div class="fs-shop__toolbar-right">
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

		<div class="fs-shop__layout">
			<!-- Sidebar -->
			<aside class="fs-shop__sidebar" role="complementary">
				<?php if ( is_active_sidebar( 'sidebar-shop' ) ) : ?>
					<?php dynamic_sidebar( 'sidebar-shop' ); ?>
				<?php else : ?>
					<!-- Default Filters -->
					<div class="fs-widget">
						<h3 class="fs-widget__title"><?php esc_html_e( 'Categories', 'flavor-starter' ); ?></h3>
						<?php
						the_widget( 'WC_Widget_Product_Categories', array(
							'count'        => 1,
							'hierarchical' => 1,
						) );
						?>
					</div>
					<div class="fs-widget">
						<h3 class="fs-widget__title"><?php esc_html_e( 'Filter by Price', 'flavor-starter' ); ?></h3>
						<?php the_widget( 'WC_Widget_Price_Filter' ); ?>
					</div>
				<?php endif; ?>
			</aside>

			<!-- Products Grid -->
			<div class="fs-shop__products">
				<?php if ( woocommerce_product_loop() ) : ?>

					<?php woocommerce_product_loop_start(); ?>

					<?php while ( have_posts() ) : the_post(); ?>
						<?php
						/**
						 * Product card — uses our custom content-product.php
						 */
						wc_get_template_part( 'content', 'product' );
						?>
					<?php endwhile; ?>

					<?php woocommerce_product_loop_end(); ?>

					<?php woocommerce_pagination(); ?>

				<?php else : ?>
					<?php do_action( 'woocommerce_no_products_found' ); ?>
				<?php endif; ?>
			</div>
		</div>

	</div>
</main>

<?php
get_footer();
