<?php
if( ! WC()->cart ){
  return;
}

$total = 0;
foreach( WC()->cart->get_cart_contents() as $item ){
  if( 
    $product->get_type() == 'variation' &&
    $item['variation_id'] == $product->get_id()
  ){
    $total = $item['line_total'];

  }else if( 
    $product->get_type() == 'variable' &&
    $item['product_id'] == $product->get_id()
  ){
    $total += $item['line_total'];

  }else if( $item['product_id'] == $product->get_id() ){
    $total = $item['line_total'];

  }

}

$html_class .= " wcpt-total ";
if( ! empty( $include_total_in_cart ) ){
  $html_class .= " wcpt-total--include-total-in-cart wcpt-total--empty ";
}

if( ! $total ){
  $html_class .= " wcpt-total--empty ";
}

if( empty( $output_template ) ){
  $output_template = '{n}';
}

$output = '<div class="wcpt-total__output">'. str_replace( '{n}', wcpt_price( $total ), $output_template )  .'</div>';

if( empty( $no_output_template ) ){
  $no_output = '';
}else{
  $html_class .= " wcpt-total--no-output-template-enabled ";
  $no_output = '<div class="wcpt-total__no-output">'. esc_html( $no_output_template ) .'</div>';
}

?>
<div 
  class="<?php echo $html_class; ?>" 
  data-wcpt-in-cart-total="<?php echo $total; ?>" 
  data-wcpt-price="<?php echo wcpt_get_price_to_display(); ?>"
>
  <?php echo $output . $no_output; ?>
</div>