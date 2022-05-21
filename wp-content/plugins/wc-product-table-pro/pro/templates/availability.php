<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$message = '';
$message_tpl = '';
$stock_class = '';
$stock = $product->get_stock_quantity();

if( 
	! isset( $low_stock_threshold ) ||
	$low_stock_threshold === ''
){
	$low_stock_threshold = $product->get_low_stock_amount();
}

if( ! $product->is_in_stock() ){
	$message_tpl = 'out_of_stock_message';
	$message = wcpt_parse_2( $out_of_stock_message );
	$stock_class = 'wcpt-out-of-stock';

}else if( 
	(
		(
			$product->managing_stock() && 
			$product->is_on_backorder( 1 ) &&
			$product->backorders_require_notification()
		) ||
		(
			! $product->managing_stock() && 
			$product->is_on_backorder( 1 )
		)
	) &&
	! empty( $on_backorder_message )
){
	$message_tpl = 'on_backorder_message';	
	$message = wcpt_parse_2( $on_backorder_message, $product );
	$stock_class = 'wcpt-on-backorder';

}else if( $product->managing_stock() ) { // in stock, managed
	$message_tpl = 'in_stock_managed_message';		
	$message = wcpt_parse_2( $in_stock_managed_message );
	$stock_class = "wcpt-in-stock";

	if( ! $product->backorders_allowed() ){

		if( // low stock	
			$stock == 1 &&
			! empty( $single_stock_message )
		){
			$message_tpl = 'single_stock_message';				
			$message = wcpt_parse_2( $single_stock_message, $product );
			$stock_class = "wcpt-low-stock";

		}else if(	// single stock
			! empty( $low_stock_message ) && 
			! empty( $low_stock_threshold ) && 
			$stock <= $low_stock_threshold
		){
			$message_tpl = 'low_stock_message';
			$message = wcpt_parse_2( $low_stock_message, $product );
			$stock_class = "wcpt-low-stock";

		}

	}else if( 
		$product->backorders_require_notification() &&
		$on_backorder_managed_message
	){
		$message_tpl = 'on_backorder_managed_message';				
		$message = wcpt_parse_2( $on_backorder_managed_message, $product );
		$stock_class = "wcpt-low-stock";

	}else if( $stock <= 0 ){ // backorder allowed, managed stock, 0 or less
		$message_tpl = "on_backorder_message";
		$stock_class = "";		
		$html_class .= " wcpt-hide ";

	}else{ // backorder allowed, managed stock, greater than 0
		$message_tpl = 'in_stock_message';
		$stock_class = "wcpt-in-stock";
	}

} else { // in stock, not managed
	$message = '';
	$stock_class = '';

	if( ! empty( $in_stock_message ) ){
		$message_tpl = 'in_stock_message';		
		$message = wcpt_parse_2( $in_stock_message, $product );
		$stock_class = 'wcpt-in-stock';
	}

}

// variable switch
$variable_switch_class = '';
if( $product->get_type() === 'variable' ){
	if( ! empty( $variable_switch ) ){
		$variable_switch_class = 'wcpt-variable-switch';
	}
}

?>
<div
	class="wcpt-availability <?php echo $html_class . ' ' . $variable_switch_class; ?>"
	<?php if( $variable_switch_class ): ?>
	data-wcpt-element-id="<?php echo $id; ?>"
	data-wcpt-stock="<?php echo $stock; ?>"
	data-wcpt-low_stock_threshold="<?php echo $low_stock_threshold; ?>"
	data-wcpt-default-message_tpl="<?php echo $message_tpl; ?>"
	<?php endif; ?>
><span class="<?php echo $stock_class; ?>" ><?php echo str_replace( "[stock]", '<span class="wcpt-stock-placeholder">' . $stock . '</span>', wcpt_parse_2( $message ) ); ?></span></div>
<?php

// print templates
if(	$product->get_type() == 'variable' ){
	$table_data = wcpt_get_table_data();
	$table_id = $table_data['id'];

	if( empty( $GLOBALS['wcpt_' . $table_id . '_availability_templates'] ) ){
		$GLOBALS['wcpt_' . $table_id . '_availability_templates'] = array();
	}

	if( empty( $GLOBALS['wcpt_' . $table_id . '_availability_templates'][$id] ) ){
		$GLOBALS['wcpt_' . $table_id . '_availability_templates'][$id] = array(
			'out_of_stock_message' 	=> ! empty( $out_of_stock_message ) ? wcpt_parse_2( $out_of_stock_message, $product ) : '',
			'low_stock_message' 	=> ! empty( $low_stock_message ) ? wcpt_parse_2( $low_stock_message, $product ) : '',
			'single_stock_message' 	=> ! empty( $single_stock_message ) ? wcpt_parse_2( $single_stock_message, $product ) : '',
			'in_stock_message' 	=> ! empty( $in_stock_message ) ? wcpt_parse_2( $in_stock_message, $product ) : '',
			'in_stock_managed_message' 	=> ! empty( $in_stock_managed_message ) ? wcpt_parse_2( $in_stock_managed_message, $product ) : '',
			'on_backorder_message' 	=> ! empty( $on_backorder_message ) ? wcpt_parse_2( $on_backorder_message, $product ) : '',
			'on_backorder_managed_message' 	=> ! empty( $on_backorder_managed_message ) ? wcpt_parse_2( $on_backorder_managed_message, $product ) : '',
		);


		foreach( $GLOBALS['wcpt_' . $table_id . '_availability_templates'][$id] as $tpl=> &$message ){
			$message = str_replace( "[stock]", '<span class="wcpt-stock-placeholder">' . $stock . '</span>', wcpt_parse_2( $message ) );
		}
	}
}
