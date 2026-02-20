<?php
/**
 * Homepage template.
 *
 * @package Flavor_Starter
 */

get_header();
?>

<main id="primary" class="fs-main fs-front-page" role="main">

	<?php
	// Hero Banner.
	get_template_part( 'template-parts/hero-banner' );

	// Featured Categories.
	get_template_part( 'template-parts/featured-categories' );

	// Featured Products.
	get_template_part( 'template-parts/featured-products' );

	// Promo Banner.
	get_template_part( 'template-parts/promo-banner' );

	// New Arrivals.
	get_template_part( 'template-parts/new-arrivals' );

	// Brands / Trust Bar.
	get_template_part( 'template-parts/trust-bar' );

?>

</main>

<?php
get_footer();
