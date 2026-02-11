<?php
/**
 * Archive template.
 *
 * @package Flavor_Starter
 */

get_header();
?>

<main id="primary" class="fs-main" role="main">
	<div class="fs-container">
		<header class="fs-page-header">
			<?php the_archive_title( '<h1 class="fs-page-header__title">', '</h1>' ); ?>
			<?php the_archive_description( '<div class="fs-page-header__desc">', '</div>' ); ?>
		</header>

		<div class="fs-grid fs-grid--blog">
			<div class="fs-grid__content">
				<?php if ( have_posts() ) : ?>
					<div class="fs-posts-grid">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
						<?php endwhile; ?>
					</div>
					<?php flavor_starter_pagination(); ?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>

			<aside class="fs-grid__sidebar">
				<?php get_sidebar(); ?>
			</aside>
		</div>
	</div>
</main>

<?php
get_footer();
