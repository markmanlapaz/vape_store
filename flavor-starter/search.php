<?php
/**
 * Search results template.
 *
 * @package Flavor_Starter
 */

get_header();
?>

<main id="primary" class="fs-main" role="main">
	<div class="fs-container">
		<header class="fs-page-header">
			<h1 class="fs-page-header__title">
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Search Results for: %s', 'flavor-starter' ),
					'<span>' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="fs-posts-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content', 'search' ); ?>
				<?php endwhile; ?>
			</div>
			<?php flavor_starter_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
