<?php
/**
 * Single post template.
 *
 * @package Flavor_Starter
 */

get_header();
?>

<main id="primary" class="fs-main" role="main">
	<div class="fs-container">
		<div class="fs-grid fs-grid--blog">
			<div class="fs-grid__content">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>

					<?php
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>

				<?php endwhile; ?>
			</div>

			<aside class="fs-grid__sidebar">
				<?php get_sidebar(); ?>
			</aside>
		</div>
	</div>
</main>

<?php
get_footer();
