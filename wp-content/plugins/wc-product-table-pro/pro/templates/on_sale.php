<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( empty( $precision ) ){
	$precision = 0;
}

if( $product->get_type() == 'variable' ){

	if( empty( $variable_switch ) ){
		return;
	}else{
		$html_class .= ' wcpt-variable-switch wcpt-hide ';
	}
	
	$replace = array(
		'<span class="wcpt-on-sale__price-diff"></span>',
		'<span class="wcpt-on-sale__percent-diff"></span>',
	);

}else if( apply_filters( 'wcpt_product_is_on_sale', $product->is_on_sale(), $product ) ){

	$regular_price = apply_filters('wcpt_product_get_regular_price', $product->get_regular_price(), $product);
	$sale_price = apply_filters('wcpt_product_get_sale_price', $product->get_sale_price(), $product);	

	if(
		! $regular_price || 
		! $sale_price 
	){
		return;
	}

	$price_diff = round( $regular_price - $sale_price, 2 );

	if( ! $price_diff ){
		return;
	}

	$percent_diff = round( ( ( $price_diff / $regular_price ) * 100 ), $precision );
	
	$replace = array(
		'<span class="wcpt-on-sale__price-diff">' . wcpt_price( $price_diff, true ) . '</span>',
		'<span class="wcpt-on-sale__percent-diff">' . $percent_diff . '</span>',
	);

}else{
	return;

}

$search = array(
	'[price_diff]',
	'[percent_diff]',
);

echo '<span class="wcpt-on-sale '. $html_class .'" data-wcpt-precision="'. $precision .'">'.  str_replace( $search, $replace, wcpt_parse_2( $template, $product ) ) .'</span>';