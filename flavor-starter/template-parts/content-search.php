<?php
/**
 * Template Part: Search result item.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'fs-post-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="fs-post-card__image">
			<?php the_post_thumbnail( 'flavor-category', array( 'class' => 'fs-post-card__img', 'loading' => 'lazy' ) ); ?>
		</a>
	<?php endif; ?>

	<div class="fs-post-card__body">
		<div class="fs-post-card__meta">
			<span class="fs-post-card__type"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</div>
		<h2 class="fs-post-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>
		<p class="fs-post-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<a href="<?php the_permalink(); ?>" class="fs-post-card__link">
			<?php esc_html_e( 'View', 'flavor-starter' ); ?>
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
		</a>
	</div>
</article>
