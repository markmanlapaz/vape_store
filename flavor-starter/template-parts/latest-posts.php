<?php
/**
 * Template Part: Latest Blog Posts
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

$posts = new WP_Query( array(
	'posts_per_page' => 3,
	'post_status'    => 'publish',
	'no_found_rows'  => true,
) );

if ( ! $posts->have_posts() ) {
	return;
}
?>

<section class="fs-section fs-latest-posts">
	<div class="fs-container">
		<div class="fs-section__header">
			<div class="fs-section__header-left">
				<h2 class="fs-section__title"><?php esc_html_e( 'Latest from the Blog', 'flavor-starter' ); ?></h2>
				<p class="fs-section__subtitle"><?php esc_html_e( 'Tips, guides, and industry news', 'flavor-starter' ); ?></p>
			</div>
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="fs-btn fs-btn--outline fs-btn--sm">
				<?php esc_html_e( 'All Posts', 'flavor-starter' ); ?>
			</a>
		</div>

		<div class="fs-posts-grid">
			<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
				<article class="fs-post-card">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="fs-post-card__image">
							<?php the_post_thumbnail( 'flavor-category', array( 'class' => 'fs-post-card__img', 'loading' => 'lazy' ) ); ?>
						</a>
					<?php endif; ?>
					<div class="fs-post-card__body">
						<div class="fs-post-card__meta">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<?php
							$cats = get_the_category();
							if ( ! empty( $cats ) ) :
							?>
								<span class="fs-post-card__cat"><?php echo esc_html( $cats[0]->name ); ?></span>
							<?php endif; ?>
						</div>
						<h3 class="fs-post-card__title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<p class="fs-post-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<a href="<?php the_permalink(); ?>" class="fs-post-card__link">
							<?php esc_html_e( 'Read More', 'flavor-starter' ); ?>
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
						</a>
					</div>
				</article>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</section>
