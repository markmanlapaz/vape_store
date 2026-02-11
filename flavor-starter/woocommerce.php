<?php
/**
 * WooCommerce wrapper template.
 *
 * Catches all WooCommerce pages that don't have a more-specific template.
 *
 * @package Flavor_Starter
 */

get_header();
?>

<main id="primary" class="fs-main fs-woocommerce-main" role="main">
	<div class="fs-container">
		<?php woocommerce_content(); ?>
	</div>
</main>

<?php
get_footer();
