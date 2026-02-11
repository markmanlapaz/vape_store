<?php
/**
 * Template Part: Single post content.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'fs-single-post' ); ?>>
	<header class="fs-single-post__header">
		<div class="fs-single-post__meta">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<span class="fs-single-post__author">
				<?php
				printf(
					/* translators: %s: author name */
					esc_html__( 'by %s', 'flavor-starter' ),
					esc_html( get_the_author() )
				);
				?>
			</span>
			<?php
			$cats = get_the_category();
			if ( ! empty( $cats ) ) :
			?>
				<a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>" class="fs-single-post__cat">
					<?php echo esc_html( $cats[0]->name ); ?>
				</a>
			<?php endif; ?>
		</div>
		<h1 class="fs-single-post__title"><?php the_title(); ?></h1>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="fs-single-post__featured">
			<?php the_post_thumbnail( 'flavor-hero', array( 'class' => 'fs-single-post__img', 'loading' => 'eager' ) ); ?>
		</figure>
	<?php endif; ?>

	<div class="fs-single-post__content entry-content">
		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="fs-page-links">' . esc_html__( 'Pages:', 'flavor-starter' ),
			'after'  => '</div>',
		) );
		?>
	</div>

	<footer class="fs-single-post__footer">
		<?php
		$tags = get_the_tags();
		if ( $tags ) : ?>
			<div class="fs-single-post__tags">
				<?php foreach ( $tags as $tag ) : ?>
					<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="fs-tag"><?php echo esc_html( $tag->name ); ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="fs-single-post__share">
			<span class="fs-single-post__share-label"><?php esc_html_e( 'Share:', 'flavor-starter' ); ?></span>
			<a href="https://twitter.com/intent/tweet?url=<?php echo esc_url( urlencode( get_permalink() ) ); ?>&text=<?php echo esc_attr( urlencode( get_the_title() ) ); ?>" target="_blank" rel="noopener noreferrer" class="fs-share-btn" aria-label="Share on Twitter">X</a>
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( urlencode( get_permalink() ) ); ?>" target="_blank" rel="noopener noreferrer" class="fs-share-btn" aria-label="Share on Facebook">FB</a>
		</div>
	</footer>

	<?php
	// Author bio.
	if ( get_the_author_meta( 'description' ) ) : ?>
		<div class="fs-author-box">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 80, '', '', array( 'class' => 'fs-author-box__avatar' ) ); ?>
			<div class="fs-author-box__content">
				<h4 class="fs-author-box__name"><?php the_author(); ?></h4>
				<p class="fs-author-box__bio"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
			</div>
		</div>
	<?php endif; ?>

	<?php
	// Post navigation.
	the_post_navigation( array(
		'prev_text' => '<span class="fs-post-nav__label">' . esc_html__( 'Previous', 'flavor-starter' ) . '</span><span class="fs-post-nav__title">%title</span>',
		'next_text' => '<span class="fs-post-nav__label">' . esc_html__( 'Next', 'flavor-starter' ) . '</span><span class="fs-post-nav__title">%title</span>',
		'class'     => 'fs-post-nav',
	) );
	?>
</article>
