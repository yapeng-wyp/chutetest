<div class="woocommerce wcpt-add-to-cart-wrapper <?php echo $html_class; ?>">
<?php

$form_elements = array(
	'quantity' => '.quantity',
	'button' => '.button',
	'availability' => '.woocommerce-variation-availability, .in-stock',
	'variation_description' => '.woocommerce-variation-description',
	'variation_price' => '.woocommerce-variation-price',
	'variation_attributes' => '.variations',
);

if( ! isset( $visible_elements ) ){
	$visible_elements = array_keys( $form_elements );
}

$table_data = wcpt_get_table_data();
$table_id = $table_data['id'];
$device = $_GET[$table_id . '_device'];

$element_selector = '.wcpt-' . $element['id'];

if( empty( $GLOBALS['wcpt_form_' . $element['id'] . '_toggle_styling_complete' ] ) ){
	echo '<style>';
	foreach( array_diff( array_keys( $form_elements ), $visible_elements ) as $elm ){
		echo $element_selector . ' ' . $form_elements[$elm] . '{ display: none !important; } ';
	}

	if( 
		! in_array( 'button', $visible_elements ) &&
		! in_array( 'quantity', $visible_elements ) &&
		! class_exists( 'WC_Product_Addons_Helper' )
	) {
		echo $element_selector . ' .woocommerce-variation-add-to-cart { display: none !important; } ';
	}

	echo '</style>';

	$GLOBALS['wcpt_form_' . $element['id'] . '_toggle_styling_complete' ] = true;
}

if( $product->get_type() == 'variable' ){	
	$attributes = $product->get_variation_attributes();
	$selected_attributes = $product->get_default_attributes();
	
	$attribute_keys = array_keys( $attributes );
	
	$available_variations = wcpt_get_variations($product);
	$variations_json = wp_json_encode( $available_variations );
	$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

	do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
		<?php do_action( 'woocommerce_before_variations_form' ); ?>

		<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
			<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
		<?php else : ?>
			<div class="variations" cellspacing="0">
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<div class="wcpt-variation-attribute-dropdown-wrapper">
						<span><?php echo esc_html( wc_attribute_label( $attribute_name ) ) ?>:</span>
						<?php
							wc_dropdown_variation_attribute_options( array(
								'options'   => $options,
								'attribute' => $attribute_name,
								'product'   => $product,
								'show_option_none' => wc_attribute_label( $attribute_name ),
							) );
							echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
						?>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="single_variation_wrap">
				<?php
					/**
					 * Hook: woocommerce_before_single_variation.
					 */
					do_action( 'woocommerce_before_single_variation' );

					/**
					 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
					 *
					 * @since 2.4.0
					 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
					 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
					 */
					do_action( 'woocommerce_single_variation' );

					/**
					 * Hook: woocommerce_after_single_variation.
					 */
					do_action( 'woocommerce_after_single_variation' );
				?>
			</div>
		<?php endif; ?>

		<?php do_action( 'woocommerce_after_variations_form' ); ?>
	</form>

	<?php
	do_action( 'woocommerce_after_add_to_cart_form' );

// }else if( $product->get_type() == 'grouped' ){
// 	woocommerce_template_loop_add_to_cart();

}else{
	do_action( 'woocommerce_' . $product->get_type() . '_add_to_cart' );

}

?>
</div>
