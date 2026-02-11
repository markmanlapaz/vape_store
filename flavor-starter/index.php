<?php
/**
 * The main template file.
 *
 * @package Flavor_Starter
 */

get_header();
?>

<main id="primary" class="fs-main" role="main">
	<div class="fs-container">

		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header class="fs-page-header">
				<h1 class="fs-page-header__title"><?php single_post_title(); ?></h1>
			</header>
		<?php endif; ?>

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
