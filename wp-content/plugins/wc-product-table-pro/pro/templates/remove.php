<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$in_cart = false;
if( 
  WC() &&
  WC()->cart &&
  WC()->cart->cart_contents 
){
  foreach( WC()->cart->cart_contents as $key => $item ){
    if( 
      $item['product_id'] == $product->get_id() ||
      (
        $product->get_type() == 'variation' &&
        $item['variation_id'] == $product->get_id()
      )
    ){
      $in_cart = true;
    }
  }
}

$html_class .= ' wcpt-remove';
if( ! $in_cart ){
  $html_class .= ' wcpt-disabled';
}

if( empty( $title ) ){
  $title = __('Remove');
}

if( ! empty( $refresh_enabled ) ){
  $html_class .= ' wcpt-refresh-enabled ';
}

echo wcpt_icon( 'x', $html_class, null, null, $title, array('data-product_id'=> $product->get_id()) );
