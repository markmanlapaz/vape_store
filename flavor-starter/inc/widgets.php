<?php
/**
 * Custom widgets.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

/*--------------------------------------------------------------
 * Widget: Store Notice
 *------------------------------------------------------------*/
class FS_Store_Notice_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'fs_store_notice',
			__( 'Flavor Starter: Store Notice', 'flavor-starter' ),
			array( 'description' => __( 'Display a styled promotional notice.', 'flavor-starter' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] ?? '' );
		$text  = $instance['text'] ?? '';
		$url   = $instance['url'] ?? '';

		echo $args['before_widget'];
		?>
		<div class="fs-store-notice-widget">
			<?php if ( $title ) : ?>
				<?php echo $args['before_title'] . esc_html( $title ) . $args['after_title']; ?>
			<?php endif; ?>
			<?php if ( $text ) : ?>
				<p class="fs-store-notice-widget__text"><?php echo esc_html( $text ); ?></p>
			<?php endif; ?>
			<?php if ( $url ) : ?>
				<a href="<?php echo esc_url( $url ); ?>" class="fs-btn fs-btn--primary fs-btn--sm"><?php esc_html_e( 'Shop Now', 'flavor-starter' ); ?></a>
			<?php endif; ?>
		</div>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = $instance['title'] ?? __( 'Special Offer', 'flavor-starter' );
		$text  = $instance['text'] ?? '';
		$url   = $instance['url'] ?? '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'flavor-starter' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Notice Text:', 'flavor-starter' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $text ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_html_e( 'Button URL:', 'flavor-starter' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="url" value="<?php echo esc_url( $url ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] ?? '' );
		$instance['text']  = sanitize_text_field( $new_instance['text'] ?? '' );
		$instance['url']   = esc_url_raw( $new_instance['url'] ?? '' );
		return $instance;
	}
}

function flavor_starter_register_widgets() {
	register_widget( 'FS_Store_Notice_Widget' );
}
add_action( 'widgets_init', 'flavor_starter_register_widgets' );
