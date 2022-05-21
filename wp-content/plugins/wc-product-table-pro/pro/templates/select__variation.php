<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$parent_id = $product->get_parent_id();
$parent = wc_get_product( $parent_id );

$checked = '';
if( $parent->get_default_attributes() ){

	$default_attributes = array();
	foreach( $parent->get_default_attributes() as $key => $value ) {
		$default_attributes['attribute_' . $key] = $value;
	}

	$default_variation_match = wcpt_find_closests_matching_product_variation( $parent, $default_attributes );

	if(
		$default_variation_match &&
		$default_variation_match['variation_id'] == $product->get_id()
	){
		$checked = ' checked="checked" ';
	}
}

if( ! $product->is_in_stock() ){
	$checked = '';
	$disabled = ' disabled ';
} else {
	$disabled = '';
}

?>
<input
	type="radio"
	class="wcpt-variation-radio <?php echo $html_class; ?> <?php  ?>"
	name="<?php echo $GLOBALS['wcpt_row_rand'] . '-' . $parent_id; ?>"
	value="<?php echo $product->get_id(); ?>"
	<?php echo $checked; ?>
	<?php echo $disabled; ?>
/>
