<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( empty( $display_type ) ){
	$display_type = 'radio_single';
}

if( ! $product->is_type( 'variable' ) ){
	if( 
		in_array( $display_type, array('radio_multiple', 'dropdown') ) &&
		! empty( $non_variable_template ) &&
		$mkp = wcpt_parse_2( $non_variable_template )
	){
		echo '<div class="wcpt-non-variation-output">' . $mkp . '</div>';
	}

	return;
}

if( ! $available_variations = wcpt_get_variations($product) ){
	return;
}

$price_format = get_woocommerce_price_format();
$currency_symbol =  get_woocommerce_currency_symbol();

$default_variation = wcpt_get_default_variation( $product );

// dropdown
if( $display_type == 'dropdown' ){

	ob_start();
	?><div class="wcpt-select-variation-dropdown-wrapper <?php echo $html_class; ?>"><select class="wcpt-select-variation-dropdown">
		<?php
		if( 
			empty( $hide_select ) ||
			! $default_variation
		){
		?>
		<option value=""><?php echo ! empty($select_label) ? $select_label : __( 'Select', 'woocommerce' ); ?></option>
		<?php 
		}		
		?>

		<?php
			$out_of_stock_options = array();
			foreach( $available_variations as $variation ){
				$label = '';
				if( ! strlen( implode( array_values( $variation['attributes'] ) ) ) ){ // no terms
					continue;
				}
				foreach( $variation['attributes'] as $attr => $term ){
					if( ! $term ){
						continue;
					}
					$taxonomy = substr( $attr, 10 );
					$term_obj = get_term_by('slug', $term, $taxonomy);
					$term_label = $term_obj ? $term_obj->name : $term;

					if( empty( $hide_attributes ) ){
						$label .= wc_attribute_label( $taxonomy );
						$label .= $attribute_term_separator;
					}
					$label .= $term_label;
					$label .= $attribute_separator;
				}

				$out_of_stock = ! $variation['is_in_stock'];

				$label = substr( $label, 0, - strlen( $attribute_separator ) );

				$variation_price = apply_filters( 'wcpt_select_variation_price', $variation['display_price'], $variation );

				if( 
					empty( $hide_price ) &&
					'' !== $variation_price
				){
					$label .= ' &mdash; ' . sprintf( $price_format, $currency_symbol, $variation_price );
				}

				if(
					! $out_of_stock &&
					empty( $hide_stock )
				){
					$availability = strip_tags( $variation['availability_html'] );
					if( ! empty( $availability ) ){
						$label .= ' ('. trim( $availability ) .')';
					}
				}

				$selected = '';
				if( $default_variation && $default_variation['variation_id'] == $variation['variation_id'] ){
					$selected = ' selected ';
				}

				$variation_json = wp_json_encode( $variation );
				$variation_json__html_esc = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variation_json ) : _wp_specialchars( $variation_json, ENT_QUOTES, 'UTF-8', true );


				$output = '<option class="'. ( wcpt_is_incomplete_variation($product, $variation) ? 'wcpt-partial_match' : 'wcpt-complete_match' ) .'" value="'. $variation['variation_id'] .'" data-variation-id="'. $variation['variation_id'] .'" '. $selected .' data-wcpt-attributes="'. esc_attr( json_encode( $variation['attributes'] ) ) .'" data-wcpt-variation="'. $variation_json__html_esc .'" '. ($out_of_stock ? ' disabled ' : '') .'>'. apply_filters( 'wcpt_select_variation_label_for_dropdown_option', $label, $variation, $element ) .'</option>';

				if( $out_of_stock ){
					$out_of_stock_options[] = $output;

				}else{
					echo $output;

				}
			}

			if( count( $out_of_stock_options ) ){
				echo '<optgroup label="'. __( 'Out of stock', 'woocommerce' ) .':">';
				foreach( $out_of_stock_options as $option ){
					echo $option;
				}
			  echo '</optgroup>';
			}

		?>
	</select></div><?php

	echo ob_get_clean();

	return;
}

// radio multiple
if( $display_type == 'radio_multiple' ){

	ob_start();
	$rand_name = rand(0, 100000000);
	?><div class="wcpt-select-varaition-radio-multiple-wrapper <?php echo $html_class; ?>">
		<?php
			foreach( $available_variations as $variation ){
				$label = '';
				if( ! strlen( implode( array_values( $variation['attributes'] ) ) ) ){ // no terms
					continue;
				}
				foreach( $variation['attributes'] as $attr => $term ){
					if( ! $term ){
						continue;
					}
					$taxonomy = substr( $attr, 10 );
					$term_obj = get_term_by('slug', $term, $taxonomy);
					$term_label = $term_obj ? $term_obj->name : $term;

					if( empty( $hide_attributes ) ){
						$label .= wc_attribute_label( $taxonomy );
						$label .= $attribute_term_separator;
					}
					$label .= $term_label;
					$label .= $attribute_separator;
				}

				if( ! $variation['is_in_stock'] ){
					$out_of_stock = ' wcpt-variation-out-of-stock ';
				} else {
					$out_of_stock = '';
				}

				$label = substr( $label, 0, - strlen( $attribute_separator ) );

				$variation_price = apply_filters( 'wcpt_select_variation_price', $variation['display_price'], $variation );

				if( 
					empty( $hide_price ) &&
					'' !== $variation_price
				){
					$label .= ' &mdash; ' . sprintf( $price_format, $currency_symbol, $variation_price );
				}

				if(
					! $out_of_stock &&
					empty( $hide_stock )
				){
					$availability = strip_tags( $variation['availability_html'] );
					if( ! empty( $availability ) ){
						$label .= ' ('. trim( $availability ) .')';
					}
				}

				$selected = '';
				if( $default_variation && $default_variation['variation_id'] == $variation['variation_id'] ){
					$selected = ' checked="checked" ';
				}

				$variation_json = wp_json_encode( $variation );
				$variation_json__html_esc = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variation_json ) : _wp_specialchars( $variation_json, ENT_QUOTES, 'UTF-8', true );

				?>
				<label
					class="wcpt-select-variation <?php echo $out_of_stock; ?> <?php echo wcpt_is_incomplete_variation($product, $variation) ? 'wcpt-partial_match' : 'wcpt-complete_match'; ?> <?php echo $selected ? 'wcpt-selected' : ''; ?>"
					data-variation-id="<?php echo $variation['variation_id'] ?>"
					data-wcpt-attributes="<?php echo esc_attr( json_encode( $variation['attributes'] ) ); ?>"
					data-wcpt-variation="<?php echo esc_attr( $variation_json__html_esc ); ?>"
					title="<?php echo $out_of_stock ? __( 'Out of stock', 'woocommerce' ): ''; ?>"
				>
					<input
						class="wcpt-variation-radio"
						type="radio"
						value="<?php echo $variation['variation_id']; ?>"
						<?php echo $selected; ?>
						<?php echo $out_of_stock ? 'disabled' : ''; ?>
						name = "<?php echo $rand_name; ?>"
					>
					<?php echo apply_filters( 'wcpt_select_variation_label_for_input_radio', $label, $variation, $element ); ?>
				</label>
				<?php
				if( ! empty( $separate_lines ) ){
					echo '<br>';
				}
			}
		?>
	</div><?php

	echo ob_get_clean();

	return;
}

// radio single
if( empty( $template ) || empty( $attribute_terms ) ){
	return;
}

$attributes = array();
foreach( $attribute_terms as $key => $value ) {
	$attributes['attribute_' . $value['taxonomy']] = $value['term'];
}

$match = wcpt_find_closests_matching_product_variation( $product, $attributes );

if( $match ){ // found variation, let's use it

	$variation_id = $match['variation_id'];
	$variation_attributes = $match['variation_attributes'];
	$variation = wc_get_product( $variation_id );
	$template = str_replace( '[variation_name]', $variation_name, wcpt_parse_2( $template, $variation ) );

	if( $template ){
		if( ! $variation->is_in_stock() ){
			$out_of_stock = ' wcpt-variation-out-of-stock ';
		} else {
			$out_of_stock = '';
		}

		// default variation
		if( $product->get_default_attributes() ){

			$default_attributes = array();
			foreach( $product->get_default_attributes() as $key => $value ) {
				$default_attributes['attribute_' . $key] = $value;
			}

			$default_variation_match = wcpt_find_closests_matching_product_variation( $product, $default_attributes );

			if(
				$default_variation_match &&
				$default_variation_match['variation_id'] == $variation_id
			){
				$html_class .= ' wcpt-selected ';
			}

		}

		$variation_json = wp_json_encode( $match['variation'] );
		$variation_json__html_esc = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variation_json ) : _wp_specialchars( $variation_json, ENT_QUOTES, 'UTF-8', true );


		echo '<label class="wcpt-select-variation wcpt-'. $match['type'] .' '. $out_of_stock .' '. $html_class .'" data-wcpt-attributes="'. esc_attr( json_encode( $variation_attributes ) ).'" data-variation-id="'. $variation->get_id() .'" data-wcpt-variation="'. $variation_json__html_esc .'" >'. $template .'</label>';
	}

	return;
}

if( ! empty( $not_exist_template ) ){
	if( $parsed = wcpt_parse_2( $not_exist_template ) ){
		echo '<span class="wcpt-variation-not-exist">'. $parsed .'</span>';
	}
}
