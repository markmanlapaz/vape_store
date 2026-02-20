<?php
/**
 * WooCommerce quantity input — custom template with +/- buttons.
 *
 * Overrides: woocommerce/templates/global/quantity-input.php
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="fs-qty-input">
	<button
		type="button"
		class="fs-qty-input__btn"
		data-action="qty-decrease"
		aria-label="<?php esc_attr_e( 'Decrease quantity', 'flavor-starter' ); ?>"
	>
		<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/></svg>
	</button>

	<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>

	<input
		type="<?php echo esc_attr( $type ); ?>"
		id="<?php echo esc_attr( $input_id ); ?>"
		class="<?php echo esc_attr( implode( ' ', (array) $classes ) ); ?> fs-qty-input__field"
		step="<?php echo esc_attr( $step ); ?>"
		min="<?php echo esc_attr( $min_value ); ?>"
		max="<?php echo esc_attr( $max_value ); ?>"
		name="<?php echo esc_attr( $input_name ); ?>"
		value="<?php echo esc_attr( $input_value ); ?>"
		title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
		size="4"
		pattern="<?php echo esc_attr( $pattern ); ?>"
		inputmode="<?php echo esc_attr( $inputmode ); ?>"
		aria-label="<?php esc_attr_e( 'Product quantity', 'flavor-starter' ); ?>"
	/>

	<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>

	<button
		type="button"
		class="fs-qty-input__btn"
		data-action="qty-increase"
		aria-label="<?php esc_attr_e( 'Increase quantity', 'flavor-starter' ); ?>"
	>
		<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
	</button>
</div>
