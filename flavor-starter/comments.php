<?php
/**
 * Comments template.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="fs-comments">

	<?php if ( have_comments() ) : ?>
		<h2 class="fs-comments__title">
			<?php
			printf(
				/* translators: %d: number of comments */
				esc_html( _n( '%d Comment', '%d Comments', get_comments_number(), 'flavor-starter' ) ),
				intval( get_comments_number() )
			);
			?>
		</h2>

		<ol class="fs-comments__list">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 50,
				'callback'    => 'flavor_starter_comment',
			) );
			?>
		</ol>

		<?php
		the_comments_navigation( array(
			'prev_text' => esc_html__( '&larr; Older comments', 'flavor-starter' ),
			'next_text' => esc_html__( 'Newer comments &rarr;', 'flavor-starter' ),
			'class'     => 'fs-comments__nav',
		) );
		?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="fs-comments__closed"><?php esc_html_e( 'Comments are closed.', 'flavor-starter' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( array(
		'class_form'    => 'fs-comment-form',
		'title_reply'   => esc_html__( 'Leave a Comment', 'flavor-starter' ),
		'label_submit'  => esc_html__( 'Post Comment', 'flavor-starter' ),
		'class_submit'  => 'fs-btn fs-btn--primary',
	) );
	?>
</div>
