<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if(
	empty( $product ) ||
	! in_array( 
		$product->get_type(), 
		array( 
				'simple', 
				'variable', 
				'variation', 
				'variable-subscription', 
				'subscription' 
		) 
	)
){
	return;
}

$disabled = '';
$title = '';
if( 
	in_array( $product->get_type(), array('simple', 'variation') ) &&
	! $product->is_in_stock()
){
	$disabled = ' disabled="disabled" ';
	$title = ' title="'. __( 'Out of stock', 'woocommerce' ) .'" ';
}

$heading = empty( $heading_enabled ) ? '' : ' data-wcpt-heading-enabled="true" ';

?><div class="wcpt-cart-checkbox-wrapper">
	<?php wcpt_icon('loader'); ?>
	<input 
		type="checkbox" 
		class="wcpt-cart-checkbox <?php echo ! empty( $refresh_enabled ) ? ' wcpt-refresh-enabled ' : ''; ?>" 
		<?php echo $heading . $disabled . $title; ?> 
		name="wcpt-cart-checkbox" 
		value="<?php echo $product->get_id(); ?>" 
	/>
</div>