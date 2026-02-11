<?php
/**
 * WooCommerce single product page.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="fs-main fs-single-product-page" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<div class="fs-container">
			<?php woocommerce_breadcrumb( array(
				'wrap_before' => '<nav class="fs-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'flavor-starter' ) . '">',
				'wrap_after'  => '</nav>',
				'before'      => '<span class="fs-breadcrumb__item">',
				'after'       => '</span>',
				'delimiter'   => '<span class="fs-breadcrumb__sep">/</span>',
			) ); ?>
		</div>

		<?php wc_get_template_part( 'content', 'single-product' ); ?>

	<?php endwhile; ?>

</main>

<?php
get_footer();
