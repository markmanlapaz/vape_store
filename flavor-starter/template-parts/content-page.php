<?php
/**
 * Template Part: Page content.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'fs-page-content' ); ?>>
	<header class="fs-page-content__header">
		<h1 class="fs-page-content__title"><?php the_title(); ?></h1>
	</header>

	<div class="fs-page-content__body entry-content">
		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="fs-page-links">' . esc_html__( 'Pages:', 'flavor-starter' ),
			'after'  => '</div>',
		) );
		?>
	</div>
</article>
