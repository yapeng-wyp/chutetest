<?php
if( empty( $add_selected_label ) ){
  $add_selected_label = 'Add selected ([n]) to cart';
}

$search1 = array( // legacy
  "[n]",
  "[n2]"
);

$search2 = array(
  "{total_qty}",
  "{total_cost}"
);

$replace = array(
  '<span class="wcpt-total-selected"></span>',
  '<span class="wcpt-total-selected-cost">'. wcpt_price( '0', true ) .'</span>'
);

$add_selected_label = str_replace( $search1, $replace, $add_selected_label );
$add_selected_label = str_replace( $search2, $replace, $add_selected_label );

if( empty( $add_selected_label__single_item ) ){
  $add_selected_label__single_item = $add_selected_label;  
}

$add_selected_label__single_item = str_replace( $search2, $replace, $add_selected_label__single_item );  

if( empty( $add_selected__unselected_label ) ){
  $add_selected__unselected_label = 'Add selected to cart';
}

if( empty( $select_all_label ) ){
  $select_all_label = 'Select all';
}

if( empty( $clear_all_label ) ){
  $clear_all_label = 'Clear all';
}

if( $duplicate_enabled ){
  $html_class .= ' wcpt-duplicate-enabled ';
}

?>
<div class="wcpt-add-selected wcpt-add-selected--unselected <?php echo $html_class; ?>">
  <div class="wcpt-add-selected__add">
    <?php wcpt_icon('shopping-cart', 'wcpt-add-selected__cart-icon'); ?>
    <div class="wcpt-add-selected__add__selected wcpt-cart-checkbox-trigger--local">
      <?php echo $add_selected_label; ?>  
    </div>
    <div class="wcpt-add-selected__add__selected wcpt-add-selected__add__selected--single-item wcpt-cart-checkbox-trigger--local">
      <?php echo $add_selected_label__single_item; ?>  
    </div>
    <div class="wcpt-add-selected__add__unselected">
      <?php echo $add_selected__unselected_label; ?>  
    </div>
  </div>
  <?php if( ! empty( $select_all_enabled ) ): ?>
    <div class="wcpt-add-selected__select-all"><?php echo $select_all_label; ?></div>
  <?php endif; ?>
  <?php if( ! empty( $clear_all_enabled ) ): ?>  
    <div class="wcpt-add-selected__clear-all"><?php echo $clear_all_label; ?></div>
  <?php endif; ?>
</div>